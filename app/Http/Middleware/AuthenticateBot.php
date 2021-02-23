<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateBot
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
        if ($request->get('hub_mode') == 'subscribe' && 
        $request->get('hub_verify_token') === env('HUB_VERIFY_TOKEN')
        ) {
            return response($request->get('hub_challenge'));
        }
        return $next($request);
    }
}
