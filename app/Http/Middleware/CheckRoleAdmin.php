<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoleAdmin
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
        // Semak adakah user yang login mempunyai role/peranan sebagai admin?
        if ( ! $request->user()->isAdmin() )
        {
            return redirect()->route('home')
            ->with('alert-danger', 'Anda tidak mempunyai kebenaran untuk mengakses ke halaman yang ingin dibuka.');
        }

        return $next($request);
    }
}
