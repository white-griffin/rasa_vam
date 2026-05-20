<?php

namespace App\Http\Resources;

use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class LoanAdsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_data' => [
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'mobile' => $this->user->mobile,
            ],
            'bank' => $this->bank->title,
            'city' => $this->city->name,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'amount' => $this->amount,
            'interest' => $this->intereset,
            'price' => $this->price,
            'created_at' => Verta::instance($this->created_at)->format('d F Y')
        ];
    }
}
