<?php

namespace App\Http\Controllers;

use App\Helper\StatusHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TransactionController extends Controller
{
    public function index()
    {
        $client = new Client();
        $response = $client->get(env('APP_API_SERVER_2') . '/transactions', [
            'headers' => [
                'secret-key' => env('SECRET_KEY'),
            ],
        ]);

        $datas = json_decode($response->getBody()->getContents(), true)['data'];

        return view('pages.transactions', compact('datas'));
    }

    public function pay(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required',
        ]);

        $image = $request->file('image');
        $image_path = $image->getPathname();
        $filename = $image->getClientOriginalName();

        $client = new Client();

        $response = $client->request('POST', env('APP_API_SERVER_2') . '/transactions', [
            'headers' => [
                'secret-key' => env('SECRET_KEY'),
            ],
            'multipart' => [
                [
                    'name'     => 'user_id',
                    'contents' => Cache::get('user')['uuid'],
                ],
                [
                    'name'     => 'image',
                    'contents' => fopen($image_path, 'r'),
                    'filename' => $filename,
                ],
            ],
        ]);


        $body = json_decode($response->getBody()->getContents(), true);

        if ($body['status_error']) {
            return redirect()->back()->withErrors([
                'failed' => $body['message'],
            ]);
        }

        $statusHelper = new StatusHelper();
        $status = $statusHelper->getStatus(Cache::get('user')['uuid']);

        Cache::forget('status');
        Cache::put('status', $status, 60);

        return redirect()->back()->with('success', 'Payment success, please wait for confirmation');
    }

    public function confirm(Request $request)
    {
        $client = new Client();
        $response = $client->post(env('APP_API_SERVER_2') . '/transactions/confirm/' . $request->id, [
            'headers' => [
                'secret-key' => env('SECRET_KEY'),
            ],
        ]);

        $datas = json_decode($response->getBody()->getContents(), true);

        if ($datas['status_error']) {
            return redirect()->back()->withErrors([
                'failed' => $datas['message'],
            ]);
        }

        return redirect()->back();
    }
}
