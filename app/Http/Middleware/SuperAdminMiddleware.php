<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if(!$user || !app(AuthService::class)->isSuperAdmin($user)) {
            return redirect()
                ->route('home.index')
                ->with('error', 'Unathorized access.');
        }

        return $next($request);
    }
}
