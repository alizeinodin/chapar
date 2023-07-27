<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class CodeSent
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        $phoneNumber = $request['phone'];

        $phoneNumberExistsInRedis = Redis::exists("phone_{$phoneNumber}");
        if ($phoneNumberExistsInRedis)
            return $next($request);

        # TODO return exception replace with response

        $response = [
            'message' => __('ابتدا شماره تلفن همراه خود را وارد کنید.')
        ];

        return \response()
            ->json($response, Response::HTTP_FORBIDDEN);
    }
}
