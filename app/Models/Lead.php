<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'address_id',
        'status',
        'note',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }


    public function contact()
    {
        $contact_ids = LeadObject::where(['lead_id' => $this->id, 'target_name' => 'contact'])->pluck('target_id');
        $contact_list = Contact::whereIn('id', $contact_ids)->get();
        return $contact_list;
    }

    public function appraisals()
    {
        $object_ids = LeadObject::where(['lead_id' => $this->id, 'target_name' => 'appraisal'])->pluck('target_id');
        $objects = Appraisal::whereIn('id', $object_ids)->get();
        return $objects;
    }

    public function listings()
    {
        $object_ids = LeadObject::where(['lead_id' => $this->id, 'target_name' => 'listing'])->pluck('target_id');
        $objects = Listing::whereIn('id', $object_ids)->get();
        return $objects;
    }
}
