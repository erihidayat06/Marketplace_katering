<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\Response;

class CheckMerchantRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sedang login dan memiliki role 'merchant'
        if (Auth::check() && Auth::user()->role === 'merchant') {
            // Lanjutkan request jika role adalah 'merchant'
            return $next($request);
        }

        // Jika bukan 'merchant', redirect atau beri pesan error
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses sebagai merchant.');
    }
}
