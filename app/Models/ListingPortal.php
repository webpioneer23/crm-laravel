<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListingPortal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'base_url',
        'key',
        'office_id',
        'other',
        'active',
    ];
}
