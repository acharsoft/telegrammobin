<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\HttpClients\GuzzleHttpClient;
use Telegram\Bot\TelegramClient;

class TelegramController extends Controller
{
    public function bot(Request $request)
    {
        $http=new GuzzleHttpClient();
        $client=new Client(['curl' => [
            CURLOPT_PROXY => '45.231.135.83:4145',
            CURLOPT_HTTPPROXYTUNNEL => 1,
        ]]);
        $http->setClient($client);
        $arr=$request;
        $telegram=new Api('519246098:AAFjFpH946OwGGFkuaZG4Uz7B0JOUVeB0OQ',false,$http);
        $update =$telegram->getWebhookUpdate();
        $chat_id =$update->getMessage()->chat->id;
        if ($update->getMessage()->newChatMembers!=NULL) {
            //return $chat_id;
            $firstname = $update->getMessage()->newChatMembers[0]['first_name'];
            if ($firstname == 'بیوگرافیمو بخون')
            {
                $response = $telegram->kickChatMember([
                    'chat_id' => $chat_id,
                    'user_id' => $update->getMessage()->newChatMembers[0]['id']
                ]);
                //return $response;
                $telegram->deleteMessage([
                    'chat_id' => $chat_id,
                    'message_id' => $update->getMessage()->messageId
                ]);
                $telegram->deleteMessage([
                    'chat_id' => $chat_id,
                    'message_id' => $update->getMessage()->messageId+1
                ]);
            }
           // dd($response);
        }

        $telegram->setWebhook(['url'=>'https://0b7d71a5.ngrok.io/api/bot']);
       //dd($response);
    }
}
