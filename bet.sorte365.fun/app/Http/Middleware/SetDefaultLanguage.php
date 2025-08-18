<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetDefaultLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        try {
            if (auth('api')->check() && auth('api')->user() && auth('api')->user()->language) {
                app()->setLocale(auth('api')->user()->language);
            }
        } catch (\Exception $e) {
            // Silently ignore auth errors for non-API routes
        }

        return $next($request);
    }
}
