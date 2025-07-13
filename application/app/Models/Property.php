<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\PropertyType;
use App\Models\PropertyStatus;
use App\Models\PropertyAvailability;

class Property extends Model
{
    use HasFactory;


    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'videos' => 'array',
        'price' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'type' => PropertyType::class,
        'status' => PropertyStatus::class,
        'availability' => PropertyAvailability::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
