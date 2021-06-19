<?php

namespace App\Http\Middleware;

use Closure;

class EscapeSearchRequest
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
        if ($request->find) {
            $escapedString = trim(preg_replace('/[^+A-Za-z0-9- ]/', '', $request->find));
            $request->searchWords = str_replace(' ', '  |', $escapedString);
        }

        return $next($request);
    }
}
