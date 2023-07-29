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
        if (!session('current_role'))
            return redirect()->route('exception.show', 1);
        elseif (session('current_role') == 'hod' || session('current_role') == 'super') {
            if (!session('department_id'))
                return redirect()->route('exception.show', 2);
            if (!session('semester_id'))
                return redirect()->route('exception.show', 3);
            else return $next($request);
        } elseif (session('current_role') == 'teacher') {
            if (!session('semester_id'))
                return redirect()->route('exception.show', 3);
            else return $next($request);
        }
    }
}
