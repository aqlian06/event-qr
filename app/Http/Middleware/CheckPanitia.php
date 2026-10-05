<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPanitia
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('is_panitia')) {
            return redirect()->route('login')->with('error', 'Silakan masukkan kata sandi panitia terlebih dahulu.');
        }

        return $next($request);
    }
}