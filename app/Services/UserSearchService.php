<?php

namespace App\Services;

use App\Models\UserSearch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserSearchService
{
    public function getList(Request $request): JsonResponse
    {
        if (! checkUserPermission(UserSearch::LIST)) {
            return error('Permission Denied!', 403);
        }

        try {
            $columns = [
                0 => 'keyword',
                1 => 'count',
                4 => 'actions',
            ];

            $userSearches = UserSearch::query();
            $totalData = $userSearches->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'desc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            if ($order == 'actions') {
                $order = 'id';
            }

            if (empty($request->input('search.value'))) {
                $userSearches = $userSearches
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');
                $userSearches = $userSearches
                    ->where('keyword', 'LIKE', "%{$searchInput}%")
                    ->orWhere('count', 'LIKE', "%{$searchInput}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $userSearches->count();
            }

            $data = [];

            if (! empty($userSearches)) {
                foreach ($userSearches as $userSearch) {
                    /**
                     * HTMLs
                     */
                    $deleteBtn = "<button type='button' onclick=deleteUserSearch({$userSearch->id},this.parentElement.parentElement) class='main-btn danger-btn btn-hover btn-sm delete-btn'><i class='mdi mdi-trash-can-outline'></i></button>";

                    /**
                     * DATAs
                     */
                    $nestedData['keyword'] = $userSearch->keyword;
                    $nestedData['count'] = $userSearch->count;
                    $nestedData['actions'] = $deleteBtn;
                    $data[] = $nestedData;
                }
            }

            $json_data = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ];

            return success('User searches', $json_data);
        } catch (\Exception $e) {
            logError('User Search List Error ', $e);

            return error('Something went wrong');
        }
    }
}
