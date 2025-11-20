<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {

            if ($request->user()->role === 'admin') {
                return $next($request);
            }

            return redirect('/dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin Admin.');
        }

        return redirect()->route('login');
    }
}