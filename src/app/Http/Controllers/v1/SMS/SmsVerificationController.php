<?php

namespace App\Http\Controllers\v1\SMS;

use Alizne\SmsApi\SMSApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\SMS\SMSVerification\SendRequest;
use Illuminate\Support\Facades\Redis;

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

    public function verify()
    {
        # TODO implement verify phone number of user
    }
}
