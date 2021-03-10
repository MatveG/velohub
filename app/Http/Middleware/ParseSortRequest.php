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
        $request->sortCol = 'id';
        $request->sortOrd = 'desc';

        if ($request->sort && strpos($request->sort, '-')) {
            [$request->sortCol, $request->sortOrd] = explode('-', $request->sort);
        }

        return $next($request);
    }
}
