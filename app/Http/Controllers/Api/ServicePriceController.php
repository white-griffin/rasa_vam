<?php

namespace App\Http\Controllers\Api;

use App\Enums\ActivityStatus;
use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServicePriceResource;
use App\Models\ServicePrice;

class ServicePriceController extends Controller
{
    public function index()
    {
        try {
            $servicePrices = ServicePriceResource::collection(
                ServicePrice::query()
                    ->where('activity_status', ActivityStatus::ACTIVE->value)
                    ->get()
            );

            return ApiResponse::Success('',$servicePrices);

        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در دریافت اطلاعات');

        }
    }
}
