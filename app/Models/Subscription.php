<?php

namespace App\Models;

use App\Enums\SubscriptionStatuses;
use App\Traits\Purchaseable;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use Purchaseable;
    protected $guarded = ['id'];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function isActive(): bool
    {
        return $this->activity_status === SubscriptionStatuses::ACTIVE->value
            && $this->ends_at?->isFuture();
    }

    public function cancel(): void
    {
        $this->update([
            'activity_status' => SubscriptionStatuses::CANCELLED->value,
        ]);
    }

    public function renew(): void
    {
        // ۱. پیدا کردن آخرین اشتراک فعال یا منقضی شده کاربر برای این طرح
        $lastSubscription = Subscription::query()
            ->where('user_id', $this->user_id)
            ->where('plan_id', $this->plan_id)
            ->orderBy('ends_at', 'desc')
            ->first();

        // ۲. محاسبه تاریخ شروع (اگر اشتراک قبلی داشته و هنوز منقضی نشده، شروع جدید از انتهای قبلی است)
        $startDate = ($lastSubscription && $lastSubscription->ends_at->isFuture())
            ? $lastSubscription->ends_at
            : now();

        // ۳. محاسبه تاریخ پایان بر اساس duration در جدول plans
        $duration = $this->plan->duration_days; // فرض بر اینکه در جدول plans هست
        $endDate = $startDate->copy()->addDays($duration);

        // ۴. بروزرسانی و فعال‌سازی
        $this->update([
            'starts_at' => $startDate,
            'ends_at' => $endDate,
            'activity_status' => SubscriptionStatuses::ACTIVE->value,
        ]);
    }

    protected function handlePurchaseCompletion(): void
    {
        $this->renew();
    }
}
