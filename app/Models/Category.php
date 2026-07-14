<?php

namespace App\Models;

use App\Services\SlugService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use SoftDeletes;

    protected $guarded =['id'];

    protected $appends = ['image_url'];


    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    protected static function booted(): void
    {
        static::saving(function ($category) {

            if (!$category->slug && $category->title) {
                $category->slug = app(SlugService::class)
                    ->generate($category);
            }

        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function services()
    {
        return $this->hasMany(BankService::class, 'category_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? Storage::disk('public')->url($this->image)
            : null;
    }
}
