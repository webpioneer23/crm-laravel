<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingSuburb extends Model
{
    use HasFactory;
    protected $fillable = [
        'suburb_id',
        'suburb_fq_slug',
        'display_suburb_name',
        'sdnid',
        'dynamic_index',
        'suburb_name',
        'district_name',
        'region_name',
    ];
}
