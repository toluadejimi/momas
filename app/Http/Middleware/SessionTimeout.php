<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    protected $timeout = 1800; // 30 minutes

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = session('lastActivityTime');
            if ($lastActivity && (time() - $lastActivity > $this->timeout)) {
                User::where('id', Auth::id())->update(['can_login' => 0]);
                Auth::logout();
                return redirect('/')->with('message', 'You have been logged out due to inactivity.');
            }
            session(['lastActivityTime' => time()]);
        }


        return $next($request);
    }
}
