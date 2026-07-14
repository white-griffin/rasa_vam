<?php

namespace App\Http\Controllers\Api;

use App\Enums\BankServiceRequestStatuses;
use App\Enums\LoanStatuses;
use App\Enums\OrderStatuses;
use App\Enums\PaymentGateways;
use App\Enums\PaymentStatuses;
use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\BankServiceRequest;
use App\Models\Payment;
use App\Models\Subscription;
use Evryn\LaravelToman\CallbackRequest;
use Evryn\LaravelToman\Facades\Toman;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{

    public function sendToGateway($order,$gateway)
    {
        return match ($gateway) {
            PaymentGateways::ZARINPAL   => $this->generateZarinpalToken($order),
            PaymentGateways::OMIDPAY    => $this->generateOmidPayToken($order),
            default       => throw new \InvalidArgumentException("درگاه [{$gateway}] پشتیبانی نمی‌شود"),
        };
    }

    public function generateZarinpalToken($order)
    {
        DB::beginTransaction();
        try {
            $request = Toman::amount($order->total_amount)
                ->description($order->orderable->title.' خرید : ')
                ->callback(route('payment.callback'))
                ->request();

            if ($request->successful()) {
                // Store created transaction details for verification
                $transactionId = $request->transactionId();

                $payment = Payment::query()->create([
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'amount' => $order->total_amount,
                    'transaction_id' => $transactionId,
                ]);

                DB::commit();
                // Redirect to payment URL
                return [
                    'success' => true,
                    'url' => $request->pay()->getTargetUrl(),
                ];
            }

            DB::commit();
            if ($request->failed()) {
                // Handle transaction request failure.
                return [
                    'success' => false,
                    'message' => $request->message(),
                ];
            }

        }catch (\Exception $exception){
            DB::rollBack();
            return [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function callbackZarinpalGateway(CallbackRequest $request){

        DB::beginTransaction();
        try {

            $paymentRecord = Payment::where('transaction_id',$request->transactionId())
                ->with('order')
                ->first();
            $payment = $request->amount($paymentRecord->amount)->verify();

            if ($payment->successful()) {

                // Store the successful transaction details
                $refId = $payment->referenceId();

                $paymentRecord->update([
                    'reference_id' => $refId,
                    'payment_status' => OrderStatuses::PAID->value,
                    'paid_at' => now()->timestamp,
                ]);
                $paymentRecord->order->update([
                    'order_status' => OrderStatuses::PAID->value,
                    'paid_at' => now()->timestamp,
                ]);

                $paymentRecord->order->orderable->purchaseCompleted();

                DB::commit();
                return view('user.payments.success-pay');
            }

            if ($payment->alreadyVerified()) {
                DB::commit();
                return view('user.payments.already-payed');
            }

            if ($payment->failed()) {
                $paymentRecord->update([
                    'payment_status' => OrderStatuses::FAILED->value,
                ]);
                $paymentRecord->order->update([
                    'payment_status' => OrderStatuses::FAILED->value,
                ]);
                DB::commit();
                return view('user.payments.failed-pay');
            }
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return view('user.payments.failed-pay');
        }

    }


    public function generateOmidPayToken($order)
    {
        $url = 'https://ref.omidpayment.ir/ref-payment/RestServices/mts/generateTokenWithNoSign/';

        $data = [
            "WSContext" => [
                "UserId" => "411523672",
                "Password" => "788003"
            ],
            "TransType" => "EN_GOODS",
            "ReserveNum" => $order->order_number,
            "MerchantId" => "411523672",
            "TerminalId" => "41856066",
            "Amount" => $order->total_amount,
            "ProductId" => "", // در صورت نیاز پر شود
            "GoodsReferenceID" => "987654",
            "MerchatGoodReferenceID" => "111",
            "MobileNo" => $order->user->mobile,
            "Email" => $order->user->email ?? "mohamadamin.zanguee@rasavam.com",
            "RedirectUrl" => 'https://rasavam.com/payment'
        ];

        DB::beginTransaction();
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, $data);

            $responseData = $response->json(); // یا $response->body() برای دریافت رشته خام

            // بررسی وضعیت پاسخ
            if ($responseData['Result'] == 'erSucceed') {
                // پاسخ موفقیت آمیز بود

                // اینجا $responseData حاوی اطلاعاتی است که از API دریافت کرده‌اید
                // مثلاً توکن تولید شده
                $payment = Payment::query()->create([
                    'order_id' => $order->id,
                    'gateway' => PaymentGateways::OMIDPAY->value,
                    'amount' => $order->total_amount,
                    'authority' => $responseData['Token'],
                    'transaction_id' => $order->order_number
                ]);

                DB::commit();

                return [
                    'success' => true,
                    'url' => 'https://omid.shaparak.ir/_ipgw_//MainTemplate/payment/',
                    'token' => $responseData['Token'],
                ];

            } else {
                // پاسخ خطا بود (مثلاً 4xx یا 5xx)
                $statusCode = $response->status();
                $errorBody = $response->json(); // یا $response->body()

                $payment = Payment::query()->create([
                    'order_id' => $order->id,
                    'amount' => $order->total_amount,
                    'gateway' => PaymentGateways::OMIDPAY->value,
                    'payment_status' => PaymentStatuses::FAILED->value,
                    'transaction_id' => $order->order_number,
                    'gateway_response' => $errorBody
                ]);

                DB::commit();
                return [
                    'success' => false,
                    'message' => "API request failed with status {$statusCode}.",
                    'error' => $errorBody
                ];
            }

        } catch (\Exception $e) {
            DB::rollBack();
            // خطای در حین اجرای درخواست (مثلاً خطای شبکه)
            return [
                'success' => false,
                'message' => 'An error occurred while making the API request.',
                'error' => $e->getMessage()
            ];
        }
    }

    public function callbackOmidPay(Request $request)
    {
        DB::beginTransaction();
        try {
            $payment = Payment::query()
                ->where('transaction_id',$request->ResNum)
                ->first();

            if ($request->State == 'OK'){
                $payment->update([
                    'reference_id' => $request->RefNum,
                    'gateway_response' => $request->all(),
                    'paid_at' => now()->timestamp
                ]);
                DB::commit();

                $verify = $this->verifyOmidPay($request->RefNum,$payment->authority);
                if ($verify){

                    match ($payment->order->orderable_type) {
                        'App\Models\LoanAd'   => $this->handleLoanAd($payment->order->orderable),
                        'App\Models\Plan'   => $this->handlePlan($payment->order->orderable),
                        'App\Models\BankServiceRequest'  => $this->handleServiceRequest($payment->order->orderable),
                        default       => throw new \InvalidArgumentException("محصول پشتیبانی نمیشود"),
                    };

                    return view('user.payments.success-pay');
                }else{
                    return view('user.payments.failed-pay');
                }
            }else{
                $payment->update([
                    'payment_status' => PaymentStatuses::CANCELLED->value,
                ]);

                DB::commit();
                return view('user.payments.failed-pay');

            }
        }catch (\Exception $e){
            DB::rollBack();
            dd($e);

        }
    }
    public function verifyOmidPay($refNum,$token)
    {
        $url = 'http://ref.sayancard.ir/ref-payment/RestServices/mts/verifyMerchantTrans/';

        $data = [
            "WSContext" => [
                "UserId" => "411523672",
                "Password" => "788003"
            ],
            "RefNum" => $refNum,
            "Token" => $token,
        ];

        DB::beginTransaction();
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, $data);

            $responseData = $response->json();
            $payment = Payment::query()
                ->where('authority',$token)
                ->first();

            // بررسی وضعیت پاسخ
            if ( $responseData['Result'] == 'erSucceed') {
                // پاسخ موفقیت آمیز بود

                $payment->update([
                    'payment_status' => PaymentStatuses::SUCCESS->value,
                ]);

                $payment->order()->update([
                    'order_status' => OrderStatuses::PAID->value,
                    'paid_at' => now()->timestamp
                ]);

                DB::commit();

                return true;

            } else {
                // پاسخ خطا بود (مثلاً 4xx یا 5xx)
                $statusCode = $response->status();
                $errorBody = $response->json(); // یا $response->body()

                $payment->update([
                    'payment_status' => PaymentStatuses::FAILED->value,
                    'gateway_response' => [
                        'status' => $statusCode,
                        'error' => $errorBody
                    ]
                ]);
                DB::commit();
                return false;

            }

        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }


    private function handleLoanAd($product)
    {
        $product->update([
            'activity_status' => LoanStatuses::ACTIVE->value,
        ]);
    }

    private function handlePlan($product)
    {
        if ($active = auth()->user()->activeSubscription) {
            $active->cancel();
        }

        $subscription = Subscription::query()
            ->create([
                'user_id' => auth()->user()->id,
                'plan_id' => $product->id,
                'starts_at' => now(),
                'ends_at' => now()->addDays($product->duration_days),
                'status' => 'active'
            ]);
    }

    private function handleServiceRequest($product)
    {
        $product->update([
            'status' => BankServiceRequestStatuses::IN_REVIEW->value,
        ]);
    }


}
