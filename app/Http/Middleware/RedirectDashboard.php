<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectDashboard
{
    public function handle(Request $request, Closure $next, $destination)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Fetch the user's role from the database
            $user = Auth::user();
            $userRole = $user->user_type; // Assuming 'role' is the column in the users table

            // Check if the user has any of the specified roles
            if ($userRole == $destination) {
                // Redirect to the corresponding dashboard based on the user's role
                return redirect()->route($destination);
            }
        }

        // If the user doesn't have the specified roles, proceed with the request
        return $next($request);
    }
}
