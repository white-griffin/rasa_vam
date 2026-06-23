<?php

namespace App\Services\Search;

use App\Http\Resources\BankServiceCardResource;
use App\Http\Resources\BlogCardResource;
use App\Models\BankService;
use App\Models\Blog;
use Illuminate\Pagination\LengthAwarePaginator;

class MultiModelSearchService
{
    public function search(string $query, int $perPage = 10): array
    {
        // دریافت نتایج به صورت Collection
        $bankItems = BankService::search($query)->get()->map(fn($item) => [
            'type' => 'bank-service',
            ...BankServiceCardResource::make($item)->resolve(),
        ]);

        $blogItems = Blog::search($query)->get()->map(fn($item) => [
            'type' => 'post',
            ...BlogCardResource::make($item)->resolve(),
        ]);

        // ترکیب دو کالکشن و یکپارچه‌سازی ایندکس‌ها
        $items = $bankItems->concat($blogItems)->values();

        return [
            'data' => $items,
            'count' => $items->count(),
        ];
    }




    public function searchPaginated(string $query, int $perPage = 10, int $page = 1): array
    {
        $bankServices = BankService::search($query)->get()->map(function ($item) {
            return [
                'type' => 'bank-service',
                ...BankServiceCardResource::make($item)->resolve(),
            ];
        });

        $blogs = Blog::search($query)->get()->map(function ($item) {
            return [
                'type' => 'post',
                ...BlogCardResource::make($item)->resolve(),
            ];
        });

        $items = $bankServices
            ->concat((array)$blogs)
            ->values();

        $total = $items->count();

        $paginatedItems = $items->slice(($page - 1) * $perPage, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $paginatedItems,
            $total,
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return [
            'data' => $paginator->items(),
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
        ];
    }


    public function searchWithLimit(string $query, int $bankServicesLimit = 5, int $blogsLimit = 5): array
    {
        $bankServices = BankService::search($query)
            ->take($bankServicesLimit)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'bank-service',
                    ...BankServiceCardResource::make($item)->resolve(),
                ];
            });

        $blogs = Blog::search($query)
            ->take($blogsLimit)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'post',
                    ...BlogCardResource::make($item)->resolve(),
                ];
            });

        $items = $bankServices
            ->concat((array)$blogs)
            ->values();

        return [
            'data' => $items,
            'total' => $items->count(),
        ];
    }

}
