<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'brand',
        'year',
        'price',
        'fuel_type',
        'transmission',
        'image_url',
        'description',
        'is_featured'
    ];
}