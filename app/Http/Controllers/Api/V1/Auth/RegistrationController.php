<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use App\Constants\Activity;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\MailService;
use Illuminate\Http\JsonResponse;
use App\Mail\EmailVerificationMail;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\StoreRegistrationRequest;

class RegistrationController extends Controller
{
    public function __construct(
        public MailService $mailService,
    ) {

    }

    public function register(StoreRegistrationRequest $request): JsonResponse
    {

        if (auth()->check()) {
            return error('You are already logged in', 400);
        }

        $username = Str::slug($request->fname . ' ' . $request->lname ?? ''); 
        $counter = 1;
    
        while (User::where('username', $username)->exists()) {
            $username = "$username-$counter";
            $counter++;
        }
    
        $user = User::create([
            'fname' => $request->fname,
            'username' => $username,
            'phone' => $request->phone,
            'email' => $request->email,
            'otp' => mt_rand(100000, 999999),
            'otp_expired_at' => now()->addMinutes(5),
        ]);
 
        $user->assignRole('customer');

        $token = $user->createToken(User::BEARER);
    
        $data = [
            'token_type' => 'Bearer',
            'token' => $token->plainTextToken,
            'user' => new UserResource($user),
        ]; 
        
        Mail::to($user->email)->send(new EmailVerificationMail($user)); 

        // added activity log
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->event(Activity::SIGNUP)
            ->withProperties([
                Activity::SIGNUP => $user,
            ])
            ->log('New User Signup successfully');

        return success('User created successfully, Sent confirmation mail to the email address', $data);
    }

    public function resendVerificationOtp(Request $request)
    {

        if (! auth()->check()) {
            return error('You are not logged in', 401);
        }

        $user = User::find(auth()->user()->id);

        if (! $user) {
            return error('User not found', 404);
        }

        if ($user->email_verified_at) {
            return error('Email already verified', 409);
        }

        $user->otp = mt_rand(100000, 999999);
        $user->otp_expired_at = now()->addMinutes(5);
        $user->save();

        Mail::to($user->email)->send(new EmailVerificationMail($user));

        return success('Otp resent successfully');
    }

    public function verifyOtp(Request $request)
    {

        if (! auth()->check()) {
            return error('You are not logged in', 401);
        }

        $validation = validateData([
            'otp' => 'required|numeric',
        ]);

        if ($validation->fails()) {
            return error('not created', $validation->errors(), 403);
        }

        $user = User::find(auth()->user()->id);

        if (! $user) {
            return error('User not found', 404);
        }

        if ($user->email_verified_at) {
            return error('Email already verified', 409);
        }

        if ($user->otp != $request->otp) {
            return error('Invalid otp', 400);
        }

        if ($user->otp_expired_at < now()) {
            return error('Otp expired', 400);
        }

        $user->email_verified_at = now();
        $user->save();

        return success('Otp verified successfully');
    }
}
