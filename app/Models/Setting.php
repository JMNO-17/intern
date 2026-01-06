<?php

namespace App\Models;

use App\Traits\ImageTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory;
    use ImageTrait;
    use SoftDeletes;

    public const IMAGE_PATH = 'uploads/settings';

    public const DEFAULT = [
        'favicon' => 'favicon.png',
        'site_logo' => 'site_logo.png',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'key',
        'value',
        'display_name',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }
}
