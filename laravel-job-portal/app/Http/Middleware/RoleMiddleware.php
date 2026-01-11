<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (!$user->isActive()) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Twoje konto zostało zablokowane.');
        }

        if (!in_array($user->role?->nazwa, $roles)) {
            abort(403, 'Brak dostępu do tej strony.');
        }

        return $next($request);
    }
}
