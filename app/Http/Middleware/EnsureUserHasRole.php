<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $requiredRole = UserRole::tryFrom($role);

        abort_if($requiredRole === null, Response::HTTP_FORBIDDEN);
        abort_unless($request->user()?->role === $requiredRole, Response::HTTP_FORBIDDEN);

        return $next($request);
    }
}
