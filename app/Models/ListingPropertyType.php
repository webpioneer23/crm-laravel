<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingPropertyType extends Model
{
    use HasFactory;
    protected $fillable = [
        'listing_property_type_code',
        'listing_category_code',
    ];
}
