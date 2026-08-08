<?php

namespace App\Http\Controllers\Api;

use App\Enums\ActivityStatus;
use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Bank;

class BankController extends Controller
{
    public function index()
    {
        try {

            $banks = Bank::query()
                ->where('activity_status', ActivityStatus::ACTIVE->value)
                ->get();
            return ApiResponse::success('', $banks);

        } catch (\Exception $exception) {
            return ApiResponse::Fail(500, 'خطا در دریافت اطلاعات');
        }
    }
}
