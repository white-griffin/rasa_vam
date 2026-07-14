<?php

namespace App\Models;

use App\Services\SlugService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class Blog extends Model
{
    use SoftDeletes, Searchable;
    protected $guarded = ['id'];

    protected $appends = ['image_url'];


    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

    protected static function booted(): void
    {
        static::saving(function ($blog) {

            if (!$blog->slug && $blog->title) {
                $blog->slug = app(SlugService::class)
                    ->generate($blog);
            }

        });
    }
    public function searchableAs()
    {
        return 'blogs';
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? Storage::disk('public')->url($this->image)
            : null;
    }
}
