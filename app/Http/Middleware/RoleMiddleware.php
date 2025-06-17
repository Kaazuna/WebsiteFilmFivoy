<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{

    public function handle(Request $request, Closure $next , $role)
    {
        if(!session()->has('user')){
            return redirect()->route('login')->withErrors(['login'=> 'Harus login cuy']);
        }

        $user = session('user');
        if (!$user || $user['role'] !== $role){
            return redirect('/login')->withErrors(['role','Akses Ditolak']);
        }
        return $next($request);
    }
}
