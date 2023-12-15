<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractContact extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "contract_id",
        "contact_id",
    ];
}
