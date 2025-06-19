<?php

namespace App\Http\Controllers;

use App\Http\Services\FirebaseService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function sendPushNotifications(Request $request){
        $validatedData = $request->validate([
            'token' => ['required', 'string'],
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
            'data' => ['nullable', 'array'],
        ]);

        $token = $request->input('token');
        $title = $request->input('title');
        $body = $request->input('body');
        $data = $request->input('data', []);

        try {
            $this->firebaseService->sendPushNotification($token, $title, $body, $data);
            return response()->json(['message' => 'Notifications sent successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send notifications: ' . $e->getMessage()], 500);
        }
    }
}
