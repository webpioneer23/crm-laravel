<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'property_type',
        'google_address',
        'unit_number',
        'street',
        'building',
        'suburb',
        'city',
    ];
}
