<?php
namespace EscireOrlab\Connect\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckConnectStatus
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->connect_id && !$user->connect_active) {
                Auth::logout();
                return redirect('/'); // O redirige a donde necesites
            }
        }

        return $next($request);
    }
}
