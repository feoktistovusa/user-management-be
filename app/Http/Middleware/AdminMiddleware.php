<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        return $next($request);
    }
}
