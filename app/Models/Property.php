<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "bedroom",
        "bathroom",
        "ensuite",
        "toilet",
        "garage",
        "carport",
        "open_car",
        "living",
        "house_size",
        "house_size_unit",
        "land_size",
        "land_size_unit",
        "energy_efficiency_rating",
        "extra",
    ];
}
