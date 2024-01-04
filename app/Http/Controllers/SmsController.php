<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Sms;
use App\Services\SmsService;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $own_number = config('services.sms.number');
        $contacts = Contact::whereNotNull('mobile')->get();
        $contact_map = [];
        foreach ($contacts as $key => $mobile_contact) {
            $contact_map[$mobile_contact->mobile] = $mobile_contact;
        }



        $full_history = Sms::orderBy('created_at', 'desc')->get();
        $contact_list = [];
        $contact_list_numbers = [];
        foreach ($full_history as $chat_contact) {
            $contact_number = $chat_contact->from_number != $own_number ? $chat_contact->from_number : $chat_contact->to_number;
            if (!in_array($contact_number, $contact_list_numbers)) {
                if (array_key_exists($contact_number, $contact_map)) {
                    array_push($contact_list, $contact_map[$contact_number]);
                } else {
                    array_push($contact_list, $contact_number);
                }
                array_push($contact_list_numbers, $contact_number);
            }
        }



        $chats = [];
        if (count($contact_list) > 0) {
            $first_contact = $contact_list[0];

            $first_contact_number = "";
            if (gettype($first_contact) == 'string') {
                $first_contact_number = $first_contact;
            } else {
                $first_contact_number = $first_contact->mobile;
            }
            if ($first_contact_number) {

                Sms::where(['from_number' => $first_contact_number, 'read' => 0])
                    ->update([
                        'read' => 1
                    ]);


                $chats = Sms::where('from_number', $first_contact_number)
                    ->orWhere('to_number', $first_contact_number)
                    ->orderBy('created_at')
                    ->get();
            }
        }

        $unread_list = [];

        foreach ($contact_list_numbers as $key1 => $contact_list_number) {
            $number_sms = Sms::where(['from_number' => $contact_list_number, 'sender' => 0, 'read' => 0])->count();
            $unread_list[$contact_list_number] = $number_sms;
        }
        return view('sms.list', compact('contact_list', 'contacts', 'chats', 'unread_list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $numbers = $request->numbers;
        $content = $request->content;
        $number_list = [];
        if ($numbers) {
            $number_list = json_decode($numbers, true);
        }

        if (count($number_list) > 0) {
            foreach ($number_list as $key => $number_ob) {
                if ($key < 10) {
                    $number = $number_ob['value'];

                    $phone_number = "";

                    if (substr($number, 0, 1) == '+') {
                        $phone_number = $number;
                    } else {
                        $pattern = '/\(\+(\d+)\)/';
                        if (preg_match($pattern, $number, $matches)) {
                            $phone_number = "+" . $matches[1];
                            // $phone_number = "+" . $matches[1];
                        }
                    }

                    if ($phone_number) {
                        SmsService::sendSMS($phone_number, $content);
                    }
                }
            }
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Sms $sms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sms $sms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sms $sms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sms $sms)
    {
        //
    }

    public function sendSingleSMS(Request $request)
    {
        try {
            $number = $request->number;
            $content = $request->content;
            SmsService::sendSMS($number, $content);
            $chats = Sms::where('from_number', $number)
                ->orWhere('to_number', $number)
                ->orderBy('created_at')
                ->get();

            foreach ($chats as $chat) {
                $number = $chat->from_number;
                $contact = Contact::where('mobile', $number)->first();
                if ($contact) {
                    if ($contact->photo) {
                        $chat->from_photo = $contact->photo;
                    } else {
                        $photo = strtoupper(substr($contact->first_name, 0, 1)) . strtoupper(substr($contact->last_name, 0, 1));
                        $chat->from_photo = $photo;
                    }
                } else {
                    $chat->from_photo = substr($number, -2);
                }
            }
            return response()->json(['status' => true, 'chats' => $chats]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false]);
        }
    }

    public function getChatsByNumber(Request $request)
    {
        $number = $request->number;
        Sms::where(['from_number' => $number, 'read' => 0])
            ->update([
                'read' => 1
            ]);

        $chats = Sms::where('from_number', $number)
            ->orWhere('to_number', $number)
            ->orderBy('created_at')
            ->get();

        foreach ($chats as $chat) {
            $number = $chat->from_number;
            $contact = Contact::where('mobile', $number)->first();
            if ($contact) {
                if ($contact->photo) {
                    $chat->from_photo = $contact->photo;
                } else {
                    $photo = strtoupper(substr($contact->first_name, 0, 1)) . strtoupper(substr($contact->last_name, 0, 1));
                    $chat->from_photo = $photo;
                }
            } else {
                $chat->from_photo = substr($number, -2);
            }
        }
        return response()->json(['status' => true, 'chats' => $chats]);
    }
}
