<?php

namespace App\Http\Controllers\Api;

use App\Enums\ActivityStatus;
use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BankServiceCardResource;
use App\Http\Resources\BlogCardResource;
use App\Models\BankService;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        try {

            $indexData = [
                'bank_services' => $this->getBankServices(),
                'blogs' => $this->getBlogs(),
            ];

            return ApiResponse::Success('',$indexData);
        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در دریافت اطلاعات');
        }
    }

    private function getBankServices()
    {
        return BankServiceCardResource::collection(
            BankService::where('activity_status',ActivityStatus::ACTIVE->value)->take(7)->get()
        );
    }

    private function getBlogs()
    {
        return BlogCardResource::collection(
            Blog::where('activity_status',ActivityStatus::ACTIVE->value)
                ->orderBy('created_at','desc')->take(3)->get()
        );
    }
}
