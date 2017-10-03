<?php

namespace App\Http\Middleware;

use App\Dashboard_user;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        // check if waiter or admin
        if (!$this->hasAccess($request->user())) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                abort(401);
            }
        }

        return $next($request);
    }

    public function hasAccess(Dashboard_user $user)
    {
        $job = strtolower($user->job);
        $role = strtolower($user->role);
        // at the moment this class is created, only waiter has some restrictions
        // this condition needs to be modified to check for permissions
        if ($role == '' || $role == 'admin' || ($role == 'staff' && $job != 'waiter')) {
            return true;
        }

        return false;
    }
}
