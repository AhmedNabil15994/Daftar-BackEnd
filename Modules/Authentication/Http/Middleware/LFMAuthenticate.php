<?php

namespace Modules\Authentication\Http\Middleware;

use Closure;

class LFMAuthenticate
{

    public function handle($request, Closure $next)
    {
        if (auth()->user()->can('dashboard_access')) {

            config([
                'lfm.allow_shared_folder'  => true
            ]);

        }

        return $next($request);
    }

}
