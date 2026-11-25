<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $u = Auth::guard('admin')->user();
        if (!$u || !$u->is_active) {
            Auth::guard('admin')->logout();
            return redirect()->route('login')->withErrors(['username' => 'Silakan masuk sebagai admin aktif.']);
        }
        return $next($request);
    }
}