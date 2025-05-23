<?php

namespace Modules\DeviceToken\Services;

use Modules\DeviceToken\Jobs\FirebaseMessageJob;

class FCM
{
    public function devicesTypes($devices)
    {
        return $devices->groupBy('lang')->map(function ($data) {
            return $data->groupBy('platform')->map(function ($token) {
                return $token->pluck('device_token');
            });
        });
    }

    public function send($devices, $request)
    {
        $types = $this->devicesTypes($devices);

        foreach (config('translatable.locales') as $codeLang) {

            $tokens = collect($types)->get($codeLang);

            $iosTokens = collect($tokens)->get('IOS');
            $androidTokens = collect($tokens)->get('ANDROID');

            if (!is_null($iosTokens))
                $this->PushIOS($request, $iosTokens, $codeLang);

            if (!is_null($androidTokens))
                $this->PushANDROID($request, $androidTokens, $codeLang);

        }
    }

    public function PushIOS($data, $devices, $lang)
    {
        $regIdIOS = collect($devices)->unique();
        $regIdIOS = array_chunk($regIdIOS->toArray(), 999);

        foreach ($regIdIOS as $tokens) {

            $fields_ios = [
                'registration_ids' => $tokens,
                'notification' => [
                    'title' => $data['title'][$lang],
                    'body' => $data['description'][$lang],
                    'sound' => 'default',
                    'priority' => 'high',
                    'badge' => '0',
                ],
                'data' => [
                    "type" => $data['type'] ?? 'general',
                    "id" => $data['id'] ?? null,
                ],
            ];

            FirebaseMessageJob::dispatch($fields_ios);
        }
    }

    public function PushANDROID($data, $devices, $lang)
    {
        $regIdANDROID = collect($devices)->unique();
        $regIdANDROID = array_chunk($regIdANDROID->toArray(), 999);

        foreach ($regIdANDROID as $tokens) {

            $fields_android = [
                'registration_ids' => $tokens,
                'data' => [
                    'title' => $data['title'][$lang],
                    'body' => $data['description'][$lang],
                    'sound' => 'default',
                    'priority' => 'high',
                    "type" => $data['type'] ?? 'general',
                    "id" => $data['id'] ?? null,
                ]
            ];

            FirebaseMessageJob::dispatch($fields_android);
        }

    }
}
