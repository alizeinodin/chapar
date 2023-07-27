<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationChecking
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
        $user = User::where(['phone' => $phone])->first();

        if (!$user)
            return $next($request);

        # TODO implement Exception for this section, after, add return type for this function

        $response = [
            'message' => __('کاربر با این شماره موبایل موجود می باشد. لطفا وارد شوید.')
        ];

        return \response()
            ->json($response, Response::HTTP_FORBIDDEN);

    }
}
