<?php

namespace App\Models;

use App\Traits\ImageTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ContentDescription extends Model implements HasMedia
{
    use ImageTrait, InteractsWithMedia, Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title'],
                'onUpdate' => true,
            ],
        ];
    }

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'section_id',
        'title',
        'description',
    ];

    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

        $this->addMediaCollection('other_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png','image/jpg', 'image/webp']);
    }
}
