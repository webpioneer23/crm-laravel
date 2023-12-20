<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appraisal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'address_id',
        'contact_id',
        'price_min',
        'price_max',
        'appraisal_value',
        'due_date',
        'status',
        'delivered_date',
        'delivery_type',
        'reason_lost',
        'interest',
    ];

    public function address()
    {
        $a = $this->hasOne(Address::class, 'id', 'address_id');
        return $a;
    }

    public function contact()
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id');
    }
}
