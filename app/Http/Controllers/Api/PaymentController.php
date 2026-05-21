<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatuses;
use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Evryn\LaravelToman\CallbackRequest;
use Evryn\LaravelToman\Facades\Toman;
use Exception;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{


    public function sendToGateway($order)
    {
        DB::beginTransaction();
        try {
            $request = Toman::amount($order->total_amount)
                ->description($order->description)
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
                return ApiResponse::success('انتقال به درگاه . . .',[
                    'pay_url' => $request->pay()->getTargetUrl()
                ]);
            }

            DB::commit();
            if ($request->failed()) {
                // Handle transaction request failure.
                return ApiResponse::Fail('500','خطا در اتصال به درگاه');
            }

        }catch (\Exception $exception){
            DB::rollBack();
            return ApiResponse::Fail(500, $exception->getMessage());
        }
    }

    public function callbackGateway(CallbackRequest $request){

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




}
