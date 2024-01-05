<?php

namespace App\Http\Controllers;

use App\Models\Sms;
use App\Services\HistoryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use CloudEvents\Serializers\JsonDeserializer;

class HttpSmsWebhookController extends Controller
{
    /**
     * Receive webhook events from httpsms.com
     * You can find the documentation at https://docs.httpsms.com/webhooks/introduction
     *
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        Log::info("httpsms.com webhook event received with type [{$request->header('X-Event-Type')}]");
        try {
            Log::info("---- web hook receive---");
            Log::info($request->all());
            $type = $request['type'];
            $event = $request['data'];

            $updated_date = [];

            if ($type == 'message.phone.received') {
                $sms = Sms::create([
                    'from_number' => $event['contact'],
                    'to_number' => $event['owner'],
                    'event_id' => $event['message_id'],
                    'sender' => 0,
                    'content' => $event['content'],
                    'deliveried_at' => date('Y-m-d H:i:s'),
                    'status' => 'received',
                    'sent_at' => date('Y-m-d H:i:s')
                ]);

                $history = [
                    'user_id' => 1,
                    'type' => 'received',
                    'source' => 'sms',
                    'source_id' => $sms->id,
                    'note' => "Content: " . $event['content'] . ", Number: " . $event['contact'],
                ];

                HistoryService::addRecord($history);
            } else {
                if ($type == "message.phone.sent") {
                    $sms = Sms::where('event_id', $event['id'])->first();
                    $updated_date = [
                        'status' => 'sent',
                        'sent_at' => date('Y-m-d H:i:s')
                    ];
                } elseif ($type == 'message.phone.delivered') {
                    $sms = Sms::where('event_id', $event['id'])->first();
                    $updated_date = [
                        'status' => 'delivered',
                        'deliveried_at' => date('Y-m-d H:i:s')
                    ];

                    $history = [
                        'user_id' => 1,
                        'type' => 'delivered',
                        'source' => 'sms',
                        'source_id' => $sms->id,
                        'note' => "Content: " . $sms->content . ", Number: " . $sms->to_number,
                    ];

                    HistoryService::addRecord($history);
                } elseif ($type == 'message.send.failed') {
                    $sms = Sms::where('event_id', $event['id'])->first();
                    $updated_date = [
                        'status' => 'failed',
                    ];

                    $history = [
                        'user_id' => 1,
                        'type' => 'failed',
                        'source' => 'sms',
                        'source_id' => $sms->id,
                        'note' => "Content: " . $sms->content . ", Number: " . $sms->to_number,
                    ];

                    HistoryService::addRecord($history);
                } elseif ($type == 'message.phone.expired ') {
                    $sms = Sms::where('event_id', $event['message_id'])->first();
                    $updated_date = [
                        'status' => 'expired',
                    ];

                    $history = [
                        'user_id' => 1,
                        'type' => 'expired',
                        'source' => 'sms',
                        'source_id' => $sms->id,
                        'note' => "Content: " . $sms->content . ", Number: " . $sms->to_number,
                    ];

                    HistoryService::addRecord($history);
                }

                $sms->update($updated_date);
            }



            // $event = JsonDeserializer::create()->deserializeStructured($request->getContent());
            // $eventData = json_encode($event->getData(), JSON_PRETTY_PRINT);
            // Log::info("decoded [{$event->getId()}] with id [{$event->getId()} and data [$eventData]");
        } catch (Exception $exception) {
            Log::error($exception);
        }
    }
}
