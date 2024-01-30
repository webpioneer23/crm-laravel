<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "purchaser_name",
        "vendor_name",
        "contract_accepted_date",
        "unconditional_date",
        "deposit_due_date",
        "deposit_received_date",
        "commission",
        "comment",
        "listing_id",
        "price"
    ];

    public function getContactsAttribute()
    {
        $contact_ids = ContractContact::where("contract_id", $this->id)->pluck('contact_id');
        $contacts = Contact::whereIn('id', $contact_ids)->get();
        return $contacts;
    }

    public function getFullConditionsAttribute()
    {
        return TagnameObject::where(['target_id' => $this->id, 'type' => 'contract_condition'])->get();
        // $conditions = [];
        // foreach ($tag_lists as $tag_list) {
        //     array_push($conditions, $tag_list->tag_name);
        // }
        // return $conditions;
    }
    public function getFullCommentsAttribute()
    {
        $tag_lists = TagnameObject::where(['target_id' => $this->id, 'type' => 'contract_comment'])->get();
        $comments = [];
        foreach ($tag_lists as $tag_list) {
            array_push($comments, $tag_list->tag_name);
        }
        return $comments;
    }

    public function getFilesAttribute()
    {
        $files = AFile::where(['target_id' => $this->id, 'type' => 'contract_document'])->get();
        return $files;
    }

    public function getListingAttribute()
    {
        $listing = Listing::find($this->listing_id);
        return $listing;
    }
}
