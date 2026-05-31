<?php

namespace App\Http\Controllers\Api;

use App\Enums\LoanStatuses;
use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoanAdCardResource;
use App\Http\Resources\LoanAdsResource;
use App\Models\LoanAd;
use Illuminate\Http\Request;

class LoanAdController extends Controller
{
    public function index(Request $request)
    {
        try {
            $loans = LoanAd::query()
                ->where('activity_status', LoanStatuses::ACTIVE->value)
                ->when($request->filled('city_id'), function ($q) use ($request) {
                    $q->where('city_id', $request->integer('city_id'));
                })
                ->when($request->filled('bank_id'), function ($q) use ($request) {
                    $q->where('bank_id', $request->integer('bank_id'));
                })
                ->when($request->filled('amount_min'), fn($q) =>
                    $q->where('amount', '>=', $request->integer('amount_min')))
                ->when($request->filled('amount_max'), fn($q) =>
                    $q->where('amount', '<=', $request->integer('amount_max')))
                ->paginate(6);

            return ApiResponse::Success('', [
                'data' => LoanAdCardResource::collection($loans),
                'pagination' => [
                    'current_page' => $loans->currentPage(),
                    'per_page' => $loans->perPage(),
                    'total' => $loans->total(),
                    'total_pages' => $loans->lastPage(),
                ]
            ]);
        } catch (\Exception $e) {
            return ApiResponse::Fail(500, 'خطا در دریافت اطلاعات');
        }
    }


    public function single($id)
    {
        try {
            $loan = LoanAdsResource::make(
                LoanAd::query()
                    ->findOrFail($id)
            );
            return ApiResponse::Success('', $loan);
        } catch (\Exception $e) {
            return ApiResponse::Fail(500, 'خطا در دریافت اطلاعات');

        }
    }

    public function store()
    {
        try {
            $loan = LoanAd::query()
                ->create([
                    'user_id' => auth()->id(),
                    'bank_id' => request('bank_id'),
                    'city_id' => request('city_id'),
                    'title' => request('title'),
                    'description' => request('description'),
                    'amount' => request('amount'),
                    'interest' => request('interest'),
                    'price' => request('price'),
                    'activity_status' => LoanStatuses::PENDING->value,
                ]);
            return ApiResponse::Success('آگهی ثبت شد و بعد از پرداخت فعال می شود', $loan);
        } catch (\Exception $e) {
            return ApiResponse::Fail(500, 'خطا درثبت آگهی');
        }
    }
}
