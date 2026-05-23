<?php

namespace App\Http\Controllers\Api;

use App\Enums\ActivityStatus;
use App\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        try {
            return ApiResponse::Success('عملیات موفق',[
                'subscription' => $request->user()->activeSubscription,
                'has_active' => $request->user()->hasActiveSubscription()

            ]);
        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در عملیات');
        }
    }

    public function plans()
    {
        try {
            $plans = Plan::where('activity_status', ActivityStatus::ACTIVE)->get();
            return ApiResponse::Success('عملیات موفق',$plans);
        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در عملیات');
        }
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);
        try {

            $plan = Plan::query()
                ->findOrFail($request->plan_id);

            if ($active = $request->user()->activeSubscription) {
                $active->cancel();
            }

            $subscription = Subscription::query()
                ->create([
                'user_id' => $request->user()->id,
                'plan_id' => $plan->id,
                'starts_at' => now(),
                'ends_at' => now()->addDays($plan->duration_days),
                'status' => 'active'
            ]);

            return ApiResponse::Success('اشتراک فعال شد',[
                'subscription' => $subscription->load('plan')
            ]);

        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در عملیات');
        }
    }

    public function cancel(Request $request)
    {
        try {
            $subscription = $request->user()->activeSubscription;

            if (!$subscription) {
                return ApiResponse::Fail(404,'اشتراک فعالی وجود ندارد');
            }

            $subscription->cancel();

            return ApiResponse::Success('اشتراک لغو شد');

        }catch (\Exception $exception){
            return ApiResponse::Fail(500,'خطا در انجام عملیات');
        }
    }

}
