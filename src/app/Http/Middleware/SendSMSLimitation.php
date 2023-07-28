<?php

namespace App\Http\Middleware;

use App\Exceptions\UserForbidden;
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

        $phoneNumberInRedis = Redis::get("phone_{$phone}");
        $jsonDecodedDataFromRedis = json_decode($phoneNumberInRedis);

        if (!$phoneNumberInRedis or $jsonDecodedDataFromRedis->status != 'pending') {
            return $next($request);
        }

        $message = 'لطفا چند لحظه صبر کنید.';

        throw new UserForbidden($message);
    }
}
