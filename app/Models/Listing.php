<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // detail
        'listing_id',
        'step',
        'status',
        'featured_property',
        'property_type',
        'established_development',
        'home_package',
        'authority',
        'office',
        'expiry_date',
        'price_type',
        'tender_deadline_date',
        'price',
        'display_price',
        'display',
        'key_number',
        'key_location',
        'alarm_code',
        'internal_notes',
        'rent_appraisal',
        'address_id',
        'contact_id',
        'display_price_text',

        // property detail
        'bedrooms',
        'bathrooms',
        'ensuites',
        'toilets',
        'garage_spaces',
        'carport_spaces',
        'open_car_spaces',
        'living_areas',
        'house_size',
        'house_size_unit',
        'land_size',
        'land_size_unit',
        'energy_efficiency_rating',
        'agency_reference',
        'sms_code',
        'document_delivery_cma',
        'document_delivery_method_cma',
        'inhouse_complaints_guide',
        'deed_assignment_requested',
        'floor_area_verified',
        'ax_listing_check_admin',
        'ax_listing_check_mitch',
        'outdoor_features',
        'indoor_features',
        'heating_cooling',
        'eco_friendly_features',
        'other_features',

        // image copy
        'headline',
        'description',
        'video_url',
        'online_tour1',
        'online_tour2',
        'third_party_link',

        // inspections
        'inspection_date',
        'start_time',
        'end_time',
        'inspection_type',
        'inspection_booking_setting',
        'inspection_user',

    ];


    public function getFullTagsAttribute()
    {
        $listing_tags = ListingTag::where('listing_id', $this->id)->pluck('tag_id');
        $tags = [];
        foreach ($listing_tags as $tag) {
            array_push($tags, $tag);
        }
        return $tags;
    }

    public function getPhotosAttribute()
    {
        $photos = AFile::where(['target_id' => $this->id, 'type' => 'listing_photo'])->orderBy('priority', 'DESC')->get();
        return $photos;
    }
    public function getFloorplansAttribute()
    {
        $photos = AFile::where(['target_id' => $this->id, 'type' => 'listing_floorplans'])->orderBy('priority', 'DESC')->get();
        return $photos;
    }
    public function getDocumentsAttribute()
    {
        $photos = AFile::where(['target_id' => $this->id, 'type' => 'listing_document'])->get();
        return $photos;
    }

    public function getAddressAttribute()
    {
        $address = Address::find($this->address_id);
        return $address;
    }
    public function vendor()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function getVendorAttribute()
    {
        $vendor = Contact::find($this->contact_id);
        return $vendor;
    }

    public function getInspectionsAttribute()
    {
        $inspections = [];
        $obs = ListingInspection::where('listing_id', $this->id)->get();
        foreach ($obs as $inspection) {
            array_push($inspections, [
                "inspection_date" => $inspection->inspection_date,
                "inspection_type" => $inspection->inspection_type,
                "inspection_booking_setting" => $inspection->inspection_booking_setting,
                "start_time" => $inspection->start_time,
                "end_time" => $inspection->end_time,
            ]);
        }
        return $obs;
    }
}
