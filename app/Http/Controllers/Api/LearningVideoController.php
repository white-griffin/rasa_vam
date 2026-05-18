<?php

namespace App\Http\Controllers\Api;

use App\Enums\ActivityStatus;
use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\LearningVideoResource;
use App\Models\LearningVideo;
use Illuminate\Http\Request;

class LearningVideoController extends Controller
{
    public function index()
    {
        try {
            $learningVideos = LearningVideoResource::collection(
                LearningVideo::query()
                    ->where('activity_status', ActivityStatus::ACTIVE->value)
                    ->get()
            );

            return ApiResponse::Success('',$learningVideos);

        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در دریافت اطلاعات');

        }
    }
}
