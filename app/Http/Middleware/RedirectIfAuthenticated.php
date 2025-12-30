<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // seller -> dashboard seller
                if ($user && $user->role === 'seller') {
                    return redirect()->route('seller.dashboard');
                }

                // buyer/admin -> dashboard buyer (sesuaikan kalau admin punya dashboard sendiri)
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
