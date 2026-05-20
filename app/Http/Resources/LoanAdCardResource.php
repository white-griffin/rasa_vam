<?php

namespace App\Http\Resources;

use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class LoanAdCardResource extends JsonResource
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
            'bank' => $this->bank->title,
            'city' => $this->city->name,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => Str::limit(strip_tags($this->description), 100),
            'amount' => $this->amount,
            'price' => $this->price,
            'created_at' => Verta::instance($this->created_at)->format('d F Y')
        ];
    }
}
