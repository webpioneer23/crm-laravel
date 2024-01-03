<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_number',
        'to_number',
        'event_id',
        'sender',
        'content',
        'sent_at',
        'deliveried_at',
        'status',
    ];

    public function fromContact()
    {
        $number = $this->from_number;
        $contact = Contact::where('mobile', $number)->first();
        if ($contact) {
            if ($contact->photo) {
                return ['photo', $contact->photo];
            } else {
                $photo = strtoupper(substr($contact->first_name, 0, 1)) . strtoupper(substr($contact->last_name, 0, 1));
                return ['str', $photo];
            }
        }
        return ["default", substr($number, -2)];
    }

    public function fromJsContact()
    {
        $number = $this->from_number;
        $contact = Contact::where('mobile', $number)->first();
        if ($contact) {
            if ($contact->photo) {
                return $contact->photo;
            } else {
                $photo = strtoupper(substr($contact->first_name, 0, 1)) . strtoupper(substr($contact->last_name, 0, 1));
                return $photo;
            }
        }
        return substr($number, -2);
    }

    public function toContact()
    {
        $number = $this->to_number;
        $contact = Contact::where('mobile', $number)->first();
        if ($contact) {
            if ($contact->photo) {
                return ['photo', $contact->photo];
            } else {
                $photo = strtoupper(substr($contact->first_name, 0, 1)) . strtoupper(substr($contact->last_name, 0, 1));
                return ['str', $photo];
            }
        }
        return ["default", substr($number, -2)];
    }
}
