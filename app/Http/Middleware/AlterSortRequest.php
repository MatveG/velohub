<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AlterSortRequest
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
            $sortRequest = explode('-', $request->sort);
            $request->sortCol = $sortRequest[0];
            $request->sortOrd = $sortRequest[1];
        }

        return $next($request);
    }
}
