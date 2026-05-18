<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankServiceCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'short_description' => $this->short_description,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'image' => $this->image_url,
            'icon' => $this->icon_url,
            'slug' => $this->slug,
        ];
    }
}
