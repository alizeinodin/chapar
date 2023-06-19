<?php

namespace App\Http\Controllers\v1\SMS;

use Alizne\SmsApi\SMSApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\SMS\SMSVerification\SendRequest;

class SmsVerificationController extends Controller
{
    private SMSApi $sms;

    public function __construct(SMSApi $sms)
    {
        $this->sms = $sms;
    }

    public function send(SendRequest $request)
    {
        # TODO implement send sms verification for phone number
    }

    public function verify()
    {
        # TODO implement verify phone number of user
    }
}
