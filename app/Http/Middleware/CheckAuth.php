<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\ResponseHelper;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = ResponseHelper::user();
        if (!$user['type']) return redirect('login');
        if ($role != $user['type']) return redirect('/');
        
        return $next($request);
    }
}
