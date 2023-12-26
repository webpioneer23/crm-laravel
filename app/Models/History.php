<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id", "type", "source", "source_id",
        "note"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSourceNameAttribute()
    {
        $source = $this->source;
        if ($source == 'contact') {
            $result = Contact::find($this->source_id);
            return $result->first_name;
        }
        if ($source == 'address') {
            $address = Address::find($this->source_id);
            if ($address) {
                return ($address->unit_number ? $address->unit_number . "/" : "") . $address->street . $address->city;
            }
        }
        return "";
    }
}
