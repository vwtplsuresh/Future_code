<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            $user = Auth::guard($guard)->user();

            if ($user && method_exists($user, 'hasRole') && $user->hasRole('admin')) {
                return redirect(RouteServiceProvider::ADMIN);

                if ($user->hasRole('user')) {
                    return redirect(RouteServiceProvider::USER);
                }

                if ($user->hasRole('operator')) {
                    return redirect(RouteServiceProvider::OPERATOR);
                }

                if ($user->hasRole('inspector')) {
                    return redirect(RouteServiceProvider::INSPECTOR);
                }
            }

        }

        return $next($request);
    }
}
