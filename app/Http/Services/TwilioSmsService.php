<?php

namespace App\Http\Services;

use Twilio\Rest\Client;

class TwilioSmsService
{
    protected $client;
    protected $verifySid;
    public function __construct()
    {
        $this->client = new Client(config('services.twilio.sid'), config('services.twilio.token'));
        $this->verifySid = config('services.twilio.verify_sid');
    }

    public function sendOtp(string $phone)
    {
        return $this->client->verify
            ->v2
            ->services($this->verifySid)
            ->verifications
            ->create($phone, 'sms');
    }

    public function verifyOtp(string $phone, string $otp)
    {
        return $this->client->verify
            ->v2
            ->services($this->verifySid)
            ->verificationChecks
            ->create([
                'to' => $phone,
                'code' => $otp
            ]);
    }
}
