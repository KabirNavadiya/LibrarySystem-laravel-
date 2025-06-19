<?php

namespace App\Http\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $serviceAccountPath = storage_path('app/private/REDACTED_PROJECT_ID-firebase-adminsdk-fbsvc-5902022678.json');

        $factory = (new Factory())->withServiceAccount($serviceAccountPath);
        $this->messaging = $factory->createMessaging();
    }

    public function sendPushNotification($token,$title,$body,$data = [])
    {
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification([
                'title' => $title,
                'body' => $body,
            ])
            ->withData($data);
        try {
            $this->messaging->send($message);
        } catch (\Exception $e) {
            throw new \Exception('Failed to send push notification: ' . $e->getMessage());
        }
    }
}
