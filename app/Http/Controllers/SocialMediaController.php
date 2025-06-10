<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSocialMediaRequest;
use App\Http\Requests\UpdateSocialMediaRequest;
use App\Models\SocialMedia;
use App\Services\SocialMediaService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function __construct(private SocialMediaService $socialMediaService)
    {
        $this->middleware('can:'.SocialMedia::SOCIAL_MEDIA_SETTINGS)->only(['index', 'store', 'update', 'destroy', 'getList']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

        $platforms = collect(json_decode(file_get_contents(base_path('json/social_media.json'))));

        return view('backend.settings.social_media.index', compact('platforms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSocialMediaRequest $request): JsonResponse
    {

        try {
            $socialMedia = $this->socialMediaService->store($request);

            if ($socialMedia->getData()->status) {
                return success(__('app.social_media_added_successfully'), $socialMedia->getData()->data);
            } else {
                return error(__($socialMedia->getData()->message));
            }

        } catch (\Exception $e) {

            logError('SocialMediaController@store', $e);

            return error(__('app.something_went_wrong'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocialMediaRequest $request, SocialMedia $social_medium)
    {
        try {
            $socialMedia = $this->socialMediaService->update($request, $social_medium);

            if ($socialMedia->getData()->status) {
                return success(__('app.social_media_added_successfully'), $socialMedia->getData()->data);
            } else {
                return error(__($socialMedia->getData()->message));
            }

        } catch (\Exception $e) {

            logError('SocialMediaController@store', $e);

            return error(__('app.something_went_wrong'));
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialMedia $social_medium)
    {
        $social_medium->delete();

        return success(__('app.social_media_deleted_successfully'));
    }

    public function getList(Request $request): JsonResponse
    {
        $socialMedia = $this->socialMediaService->getList($request);

        if ($socialMedia->getData()->success) {
            return response()->json($socialMedia->getData()->data);
        }

        return response()->json([]);

    }

    public function status(SocialMedia $social_medium): JsonResponse
    {
        $social_medium->status = ! $social_medium->status;
        $social_medium->save();

        return success(__('app.social_media_status_updated_successfully'), $social_medium);
    }
}
