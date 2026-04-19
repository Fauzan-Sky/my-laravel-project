<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $guard = match ($role) {
            'siswa'   => 'web',
            'penjual' => 'penjual',
            'admin'   => 'admin',
            default   => null,
        };

        if (! $guard || ! Auth::guard($guard)->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::guard($guard)->user();
        if (in_array($role, ['siswa', 'penjual']) && ! $user->is_active) {
            Auth::guard($guard)->logout();
            return redirect()->route('login')
                ->with('error', 'Akun kamu tidak aktif. Hubungi admin.');
        }

        return $next($request);
    }
}