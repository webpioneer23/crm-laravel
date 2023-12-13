<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListingTag extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'tag_id', 'listing_id'
    ];
}
