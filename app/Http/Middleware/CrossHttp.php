<?php

namespace App\Http\Middleware;

use Closure;

class CrossHttp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Headers', 'X-CSRF-TOKEN,Origin, Content-Type,Authorization,X-Requested-With, Cookie, Accept')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS,DELETE')
            ->header('Access-Control-Max-Age', 3628800)
            ->header('Access-Control-Allow-Credentials', false);
    }
}
