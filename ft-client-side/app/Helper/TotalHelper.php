<?php

namespace App\Helper;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class TotalHelper
{
    public function getMonth()
    {
        $client = new Client();
        $response = $client->get(env('APP_API_SERVER_1') . '/finance/total/month', [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('token')
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        if ($body['status_error']) {
            return 0;
        } else {
            return $body['data'];
        }
    }

    public function getAll()
    {
        $client = new Client();
        $response = $client->get(env('APP_API_SERVER_1') . '/finance/total/all', [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('token')
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        if ($body['status_error']) {
            return 0;
        } else {
            return $body['data'];
        }
    }

    public function getDataChart()
    {
        $client = new Client();
        $response = $client->get(env('APP_API_SERVER_1') . '/finance/data/chart', [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('token')
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        if ($body['status_error']) {
            return null;
        } else {
            return $body['data'];
        }
    }
}
