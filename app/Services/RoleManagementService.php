<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleManagementService
{
    public function getList(Request $request): JsonResponse
    {

        try {
            $columns = [
                0 => 'name',
                1 => 'permission',
                2 => 'created_at',
                3 => 'actions',

            ];

            $roles = Role::query();

            $totalData = $roles->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')] ?? 'id';
            $dir = $request->input('order.0.dir', 'desc');

            if (empty($request->input('search.value'))) {
                $roles = $roles
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');

                $roles = $roles
                    ->where('name', 'LIKE', "%{$searchInput}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $roles->count();
            }

            $data = [];

            if (!empty($roles)) {
                foreach ($roles as $role) {

                    $edit = 'Edit';
                    $delete = 'Delete';
                    $view = 'View';
                    $permissions = json_encode($role->permissions->pluck('name')->toArray());
                    $viewHtml = "
                                <button class='show-permissions-btn main-btn success-btn-light btn-hover btn-sm'  onclick='viewRole($permissions)' data-permissions= '$role->permissions' data-bs-toggle='modal'
                                    data-bs-target='#roleModal' style='padding:4px 10px'>
                                    {$view}
                                </button>";

                    $editBtn = "<a
                                href='" . route('admin.role.edit', $role->id) . "'
                                   class='dropdown-item'>{$edit}</a>";

                    $deleteBtn = "<button
                                        type='button'
                                        onclick=deleteRole(':id',this.parentElement.parentElement)
                                        class='dropdown-item'>
                                        {$delete}
                                    </button>";

                    $deleteBtn = str_replace(':id', $role->id, $deleteBtn);

                    $nestedData['name'] = $role->name;
                    $nestedData['permission'] = $viewHtml;
                    $nestedData['created_at'] = $role->created_at->format('y/m/d');
                    $nestedData['actions'] = "<div class='dropdown text-center'>
                    <button class='dropdown-toggle' onclick='toggleActions(this)' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa-solid fa-ellipsis'></i>
                    </button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                        {$editBtn}
                        {$deleteBtn}
                    </div>
                  </div>";

                    $data[] = $nestedData;
                }
            }

            $json_data = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ];

            return success(__('app.role_list'), $json_data);
        } catch (\Exception $e) {
            logError('role List Error ', $e);

            return error('Something went wrong');
        }
    }
}
