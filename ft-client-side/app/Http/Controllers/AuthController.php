<?php

namespace App\Http\Controllers;

use App\Helper\StatusHelper;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('register');
    }
    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $client = new Client();

        $data = [
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => $validate['password']
        ];

        $response = null;

        $response = $client->post(env('APP_API_SERVER_1') . '/register', [
            'json' => $data
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        if ($body['status_error']) {
            return redirect()->back()->withErrors([
                'failed' => $body['message']
            ]);
        }

        $statusHelper = new StatusHelper();
        $status = $statusHelper->getStatus($body['user']['uuid']);

        Cache::put([
            'user' => $body['user'],
            'token' => $body['token'],
            'status' => $status
        ], now()->addMinutes(60));

        return redirect()->route('dashboard');
    }
    public function loginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $client = new Client();

        $data = [
            'email' => $validate['email'],
            'password' => $validate['password']
        ];

        $response = null;

        $response = $client->post(env('APP_API_SERVER_1') . '/login', [
            'json' => $data
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        if ($body['status_error']) {
            return redirect()->back()->withErrors([
                'failed' => $body['message']
            ]);
        }

        $statusHelper = new StatusHelper();
        $status = $statusHelper->getStatus($body['user']['uuid']);

        Cache::put([
            'user' => $body['user'],
            'token' => $body['token'],
            'status' => $status
        ], now()->addMinutes(60));

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        $client = new Client();
        $response = $client->post(env('APP_API_SERVER_1') . '/logout', [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('token')
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        if ($body['status_error']) {
            return redirect()->back()->withErrors([
                'failed' => $body['message']
            ]);
        }

        Cache::forget('user');
        Cache::forget('token');
        Cache::forget('status');

        return redirect()->route('login.form');
    }
}
