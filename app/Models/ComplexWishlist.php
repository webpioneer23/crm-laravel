<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComplexWishlist extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'contact_id', 'complex_id'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function tags()
    {
        return $this->hasMany(WishlistTag::class, 'wishlist_id', 'id');
    }
}
