<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BotController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    public function handleMessage (Request $request) 
    {
        $payload = $request->all();

        $sender_id  = $payload['entry'][0]['messaging'][0]['sender']['id'];
        $message = $payload['entry'][0]['messaging'][0]['message']['text'];

        if (!empty($message)) {
            return response($this->sendMessage($sender_id,$message));

        }
        return response('', 200);
    }

    private function sendMessage($sender_id, $message = "I am a bot. Brains under development") 
    {
        $page_access_token = env('PAGE_ACCESS_TOKEN');
        $url = "https://graph.facebook.com/v9.0/me/messages?access_token=".$page_access_token;
        $response_data = array("recipient" => array("id" => $sender_id),
                               "message" => array("text" => $message)
                         );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

}
