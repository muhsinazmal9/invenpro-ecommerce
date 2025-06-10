<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriberController extends Controller
{
    public function subscribe(Request $request)
    {

        $validate = validateData([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        if ($validate->fails()) {
            return error('Validation error', 403, $validate->errors());
        }

        $subscriber = Subscriber::create([
            'email' => $request->email,
            'is_subscribed' => true,
            'meta' => json_encode(['ip' => $request->getClientIp(), 'http_host' => $request->getHttpHost()]),
            'token' => Str::random(20).'--'.Str::random(15),
        ]);

        return success('Subscribed successfully');
    }
}
