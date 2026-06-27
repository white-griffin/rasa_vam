<?php

namespace App\Http\Resources;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Subscription */
class SubscriptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'plan' => PlanResource::make($this->whenLoaded('plan')),
            'start_date' => $this->starts_at,
            'end_date' => $this->ends_at,
            'is_active' => $this->isActive(),
        ];
    }
}
