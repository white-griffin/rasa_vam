<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class BankServiceRequest extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'additional_data' => 'array',
    ];

    public function getTitleAttribute(): string
    {
        return "{$this->bankService->title}: {$this->bank_service_price_title}";
    }

    public function order(): MorphOne
    {
        return $this->morphOne(Order::class, 'orderable');
    }

    public function bankService(): BelongsTo
    {
        return $this->belongsTo(BankService::class, 'bank_service_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
