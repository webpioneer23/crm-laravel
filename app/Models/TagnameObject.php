<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagnameObject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tag_name',
        'target_id',
        'type',
    ];
}
