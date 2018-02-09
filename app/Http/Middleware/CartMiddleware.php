<?php

namespace App\Http\Middleware;

use Closure;

class CartMiddleware
{
    public function handle($request, Closure $next)
    {
        $qty = $request->route()->parameters()['qty'];

        if(!is_numeric($qty)) {
            return response('Invalid request', 400);
        }

        return $next($request);
    }
}
