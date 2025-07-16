<?php

namespace App\Http\Middleware;

use App\Models\RoleRoute;
use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() === null) {
            return redirect('/')->with('message', 'Please log in first. Thanks');
        }

        $routeName = $request->route()->getName();
        $routesData = RoleRoute::where('route_name', $routeName)->get();
        $roles = $routesData->pluck('role_name')->toArray();
        if ($request->user()->hasAnyRole($roles)) {
            return $next($request);
        }
        if ($request->user()->user_type == 1) {
            return $next($request);
        }
        Alert::error('You do not have permission to access this page.');
        return redirect('/dashboard');
    }

}
