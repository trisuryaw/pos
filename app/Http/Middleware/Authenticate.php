<?php

namespace App\Http\Middleware;

use http\Env\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Unauthorization'
            ], \Illuminate\Http\Response::HTTP_UNAUTHORIZED));
        }
    }
}
