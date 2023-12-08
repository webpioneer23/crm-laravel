<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WishlistTag extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'wishlist_id', 'tag'
    ];
}
