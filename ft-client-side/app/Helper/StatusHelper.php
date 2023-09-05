<?php

namespace App\Helper;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class StatusHelper
{
    public function getStatus($uuid)
    {
        $client = new Client();

        $response = $client->get(env('APP_API_SERVER_2') . '/transactions/status/' . $uuid, [
            'headers' => [
                'secret-key' => env('SECRET_KEY')
            ],
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        return $body['status'];
    }
}
