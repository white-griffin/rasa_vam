<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\City;

class LocationController extends Controller
{
    public function cities()
    {
        try {
            $cities = City::all();
            return ApiResponse::Success($cities);
        }catch (\Exception $exception){
            return ApiResponse::Fail(500, 'خطا در دریافت اطلاعات');
        }
    }
}
