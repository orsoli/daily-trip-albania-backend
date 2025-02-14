<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ChekProfileUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $profileUser = $request->user;

            // If the user is a super-admin, they can view all users
            if ($user->role->slug === 'super-admin') {
                return $next($request); // Lejo aksesin
            }

            // For other users (admin, editor, etc.), allow only if the request matches the user's ID
            if ($user->id === $profileUser->id) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');

    }
}