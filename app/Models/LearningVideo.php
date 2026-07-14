<?php

namespace App\Models;

use App\Services\SlugService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LearningVideo extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['thumbnail_url','video_full_url'];

    protected static function booted(): void
    {
        static::saving(function ($video) {

            if (!$video->slug && $video->title) {
                $video->slug = app(SlugService::class)
                    ->generate($video);
            }

        });
    }
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail
            ? Storage::disk('public')->url($this->thumbnail)
            : null;
    }

    public function getVideoFullUrlAttribute()
    {
        return $this->attributes['video_url']
            ? Storage::disk('public')->url($this->attributes['video_url'])
            : null;
    }
}
