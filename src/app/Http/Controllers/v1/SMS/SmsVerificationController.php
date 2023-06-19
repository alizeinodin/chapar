<?php

namespace App\Http\Controllers\v1\SMS;

use Alizne\SmsApi\SMSApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\SMS\SMSVerification\SendRequest;
use App\Http\Requests\SMS\SMSVerification\VerifyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class SmsVerificationController extends Controller
{
    private SMSApi $sms;

    public function __construct(SMSApi $sms)
    {
        $this->sms = $sms;
    }

    protected function code(): int
    {
        return mt_rand(100000, 999999);
    }

    protected function message(int $code): string
    {
        return "کد تایید شما {$code} می باشد \n چاپار";
    }

    /**
     * @throws \Exception
     */
    public function send(SendRequest $request)
    {
        $validatedData = $request->validated();
        $code = $this->code(); // random code that send to user
        $message = $this->message($code);

        // store in db
        Redis::set('phone_' . $validatedData['phone'], $code);

        // send code to user phone number
        $this->sms->SendingSMS([$validatedData['phone']], $message);
    }

    public function verify(VerifyRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $phone = json_decode(Redis::get("phone_{$validatedData['phone']}"));

        if ($validatedData['code'] === $phone['code']) {
            return response()->json([
                'message' => 'the phone number validated.',
            ], Response::HTTP_ACCEPTED);
        }

        return \response()->json([
            'message' => 'the code is not valid.'
        ], Response::HTTP_FORBIDDEN);
    }
}
