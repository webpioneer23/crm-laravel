<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComplexAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'address_id',
        'complex_id',
    ];
}
