<?php

namespace App\Models;

use App\Enums\SubscriptionStatuses;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
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
        return $this->activity_status === 'active' && $this->ends_at->isFuture();
    }

    public function cancel()
    {
        $this->update(['activity_status' => 'cancelled']);
    }

    public function renew(): void
    {
        $this->update([
            'starts_at' => now(),
            'ends_at' => now()->addDays($this->plan->duration_days),
            'activity_status' => SubscriptionStatuses::ACTIVE->value,
        ]);
    }
}
