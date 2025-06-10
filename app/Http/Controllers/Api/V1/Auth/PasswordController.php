<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Constants\Activity;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function __construct(
        private MailService $mailService
    ) {

    }

    public function changePassword(Request $request)
    {

        $validation = validateData([
            'old_password' => 'required',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        if ($validation->fails()) {
            return error('Validation Error', 403, $validation->errors());
        }

        $user = User::find(auth()->user()->id);

        if (! $user) {
            return error('User not found!', 404);
        }

        if (! Hash::check($request->old_password, $user->password)) {
            return error('Old password is invalid');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Generate New Token
        $token = $user->createToken(User::BEARER);

        // Delete all previous tokens
        $tokenId = $user->tokens()->latest()->first()->id;
        $user->tokens()->where('id', '!=', $tokenId)->delete();

        $data = [
            'token_type' => User::BEARER,
            'token' => $token->plainTextToken,
            'user' => new UserResource($user),
        ];

        // added activity log
        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->event(Activity::PASSWORD_CHANGE)
            ->log('Password changed successfully');

        return success('Password changed successfully', $data);

    }

    public function forgetPassword(Request $request): JsonResponse
    {

        $validation = validateData([
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validation->fails()) {
            return error('Validation Error', 403, $validation->errors());
        }

        $user = User::where('email', $request->email)->first();

        // check cookie
        $key = 'forget-password-'.$user->id;

        if (cache()->has($key)) {
            return error('Please wait for 1 minute before sending another request', 403);
        }

        cache()->put($key, '1', now()->addMinutes(1));

        if (! $user) {
            return error('User not exists for this email address', 404);
        }

        $otp = mt_rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expired_at' => now()->addMinutes(5),
        ]);

        $this->mailService->forgetPassword($user);

        return success('Reset Password OTP has been sent to your email address. Please check your email.');

    }

    public function checkOtp(Request $request)
    {

        $validation = validateData([
            'email' => 'required|email',
            'otp' => 'required',
        ]);

        if ($validation->fails()) {
            return error('Validation Error', 403, $validation->errors());
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return error('User not exists for this email address', 404);
        }

        if ($user->otp == null || $user->otp != $request->otp) {
            return error('OTP does not match', 403);
        }

        if ($user->otp_expired_at < now() || $user->otp_expired_at == null) {
            return error('OTP has been expired', 403);
        }

        $user->update([
            'otp' => mt_rand(100000, 999999),
            'otp_expired_at' => null,
        ]);

        $data = [
            'email' => $user->email,
            'token' => $this->createTempToken($user),
        ];

        return success('OTP matched successfully', $data);

    }

    public function resetPassword(Request $request)
    {

        $validation = validateData([
            'token' => 'required',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        if ($validation->fails()) {
            return error('Validation Error', 403, $validation->errors());
        }

        $token = explode(':', base64_decode($request->token));

        $user = User::where('otp', $token[0])->where('email', $token[1])->first();

        if (! $user) {
            return error('Invalid token', 403);
        }

        $user->password = Hash::make($request->password);
        $user->otp = null;
        $user->save();

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->event(Activity::PASSWORD_RESET)
            ->log('Password reset successfully');

        return success('Password reset successfully');
    }

    public function setPassword(Request $request): JsonResponse
    {
        $validation = validateData([
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        if ($validation->fails()) {
            return error('Validation Error', 403, $validation->errors());
        } 
    
        if (!auth()->check()) {
            return error('Session Expired', 401);
        }
    
        $user = User::find(auth()->user()->id);

        if (!$user) {
            return error('User not found', 404);
        }

        $tokenParts = explode('|', $request->token);
        if (count($tokenParts) !== 2) {
            return error('Invalid token format', 403);
        }

        $tokenId = $tokenParts[0];
        $rawToken = $tokenParts[1];

        $hashedToken = hash('sha256', $rawToken);

        $token = $user->tokens()
            ->where('id', $tokenId)
            ->where('token', $hashedToken)
            ->first();

        if (!$token) {  
            return error('Invalid token', 403);
        }
        if ($user->password) {
            return error('Password already set', 403);
        }

        $user->update(['password' => Hash::make($request->password)]);

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->event(Activity::PASSWORD_SET)
            ->withProperties([
                Activity::PASSWORD_SET => $user,
            ])
            ->log('Password set successfully');

        return success('Password set successfully', new UserResource($user));
    }
    private function createTempToken(User $user): string
    {
        return base64_encode($user->otp.':'.$user->email);
    }
}