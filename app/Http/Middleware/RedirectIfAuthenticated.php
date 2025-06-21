<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                Log::info('User is authenticated, redirecting to dashboard', [
                    'user_id' => $user->id,
                    'session_id' => session()->getId(),
                    'guard' => $guard
                ]);

                // Redirect ke dashboard
                return redirect()->route('dashboard');
            }
        }

        Log::info('User is not authenticated, proceeding to next middleware', [
            'session_id' => session()->getId()
        ]);

        return $next($request);
    }
} 