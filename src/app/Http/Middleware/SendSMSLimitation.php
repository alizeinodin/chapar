<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class SendSMSLimitation
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $phone = $request['phone'];

        if (!Redis::get("phone_{$phone}")) {
            return $next($request);
        }

        $response = [
            'message' => __("لطفا چند لحظه صبر کنید")
        ];
        return \response()
            ->json($response, Response::HTTP_FORBIDDEN);
    }
}
