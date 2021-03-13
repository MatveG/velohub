<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ParseSortRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        [$request->orderBy, $request->orderWay] = $request->sort && strpos($request->sort, '-') ?
            explode('-', $request->sort) : ['id', 'desc'];

        return $next($request);
    }
}
