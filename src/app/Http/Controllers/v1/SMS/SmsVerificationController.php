<?php

namespace App\Http\Controllers\v1\SMS;

use Alizne\SmsApi\SMSApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\SMS\SMSVerification\SendRequest;
use App\Http\Requests\SMS\SMSVerification\VerifyRequest;
use Exception;
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
     * @throws Exception
     */
    public function send(SendRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $code = $this->code(); // random code that send to user
        $message = $this->message($code);

        # TODO add repository pattern
        // store in db
        # TODO add expire time for redis set
        Redis::set('phone_' . $validatedData['phone'], json_encode([
            'code' => $code,
            'status' => 'pending' # TODO implement enum for status
        ]));

        // send code to user phone number
        $this->sms->SendingSMS([$validatedData['phone']], $message);

        return \response()->json([
            'message' => 'the code sent to phone number', # TODO localization
            'phone_number' => $validatedData['phone'],
        ], Response::HTTP_OK);
    }

    public function verify(VerifyRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        # TODO add search for key and error handling
        $phone = json_decode(Redis::get("phone_{$validatedData['phone']}"));

        if ((int) $validatedData['code'] === $phone->code) {
            $phone->status = 'verified'; # TODO implement php enum for verified

            return response()->json([
                'message' => 'the phone number validated.', # TODO localization
            ], Response::HTTP_ACCEPTED);
        }

        return \response()->json([
            'message' => 'the code is not valid.', # TODO localization
        ], Response::HTTP_FORBIDDEN);
    }
}
