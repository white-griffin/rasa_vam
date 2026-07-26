<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BankServiceRequestResource;
use App\Models\BankServicePrice;
use App\Models\BankServiceRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BankServiceRequestController extends Controller
{
    public function index()
    {
        try {
            $requests = BankServiceRequestResource::collection(
                BankServiceRequest::query()
                    ->where('user_id',auth()->user()->id)
                    ->get()
            );

            return ApiResponse::success('عملیات موفق',$requests);
        }catch (\Exception $exception){
            return ApiResponse::Fail(Response::HTTP_INTERNAL_SERVER_ERROR,'خطا در دریافت اطلاعات');
        }
    }

    public function create()
    {
        request()->validate([
            'bank_service_id' => 'required',
            'price_id' => 'required',
            'additional_data' => 'required|array'

        ], [
            'bank_service_id.required' => 'سرویس را انتخاب کنید',
            'price_id.required' => 'نوع درخواست را انتخاب کنید',
            'additional_data.required' => 'اطلاعات تکمیلی را ارسال کنید',
        ]);

        DB::beginTransaction();
        try {
            $request = BankServiceRequest::query()
                ->create($this->requestData())
                ->refresh();
            DB::commit();
            return ApiResponse::success('درخواست ثبت شده و در انتظار پرداخت',BankServiceRequestResource::make($request));
        }catch (\Exception $exception){
            DB::rollBack();
            return ApiResponse::Fail(Response::HTTP_INTERNAL_SERVER_ERROR,'خطا در ثبت درخواست');
        }
    }

    private function requestData()
    {

        $bankServicePrice = BankServicePrice::query()->findOrFail(request('price_id'));
        return [
            'user_id' => auth()->user()->id,
            'bank_service_id' => request('bank_service_id'),
            'bank_service_price_title' => $bankServicePrice->title,
            'bank_service_price_amount' => $bankServicePrice->price,
            'additional_data' => request('additional_data'),
        ];
    }

}
