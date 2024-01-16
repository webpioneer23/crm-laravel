<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingPortalMap extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'portal_id',
        'status',
        'push_id',
        'note'
    ];
}
