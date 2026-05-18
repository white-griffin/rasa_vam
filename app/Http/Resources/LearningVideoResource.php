<?php

namespace App\Http\Resources;

use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LearningVideoResource extends JsonResource
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
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail_url,
            'video_url' => $this->video_full_url,
            'created_at' => Verta::instance($this->created_at)->format('d F Y')
        ];
    }
}
