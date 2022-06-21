<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class CheckUserActivated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $currentRoute = Route::currentRouteName();

        if($user->activated == 1){
            return $next($request);
        } else {
            Log::info('Deactivated user attempted to visit '.$currentRoute.'. ', [$user]);
            return redirect('deactivated');
        }
    }
}
