<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'property_type',
        'google_address',
        'unit_number',
        'street',
        'building',
        'suburb',
        'city',

        'step',
        'property_id'
    ];

    public function getFullContactsAttribute()
    {
        $contact_addresses = AddressContact::where('address_id', $this->id)->pluck('contact_id');
        $contacts = Contact::whereIn('id', $contact_addresses)->get();
        return $contacts;
    }

    public function getPropertyAttribute()
    {
        $property = Property::find($this->property_id);
        return $property;
    }
}
