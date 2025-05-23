<?php

namespace Modules\DeviceToken\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class FirebaseMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $fields;

    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    public function handle()
    {
    	$url = 'https://fcm.googleapis.com/fcm/send';

    	$server_key = 'AAAAMgHPDM4:APA91bEOaiqWat7Z5y05QyWxlIOXWlhEa-Ae8ktwbfzxrZCqKTuKfrq2FqfI_iuvdLTn56MnjXP6S3p-KRxgeOaW7Qw67oDkhEy9IvH1tb5-ZAOYUbrdV0vSwdN5-JZyVh2PXBHC6ULi';

    	$headers = [
    		'Content-Type:application/json',
    		'Authorization:key='.$server_key
        ];

    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->fields));
    	$result = curl_exec($ch);

    	if ($result === FALSE) {
    		die('FCM Send Error: ' . curl_error($ch));
    	}

    	curl_close($ch);
		\Log::debug($result);
        return $result;
	}

}
