<?php

namespace App\Services\Search;

use App\Http\Resources\BankServiceCardResource;
use App\Http\Resources\BlogCardResource;
use App\Models\BankService;
use App\Models\Blog;

class MultiModelSearchService
{
    public function search(string $query, int $perPage = 10): array
    {
        $bankServices = BankServiceCardResource::collection(
            BankService::search($query)->get()
        );
        
        $blogs = BlogCardResource::collection(
            Blog::search($query)->get()
        );

        return [
            'bank_services' => [
                'data' => $bankServices,
                'count' => $bankServices->count(),
            ],
            'blogs' => [
                'data' => $blogs,
                'count' => $blogs->count(),
            ],
            'total' => $bankServices->count() + $blogs->count(),
        ];
    }

    public function searchPaginated(string $query, int $perPage = 10, int $page = 1): array
    {
        $bankServices = BankService::search($query)->paginate($perPage, 'page', $page);
        $blogs = Blog::search($query)->paginate($perPage, 'page', $page);

        return [
            'bank_services' => [
                'data' => BankServiceCardResource::collection($bankServices->items()),
                'total' => $bankServices->total(),
                'per_page' => $bankServices->perPage(),
                'current_page' => $bankServices->currentPage(),
                'last_page' => $bankServices->lastPage(),
            ],
            'blogs' => [
                'data' => BlogCardResource::collection($blogs->items()),
                'total' => $blogs->total(),
                'per_page' => $blogs->perPage(),
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
            ],
        ];
    }

    public function searchWithLimit(string $query, int $bankServicesLimit = 5, int $blogsLimit = 5): array
    {
        $bankServices = BankServiceCardResource::collection(
            BankService::search($query)
                ->take($bankServicesLimit)
                ->get()
        );
        $blogs = BlogCardResource::collection(
            Blog::search($query)
                ->take($blogsLimit)
                ->get()
        );

        return [
            'bank_services' => $bankServices,
            'blogs' => $blogs,
            'total' => $bankServices->count() + $blogs->count(),
        ];
    }
}
