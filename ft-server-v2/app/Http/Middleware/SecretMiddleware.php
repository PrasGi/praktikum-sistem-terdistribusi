<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecretMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('secret-key') == env('APP_SECRET_KEY'))
            return $next($request);

        return response()->json([
            'status_error' => true,
            'message' => 'Unauthorized',
        ], 401);
    }
}
