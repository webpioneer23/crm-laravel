<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagObject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tag_id',
        'target_id',
        'type',
    ];
}
