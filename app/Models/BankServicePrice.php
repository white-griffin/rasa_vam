<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankServicePrice extends Model
{
    protected $guarded = ['id'];

    public function bankService(): BelongsTo
    {
        return $this->belongsTo(BankService::class);
    }
}
