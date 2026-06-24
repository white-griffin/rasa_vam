<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;

class LocationController extends Controller
{
    public function provinces()
    {
        try {
            $provinces = Province::all();
            return ApiResponse::Success('عملیات موفق', $provinces);
        } catch (\Exception $exception) {
            return ApiResponse::Fail(500, 'خطا در دریافت اطلاعات');
        }
    }

    public function cities()
    {
        try {
            $cities = City::query()
                ->when(
                    request('province_id'), fn($q) =>
                    $q->where('province', request('province_id'))
                )
                ->get();
            return ApiResponse::Success('عملیات موفق', $cities);
        } catch (\Exception $exception) {
            return ApiResponse::Fail(500, 'خطا در دریافت اطلاعات');
        }
    }
}
