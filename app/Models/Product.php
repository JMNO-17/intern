<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\Category;
use App\Traits\ImageTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements HasMedia
{
    use ImageTrait, InteractsWithMedia, Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name'],
                'onUpdate' => true,
            ],
        ];
    }

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
        $this->addMediaCollection('featured_image')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

        $this->addMediaCollection('other_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png','image/jpg', 'image/webp']);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
