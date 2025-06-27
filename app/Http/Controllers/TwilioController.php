<?php

namespace App\Http\Controllers;

use App\Http\Services\TwilioSmsService;
use Illuminate\Http\Request;

class TwilioController extends Controller
{
    public function sendOtp(Request $request, TwilioSmsService $twilioSmsService)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $phone = $request->input('phone');
        $phone_number = $this->parsePhoneNumber($phone);

        try {
            $response = $twilioSmsService->sendOtp($phone_number);
            return response()->json(['message' => 'OTP sent successfully', 'sid' => $response->sid], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send OTP: ' . $e->getMessage()], 500);
        }
    }

    public function verifyOtp(Request $request, TwilioSmsService $twilioSmsService)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|string',
        ]);

        $phone = $request->input('phone');
        $otp = $request->input('otp');

        $phone_number = $this->parsePhoneNumber($phone);

        try {
            $response = $twilioSmsService->verifyOtp($phone_number, $otp);
            if ($response->status === 'approved') {
                return response()->json(['message' => 'OTP verified successfully'], 200);
            } else {
                return response()->json(['error' => 'Invalid OTP'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to verify OTP: ' . $e->getMessage()], 500);
        }
    }

    public function parsePhoneNumber(string $phone)
    {
        $input = preg_replace('/[^\d+]/', '', $phone);
        $phone_number = "+91" . ltrim($input, '0');
        return $phone_number;
    }
}
