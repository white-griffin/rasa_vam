<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BankServiceResource extends JsonResource
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
            'title' => $this->title,
            'short_description' => $this->short_description,
            'description_title' => $this->description_title,
            'description_text' => $this->description_text,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'image' => $this->image_url,
            'slider_image' => $this->slider_image_url,
            'icon' => $this->icon_url,
            'slug' => $this->slug,
            'prices' => $this->prices->makeHidden(['created_at', 'updated_at']),
            'levels' => collect($this->levels)->map(function ($level) {
                return [
                    'title'       => $level['title'],
                    'image'       => $level['image'] ?Storage::disk('public')->url($level['image']): null,
                    'description' => $level['description'],
                ];
            }),
            'form_fields' => $this->getFormFieldsAttribute($this->form_fields),
            'faqs' => FaqResource::collection($this->faqs)
        ];
    }

    public function getFormFieldsAttribute($fields)
    {

        // تبدیل options از string به array
        return collect($fields)->map(function ($field) {
            if (isset($field['options']) && is_string($field['options'])) {
                $field['options'] = array_filter(
                    array_map('trim', explode("\n", $field['options']))
                );
            }
            return $field;
        })->toArray();
    }

}
