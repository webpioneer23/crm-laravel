<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactRelationship extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'source_id', 'target_id', 'relationship', 'note'
    ];

    public function getTargetAttribute()
    {
        $target = Contact::find($this->target_id);
        return $target;
    }
}
