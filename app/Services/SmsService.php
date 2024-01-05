<?php

namespace App\Services;

use App\Models\Sms;
use GuzzleHttp\Client;

class SmsService
{
    public static function sendSMS($number, $content)
    {
        $client = new Client();

        $apiKey = config('services.sms.key');
        $from_number = config('services.sms.number');

        $res = $client->request('POST', 'https://api.httpsms.com/v1/messages/send', [
            'headers' => [
                'x-api-key' => $apiKey,
            ],
            'json'    => [
                'content' => $content,
                'from'    => $from_number,
                'to'      => $number
            ]
        ]);
        $res_body = $res->getBody()->getContents();
        $res_body = json_decode($res_body);
        $event = $res_body->data;
        \Log::info("Event id--");
        \Log::info($event->id);
        $sms = Sms::create([
            'from_number' => $from_number,
            'to_number' => $number,
            'event_id' => $event->id,
            'sender' => 1,
            'content' => $content,
            'sent_at' => date('Y-m-d H:i:s'),
            'status' => 'pending'
        ]);

        return $sms;
    }
}
