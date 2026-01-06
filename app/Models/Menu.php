<?php

namespace App\Models;

use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory, ImageTrait;

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
        'route_name',
        'slug',
        'status',
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function content_descriptions()
    {
        return $this->hasMany(ContentDescription::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
