<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complex extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'street_address',
        'name',
        'year_built',
        'architect',
        'constructor',
        'number_units',
        'number_floors',
        'property_type',
        'body_manager',
        'note',
    ];

    public function getFullAddressAttribute()
    {
        $complex_address = ComplexAddress::where('complex_id', $this->id)->pluck('address_id');
        $address_list = Address::whereIn('id', $complex_address)->get();
        return $address_list;
    }

    public function getFullContactsAttribute()
    {
        $complex_address = ComplexAddress::where('complex_id', $this->id)->pluck('address_id');
        $address_contacts = AddressContact::whereIn('address_id', $complex_address)->pluck('contact_id');
        $contacts = Contact::whereIn('id', $address_contacts)->get();
        return $contacts;
    }

    public function getWishlistAttribute()
    {
        $complex_contacts = ComplexWishlist::where([
            'complex_id' => $this->id,
        ])->pluck('contact_id');
        $contacts = Contact::whereIn('id', $complex_contacts)->get();
        return $contacts;
    }

    public function getTagListAttribute()
    {
        $wishlist_ids = ComplexWishlist::where('complex_id', $this->id)->pluck('id');
        $tags = WishlistTag::whereIn('wishlist_id', $wishlist_ids)->get('tag');
        $unique_tag_list = [];
        foreach ($tags as $tag) {
            if (!in_array($tag->tag, $unique_tag_list)) {
                array_push($unique_tag_list, $tag->tag);
            }
        }
        return json_encode($unique_tag_list);
    }

    public function getFilesAttribute()
    {
        $files = AFile::where(['target_id' => $this->id, 'type' => 'complex'])->get();
        return $files;
    }
}
