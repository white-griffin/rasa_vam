<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class BankService extends Model
{
    use SoftDeletes, Searchable;

    protected $guarded = ['id'];

    protected $casts = [
        'levels' => 'array',
        'form_fields' => 'array',
    ];

    protected $appends = ['image_url','icon_url'];


    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'short_description' => $this->short_description,
        ];
    }

    public function searchableAs()
    {
        return 'bank_services';
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? Storage::disk('public')->url($this->image)
            : null;
    }

    public function getIconUrlAttribute()
    {
        return $this->icon
            ? Storage::disk('public')->url($this->icon)
            : null;
    }

    public function faqs(): MorphMany
    {
        return $this->morphMany(Faq::class, 'faqable');
    }

    public function prices()
    {
        return $this->hasMany(BankServicePrice::class);
    }
}
