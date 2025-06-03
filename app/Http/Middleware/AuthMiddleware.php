<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('userData')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Chưa đăng nhập'
                ], 401);
            }
            return redirect()->route('login');
        }
        return $next($request);
    }
}
