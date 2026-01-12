<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\Category;
use App\Traits\ImageTrait;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements HasMedia
{
    use ImageTrait, InteractsWithMedia;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'description',
        'price',
        'status',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_image')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
