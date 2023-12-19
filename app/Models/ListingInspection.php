<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListingInspection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'listing_id', 'inspection_date', 'start_time',
        'end_time', 'inspection_type', 'inspection_booking_setting',
    ];
}
