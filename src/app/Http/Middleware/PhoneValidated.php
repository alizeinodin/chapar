<?php

namespace App\Http\Middleware;

use App\Enum\PhoneStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class PhoneValidated
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
        $phone = $request['phone'];
        $redis = json_decode(Redis::get("phone_{$phone}"));

        if ($redis->status = PhoneStatus::VERIFIED)
            return $next($request);

        # TODO implement Exception for this section, after, add return type for this function

        $response = [
            'message' => __('ابتدا شماره تلفن خود را تایید کنید')
        ];

        return \response()
            ->json($response, Response::HTTP_FORBIDDEN);

    }
}
