<?php

namespace App\Http\Middleware;

use Closure;
use App;

class CheckLocale
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
        $locale = $request->session()->get('locale');
        if (!in_array($locale, ['vi', 'en'])) {
            $locale = 'vi';
        }
        App::setLocale($locale);
        return $next($request);
    }
}
