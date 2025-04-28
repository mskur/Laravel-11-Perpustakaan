<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login (gunakan guard default 'web')
        if (!Auth::guard('web')->check()) {
            return redirect()->route('loginUser')->with('error', 'Silahkan login sebagai user.');
        }
        return $next($request);
    }
}
