<?php

namespace App\Http\Controllers\Api;

use App\Enums\ActivityStatus;
use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\NewsLetter;

class NewsLetterController extends Controller
{
    public function subscribe()
    {
        try {
            NewsLetter::query()->create([
                'email' => request('email'),
            ]);
            return ApiResponse::Success('عضویت تایید شد');
        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در عضویت');
        }
    }

    public function unSubscribe()
    {
        try {
            $unSubscription = NewsLetter::query()
                ->where('email', request('email'))
                ->first()
                ->update([
                    'activity_status' => ActivityStatus::INACTIVE->value
                ]);

            return ApiResponse::Success('عضویت لغو شد');
        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در لغو ');
        }
    }
}
