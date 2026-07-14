<?php

namespace App\Models;

use App\Services\SlugService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::saving(function ($plan) {

            if (!$plan->slug && $plan->title) {
                $plan->slug = app(SlugService::class)
                    ->generate($plan);
            }

        });
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
