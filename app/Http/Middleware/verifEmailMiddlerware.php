<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class verifEmailMiddlerware
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
        if($datauser->email_verified_at) {
            return $next($request);
        }
            abort(404);
    }
}
