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
}
