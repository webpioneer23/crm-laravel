<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'address_id',
        'contact_id',
    ];
}
