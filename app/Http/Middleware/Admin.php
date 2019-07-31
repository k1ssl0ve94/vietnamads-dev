<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() &&
            auth()->user()->group != config('user.group.backend')) {
            return response('Forbidden', 403);
        }

        return $next($request);
    }
}
