<?php

namespace Modules\DeviceToken\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class FirebaseSingleMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $devices;
    public $request;

    public function __construct($devices, $request)
    {
        $this->request = $request;
        $this->devices = $devices;
    }

    public function handle()
    {
        $this->sendNotification($this->devices, $this->request);
    }

    public function sendNotification($devices, $request)
    {
        foreach (config('translatable.locales') as $lang) {

            // FILTER IOS DEVICES
            if ($devices['ios']) {

                $iosTokens = $devices['ios']->where('lang', $lang)->pluck('device_token')->toArray();

                $chunkIOS = $this->uniqueTokens($iosTokens);

                $regIdIOS = array_chunk($chunkIOS, 999);

                foreach ($regIdIOS as $iTokens) {
                    $this->PushIOS($request, $iTokens, $lang);
                }
            }

            // FILTER ANDROID DEVICES
            if ($devices['android']) {

                $androidTokens = $devices['android']->where('lang', $lang)->pluck('device_token')->toArray();

                $tokensAndroid = $this->uniqueTokens($androidTokens);

                $regIdAndroid = array_chunk($tokensAndroid, 999);

                foreach ($regIdAndroid as $aTokens) {
                    $this->PushANDROID($request, $aTokens, $lang);
                }

            }

        }

        return true;
    }

    public function uniqueTokens($tokens)
    {
        if (is_array($tokens)) {
            $tokens = array_values(array_unique($tokens));
        } else {
            $tokens = array($tokens);
        }

        return $tokens;
    }

    public function PushIOS($data, $tokens, $lang)
    {
        $notification = [
            'title' => $data['title'][$lang],
            'body' => $data['description'][$lang],
            'sound' => 'default',
            'priority' => 'high',
            'badge' => '0',
        ];

        $data = [
            "type" => isset($data['type']) ? $data['type'] : 'general',
            "id" => isset($data['id']) ? $data['id'] : null,
        ];

        $fields_ios = [
            'registration_ids' => $tokens,
            'notification' => $notification,
            'data' => $data,
        ];

        return $this->Push($fields_ios);
    }

    public function PushANDROID($data, $tokens, $lang)
    {
        $notification = [
            'title' => $data['title'][$lang],
            'body' => $data['description'][$lang],
            'sound' => 'default',
            'priority' => 'high',
            "type" => isset($data['type']) ? $data['type'] : 'general',
            "id" => isset($data['id']) ? $data['id'] : null,
        ];

        $fields_android = [
            'registration_ids' => $tokens,
            'data' => $notification
        ];

        return $this->Push($fields_android);
    }

    public function Push($fields)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $server_key = 'AAAA7JHhmJw:APA91bHEcpJ1UzgHdmAgL8koTgUIqVim6HlIU0yCu3uR_F2-6Gy_gEsCed1lrEZgcQwVKlngOO2Z6OowTJ6iv65GjrCRQioIpzF31dQ749bXEo4ehYTTEzi1CDw6hSKyktH6b4mPQsLM';
        $headers = [
            'Content-Type:application/json',
            'Authorization:key=' . $server_key
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
}
