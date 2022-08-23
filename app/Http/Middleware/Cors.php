<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        //fix cors error
        $response = $next($request);

        $response->headers->set("Access-Control-Allow-Origin", 'http://localhost:3000');
        $response->headers->set("Access-Control-Allow-Methods", 'POST, GET, PUT, DELETE');
        $response->headers->set("Access-Control-Allow-Headers", 'Content-Type, Accept, Authorization, X-Requested-With, Application');

        return $response;
    }
}
