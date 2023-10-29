<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyExceptionHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session('role'))
            return redirect()->route('exception.show', 1);
        elseif (session('role') == 'hod' || session('role') == 'super' || session('role') == 'internal' || session('role') == 'coordinator') {
            if (!session('department_id'))
                return redirect()->route('exception.show', 2);
            if (!session('semester_id'))
                return redirect()->route('exception.show', 3);
            else return $next($request);
        } elseif (session('role') == 'teacher') {
            if (!session('semester_id'))
                return redirect()->route('exception.show', 3);
            else return $next($request);
        }
    }
}
