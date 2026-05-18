<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\UserContact;

class UserContactController extends Controller
{
    public function create()
    {

        try {
            UserContact::query()->create([
                'name' => request('name'),
                'mobile' => request('mobile'),
                'subject' => request('subject'),
                'message' => request('message'),
            ]);

            return ApiResponse::Success('پیام با موفقیت ارسال شد');

        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در ارسال پیام');

        }

    }
}
