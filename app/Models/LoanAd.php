<?php

namespace App\Models;

use App\Enums\LoanStatuses;
use App\Traits\Purchaseable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanAd extends Model
{
    use SoftDeletes,Purchaseable;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    protected function handlePurchaseCompletion(): void
    {
        $this->activity_status = LoanStatuses::ACTIVE->value;
        $this->save();
    }
}
