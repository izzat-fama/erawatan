<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoleAdminSemak
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
        //semak adakah logged in user mempunyai peranan sebagai Admin?
        if( !$request->user()->isAdminSemak())
        {
            return redirect()->route('home')
            ->with('alert-danger', 'Anda tidak mempunyai kebenaran untuk mengakses ke halaman yang hendak dibuka.');
        }
        
        return $next($request);
    }
}
