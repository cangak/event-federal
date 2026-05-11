<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $plainToken = $request->bearerToken();

        if (! $plainToken) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $apiToken = ApiToken::with('user')
            ->where('token', hash('sha256', $plainToken))
            ->first();

        if (! $apiToken || ! $apiToken->user) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $apiToken->forceFill([
            'last_used_at' => now(),
        ])->save();

        $request->setUserResolver(fn () => $apiToken->user);

        return $next($request);
    }
}
