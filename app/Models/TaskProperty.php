<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id', 'type', 'property_id'
    ];
}
