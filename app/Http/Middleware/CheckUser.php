<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Cek apakah pengguna sudah login
        if(!$user){
            return $request->expectsJson()
                ? response()->json(['message' => 'Unauthorized'], 401)
                : redirect()->route('login');
        }

        if($user->role !== User::ROLE_ADMIN){
            return $request->expectsJson()
                ? response()->json(['message' => 'Forbidden, Admin access only'], 403)
                : abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
