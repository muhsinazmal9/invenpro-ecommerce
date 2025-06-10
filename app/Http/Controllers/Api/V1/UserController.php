<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct(private MailService $mailService)
    {

    }

    public function userDetails(): JsonResponse
    {
        $user = User::find(auth()->user()->id);

        return success('User retrieved successfully', new UserResource($user));
    }

    public function updatePersonalInformation(Request $request)
    {

        // $validation = validateData([
        //     'fname' => 'required',
        //     'lname' => 'required',
        //     'image' => 'nullable|image|mimes:jpeg,bmp,png,jpg|max:2048',
        //     'phone' => 'nullable|unique:users,phone,'.auth()->user()->id,
        //     'gender' => 'nullable',
        //     'date_of_birth' => 'nullable|date_format:Y-m-d',
        // ]);

        $validation = Validator::make(
            request()->all(),
            [
                'fname' => 'required',
                'lname' => 'nullable',
                'image' => 'nullable|image|mimes:jpeg,bmp,png,jpg|max:2048',
                'phone' => 'nullable|unique:users,phone,' . auth()->user()->id,
                'gender' => 'nullable',
                'date_of_birth' => 'nullable|date_format:Y-m-d',
            ],
            [
                'image.max' => 'The maximum size of the image is 2 MB.',
            ]
        );

        if ($validation->fails()) {
            return error('Validation Error', 403, $validation->errors());
        }

        $user = User::find(auth()->user()->id);
        if ($user->id != auth()->user()->id) {
            return error('You are not authorized to access this resource');
        }

        $user->fname = $request->fname;
        $user->lname = $request->lname;
        isset($request->gender) ? $user->gender = $request->gender : null;
        isset($request->phone) ? $user->phone = $request->phone : null;
        isset($request->date_of_birth) ? $user->date_of_birth = $request->date_of_birth : null;
        if ($request->hasFile('image')) {
            // remove previous image if exists
            if ($user->image != getSetting('default_avatar') && file_exists($user->image)) {
                unlink($user->image);
            }

            $image = $request->file('image');
            $filename = Str::slug($user->username) . '-' . rand(1000, 9999) . '.' . 'webp';
            $url = User::IMAGE_DIRECTORY . $filename;
            $location = public_path($url);
            saveImage($image, $location);
            $input['image'] = $url;
            $user->image = $input['image'];
        }
        $user->save();

        return success('Profile updated successfully', new UserResource($user));
    }
}