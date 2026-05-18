<?php

namespace App\Http\Controllers\Api;

use App\Enums\ActivityStatus;
use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogCardResource;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index()
    {
        try {
            $blogs = Blog::query()
                ->where('activity_status', ActivityStatus::ACTIVE->value)
                ->paginate(6); // خودش page رو از query string میخونه

            return ApiResponse::Success('', [
                'data' => BlogCardResource::collection($blogs),
                'pagination' => [
                    'current_page' => $blogs->currentPage(),
                    'per_page' => $blogs->perPage(),
                    'total' => $blogs->total(),
                    'total_pages' => $blogs->lastPage(),
                ]
            ]);

        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در دریافت اطلاعات');

        }
    }
    public function single($slug)
    {
        try {
            $blog = BlogResource::make(
                Blog::query()
                    ->where('slug', $slug)
                    ->first()
            );

            return ApiResponse::Success('',$blog);

        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در دریافت اطلاعات');

        }
    }
}
