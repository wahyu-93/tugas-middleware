<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class roleMiddleware
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
        $datauser = Auth::user();
        if($datauser->role == 1) {
            return $next($request);
        }
            abort(403);
    }
}
