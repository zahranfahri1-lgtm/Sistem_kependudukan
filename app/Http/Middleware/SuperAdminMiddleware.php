<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        abort_unless(Auth::guard('admin')->user()?->isSuperAdmin(), 403, 'Hanya untuk Super Admin.');
        return $next($request);
    }
}