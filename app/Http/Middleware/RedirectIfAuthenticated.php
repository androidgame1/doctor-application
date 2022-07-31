<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check() && Auth::user()->is_superadministrator) {
                return redirect()->route('superadministrator.home');
            }else if(Auth::guard($guard)->check() && Auth::user()->is_administrator) {
                return redirect()->route('administrator.home');
            }else if(Auth::guard($guard)->check() && Auth::user()->is_secretary) {
                return redirect()->route('secretary.home');
            }
        }

        return $next($request);
    }
}
