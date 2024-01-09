<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadObject extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'target_name',
        'target_id',
    ];
}
