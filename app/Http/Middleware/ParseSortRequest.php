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
        if ($request->sort && strpos($request->sort, '-')) {
            [$request->orderBy, $request->orderWay] = explode('-', $request->sort);
        } else {
            $request->orderBy = 'id';
            $request->orderWay = 'desc';
        }

        return $next($request);
    }
}
