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
        'photo',
        'notes',
        'rent_type',

        'listing_types',
        'land_size_min',
        'land_size_max',
        'land_size_unit',
        'floor_size_min',
        'floor_size_max',
        'floor_size_unit',
        'car_spaces_min',
        'car_spaces_max',
        'suburbs',
        'comments',

    ];

    public function getFullAddressAttribute()
    {
        $contact_address = AddressContact::where('contact_id', $this->id)->pluck('address_id');
        $address_list = Address::whereIn('id', $contact_address)->get();
        return $address_list;
    }

    public function getFullTagsAttribute()
    {
        $tag_contacts = TagContact::where('contact_id', $this->id)->pluck('tag_id');
        $tag_list = Tag::whereIn('id', $tag_contacts)->get();
        return $tag_list;
    }

    public function getPropertyTagsAttribute()
    {
        $tag_ids = TagObject::where(['target_id' => $this->id, 'type' => 'contact_buyer'])->pluck('tag_id');
        $tags = [];
        foreach ($tag_ids as $tag_id) {
            array_push($tags, $tag_id);
        }
        return $tags;
    }
}
