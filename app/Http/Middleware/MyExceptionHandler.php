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
            return redirect()->route('role_missed_exception');

        else if (session('current_role') == 'hod') {
            if (!session('department_id'))
                return redirect()->route('department_missed_exception');
            else if (!session('semester_id'))
                return redirect()->route('semester_missed_exception');
        } else if (session('current_role') == 'teacher') {
            if (!session('semester_id'))
                return redirect()->route('semester_missed_exception');
        }
        return $next($request);
    }
}
