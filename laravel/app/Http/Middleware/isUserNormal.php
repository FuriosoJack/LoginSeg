<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class isUserNormal
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
      if(Auth::user()->isRol('usr')){
        return $next($request);
     }else{
       return redirect()->route('viewAdmin');
     }
    }
}
