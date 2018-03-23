<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class UserLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user !== null) {
            App()->setLocale($user->getAttribute('locale'));
        }
        return $next($request);
    }
}
