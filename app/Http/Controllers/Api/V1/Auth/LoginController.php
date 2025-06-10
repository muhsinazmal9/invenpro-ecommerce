<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Constants\Activity;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * login a user via API
     */
    public function login(Request $request): JsonResponse
    {
        $validation = validateData([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validation->fails()) {
            return error('Validation Error', $validation->errors());
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return error('The provided credentials are incorrect.', 401);
        } elseif ($user->roles[0]->name != 'customer') {
            return error('User is not a customer.', 422);
        } elseif ($user->status == User::STATUS['blocked']) {
            return error('User Blocked.', 422);
        } else {
            // Delete all previous tokens
            $user->tokens()->delete();
            // Generate New Token
            $token = $user->createToken(User::BEARER);
            $user->status = User::STATUS['active'];

            $data = [
                'token_type' => User::BEARER,
                'token' => $token->plainTextToken,
                'user' => new UserResource($user),
            ];

            // added activity log

            activity()
                ->performedOn($user)
                ->causedBy($user)
                ->event(Activity::LOGIN)
                ->withProperties([
                    Activity::LOGIN => $user,
                ])
                ->log('User logged in successfully');

            return success('User auth token generated successfully', $data);
        }
    }

    public function social_login(Request $request): JsonResponse
    {
        $validation = validateData([
            'email' => 'required|email',
            'fname' => 'required',
            'lname' => 'required',
            'token' => 'required',
            'image' => 'nullable',
            'provider' => 'required|in:google,facebook,twitter',
        ]);

        if ($validation->fails()) {
            return error('Validation Error', 403, $validation->errors());
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (! $user) {
                $user = new User();
                $user->username = generateUsername($request->fname, $request->lname);
            }

            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->email = $request->email;
            $user->email_verified_at = now();
            $user->token = $request->token;
            $user->refresh_token = $request->refreshToken;
            isset($request->image) ? $user->image = $request->image : null;
            $user->provider = $request->provider;
            $user->save();
            $user->assignRole(User::CUSTOMER);
            $user->tokens()->delete();
            // Generate New Token
            $token = $user->createToken(User::BEARER);
            $user->status = User::STATUS['active'];

            $data = [
                'token_type' => User::BEARER,
                'token' => $token->plainTextToken,
                'user' => new UserResource($user),
            ];

            // added activity log

            activity()
                ->performedOn($user)
                ->causedBy($user)
                ->event(Activity::LOGIN)
                ->withProperties([
                    Activity::LOGIN => $user,
                ])
                ->log("User logged in with {$request->provider} successfully");

            return success('Social login success and user auth token generated successfully', $data);

        } catch (\Exception $e) {
            logError('Social login error', $e);

            return error('Social login couldn\'t be processed', data: $e);
        }
    }

    /**
     * logout a user via API
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $request->user()->currentAccessToken()->delete();

        // added activity log

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->event(Activity::LOGOUT)
            ->withProperties([
                Activity::LOGOUT => $user,
            ])
            ->log('User logged out successfully');

        return success('User logged out successfully');
    }
}
