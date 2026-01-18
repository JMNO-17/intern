<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ImageTrait;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Section extends Model implements HasMedia
{

   use ImageTrait, InteractsWithMedia;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'menu_id',
        'created_at',
        'updated_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function content_descriptions()
    {
        return $this->hasMany(ContentDescription::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function about()
    {
        return $this->hasMany(About::class);
    }

    protected static array $moduleMap = [
        'about' => 'About',
        'content_descriptions' => 'Content Description',
    ];

    public function getAvailableModules(): array
    {
        $modules = [];

        foreach (self::$moduleMap as $relation => $label) {
            if ($this->$relation()->exists()) {
                $modules[] = $label;
            }
        }

        return $modules;
    }

    public function registerMediaCollections(): void
    {
         $this->addMediaCollection('featured_image')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
            
        $this->addMediaCollection('other_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png','image/jpg', 'image/webp']);
    }

    
}
