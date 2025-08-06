<?php

namespace App\Http\Middleware\Api\v1;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonMiddleware
{
    public function handle(Request $request, Closure $next): JsonResponse
    {
        if (!$request->expectsJson() && $request->header('Content-Type') !== 'application/json') {
            return response()->json(
                [
                    'error' => 'Only JSON requests are accepted.'
                ],
                Response::HTTP_UNSUPPORTED_MEDIA_TYPE
            );
        }

        $request->headers->set('Accept', 'application/json');

        $response = $next($request);

        if (!$response instanceof JsonResponse) {
            $decoded = json_decode($response->getContent(), true);

            $response = response()->json(
                $decoded ?? ['message' => $response->getContent()],
                $response->status(),
                $response->headers->all()
            );
        }

        return $response;
    }
}
