<?php

namespace App\Http\Controllers\Api;

use App\Enums\ActivityStatus;
use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BankServiceCardResource;
use App\Http\Resources\BankServiceResource;
use App\Models\BankService;
use Illuminate\Http\Request;

class BankServiceController extends Controller
{

    public function index()
    {
        try {
            $bankServices = BankServiceCardResource::collection(
                BankService::query()
                    ->where('activity_status', ActivityStatus::ACTIVE->value)
                    ->get()
            );

            return ApiResponse::Success('',$bankServices);

        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در دریافت اطلاعات');

        }
    }
    public function single($slug)
    {
        try {
            $bankService = BankServiceResource::make(
                BankService::query()
                ->where('slug', $slug)
                ->first()
            );

            return ApiResponse::Success('',$bankService);

        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در دریافت اطلاعات');

        }
    }
}
