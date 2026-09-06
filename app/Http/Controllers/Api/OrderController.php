<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatuses;
use App\Enums\PaymentGateways;
use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\BankServiceRequest;
use App\Models\LoanAd;
use App\Models\Order;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{

    public function index()
    {
        try {
            $orders = Order::with(['payments', 'orderable'])
                ->where('user_id', auth()->id())
                ->latest()
                ->paginate(15);

            return ApiResponse::success('',[
                'data' => OrderResource::collection($orders),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'per_page' => $orders->perPage(),
                    'total' => $orders->total(),
                    'total_pages' => $orders->lastPage(),
                ]
            ]);
        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در دریافت اطلاعات');
        }
    }
    public function show(Order $order)
    {
        try {
            return ApiResponse::Success('',OrderResource::make($order));
        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در دریافت اطلاعات');
        }
    }

    public function create(){
        $validated = \request()->validate([
            'type' => ['required', 'in:plan,loan_ad,bank_service'],
            'id'   => ['required', 'integer'],
        ]);
        DB::beginTransaction();
        try {
            $type = $validated['type'];
            $id = $validated['id'];

            $product = match ($type) {
                'plan' => Plan::query()->findOrFail($id),
                'loan_ad' => LoanAd::query()->findOrFail($id),
                'bank_service' => BankServiceRequest::query()->findOrFail($id),
            };

            $price = match ($type) {
                'plan' => $product->price,
                'loan_ad' => 50000,
                'bank_service' => $product->bank_service_price_amount,
            };

            $order = Order::query()->create([
                'user_id' => auth()->id(),
                'order_number' => $this->generateOrderNumber(),
                'orderable_type' => get_class($product),
                'orderable_id' => $product->id,
                'order_status' => OrderStatuses::PENDING->value,
                'total_amount' => $price
            ]);
            $payment = (new PaymentController())->sendToGateway($order,PaymentGateways::OMIDPAY);

            if ($payment['success']){
                DB::commit();
                return ApiResponse::success('انتقال به درگاه . . .',[
                    'pay_url' => $payment['url'],
                    'token' => $payment['token'],
                ]);
            }else{
                DB::rollback();
                return ApiResponse::Fail(422, 'خطا در اتصال به درگاه');
            }

        }catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ApiResponse::Fail(422, 'اطلاعات ورودی نامعتبر است');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollback();
            return ApiResponse::Fail(404, 'محصول یافت نشد');
        } catch (\Throwable $e) {
            DB::rollback();
            return ApiResponse::Fail(500, 'خطا در ایجاد سفارش');
        }
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
    }
}
