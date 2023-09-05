<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DefineController extends Controller
{
    public function authNot()
    {
        return response()->json([
            'status_error' => true,
            'message' => 'Authentiacte',
        ]);
    }
}
