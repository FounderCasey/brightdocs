<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::guard()->user(); //get user
        if ($user->role == $role) {
            return $next($request);
        } else if ($user->role == "Admin") {
            return $next($request);
        } else {
            throw new AuthorizationException('You do not have permission to view this page. If this is incorrect, contact your sites owner.');
        }
    }
}