<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'first_name',
        'last_name',
        'full_name',
        'mobile',
        'email',
        'address',
        'photo',
        'tags',
        'notes',
        'address_type'
    ];

    public function getFullAddressAttribute()
    {
        $address  = Address::find($this->address);
        if ($address) {
            return "$address->street, $address->city ";
        }
        return $this->address;
    }

    public function getFullTagsAttribute()
    {
        $tags = json_decode($this->tags);
        if ($tags && count($tags) > 0) {
            $tag_list = Tag::whereIn('id', $tags)->pluck('name');
            $result = [];
            foreach ($tag_list as $key => $value) {
                array_push($result, $value);
            }
            return implode(",", $result);
        }
        return "";
    }
}
