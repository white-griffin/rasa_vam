<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'mobile' => $this->user->mobile,
            'email' => $this->user->email,
            'gender' => $this->gender,
            'avatar' => $this->avatar_url,
            'birth_date' => $this->birth_date,
            'national_code' => $this->national_code,
            'province' => !is_null($this->province_id) ? [
                'id' => $this->province->id,
                'name' => $this->province->name
            ] : null,
            'city' => !is_null($this->city_id) ?[
                'id' => $this->city->id,
                'name' => $this->city->name
            ] : null,
            'address' => $this->address,
            'subscription' => SubscriptionResource::make($this->user->activeSubscription),

        ];
    }
}
