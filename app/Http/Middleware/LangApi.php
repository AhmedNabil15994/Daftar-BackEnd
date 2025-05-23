<?php

namespace App\Http\Middleware;

use Closure;

class LangApi
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app()->setLocale(
            in_array(
                $request->header("Accept-Language"),
                config('translatable.locales')
            )
                ? $request->header("Accept-Language")
                : config('app.locale')
        );

        return $next($request);
    }
}
