<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SimpleAuth
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        if (!empty($roles) && !in_array($userRole, $roles)) {
            if ($userRole === 'admin') {
                return redirect()->route('admin.page');
            }
            return redirect()->route('userPage')->with('error', 'Access Denied!');
        }
        
        return $next($request);
    }
}
