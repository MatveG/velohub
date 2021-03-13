<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ParseFilterRequest
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
        $path = $request->route()->parameter('path');

        $request->filter = empty($path) ? [] : $this->parsePath($path);

        return $next($request);
    }

    private function parsePath(?string $path): array
    {
        $params = [];

        foreach (explode('/', $path) as $piece) {
            $keyValue = explode('-is-', $piece, 2);

            if (count($keyValue) === 2) {
                [$key, $value] = $keyValue;
                $valuesArr = explode('-or-', $value);
                $params[$key] = count($valuesArr) ? $valuesArr : $value;
            }
        }

        return $params;
    }
}
