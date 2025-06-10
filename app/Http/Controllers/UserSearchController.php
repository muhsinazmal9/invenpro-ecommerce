<?php

namespace App\Http\Controllers;

use App\Models\UserSearch;
use App\Services\UserSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserSearchController extends Controller
{
    public function __construct(private UserSearchService $userSearchService)
    {
        $this->middleware('can:'.UserSearch::LIST)->only(['getList', 'index']);
        $this->middleware('can:'.UserSearch::DELETE)->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.user_searches.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserSearch $userSearch)
    {
        $userSearch->delete();

        return success(__('app.user_search_deleted_successfully'));

    }

    public function getList(Request $request): JsonResponse
    {
        $userSearches = $this->userSearchService->getList($request);

        if ($userSearches->getData()->success) {
            return response()->json($userSearches->getData()->data);
        }

        return response()->json([]);

    }
}
