<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSeller
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if ($user->role !== 'seller') {
            // kamu bisa arahkan ke dashboard biasa atau ke halaman role
            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Halaman ini khusus seller.');
        }

        return $next($request);
    }
}
