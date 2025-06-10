<?php

namespace App\Services;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserService
{
    public function create(StoreUserRequest $request): JsonResponse
    {
        try {
            $request['username'] = Str::slug($request->fname.' '.$request->lname);

            // check username availability
            $i = 1;
            while (User::where('username', $request['username'])->exists()) {
                $request['username'] = Str::slug($request->fname.' '.$request->lname).'-'.$i;
                $i++;
            }

            $inputs = $request->except('_token','image');

            $inputs['password'] = bcrypt($request->password);
            $inputs['status'] = $request->status == User::STATUS['active'] ? User::STATUS['active'] : User::STATUS['blocked'];

            if ($request->has('image')) {
                $image = $request->image;
                $filename = Str::slug($request->username) . '-' . rand(1000, 9999) . '.' . 'webp';
                $url = User::IMAGE_DIRECTORY . $filename;
                $location = public_path($url);
                saveImage($image, $location);
                $inputs['image'] = $url;
            }


            $user = User::create($inputs);
            $user->assignRole($request->role);

            return success('User created successfully', $user);
        } catch (\Exception $e) {
            logError('User Create Error', $e);

            return error('Something went wrong');
        }
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        try {
            $inputs = $request->except('_token', '_method','image');
            $inputs['password'] = bcrypt($request->password) ?? $user->password;
            $inputs['status'] = $request->status == User::STATUS['active'] ? User::STATUS['active'] : User::STATUS['blocked'];
            if ($request->has('image') && $request->image != null && $request->image != '') {
                $oldImage = public_path($user->image);
                if (file_exists($oldImage)) {
                    deleteImage($user->image);
                }

                $image = $request->image;
                $filename = Str::slug($request->name) . '-' . rand(1000, 9999) . '.' . 'webp';
                $url = user::IMAGE_DIRECTORY . $filename;
                $location = public_path($url);
                saveImage($image, $location);

                $inputs['image'] = $url;
            }


            $user->update($inputs);
            $user->syncRoles($request->role);

            return success('User updated successfully', $user);
        } catch (\Exception $e) {
            logError('User Update Error', $e);

            return error('Something went wrong');
        }
    }

    public function getList(Request $request): JsonResponse
    {
        if (! checkUserPermission(User::LIST)) {
            return error('Permission Denied!', 403);
        }

        try {

            $columns = [
                0 => 'image',
                1 => 'fname',
                2 => 'lname',
                3 => 'email',
                4 => 'status',
                5 => 'role',
                6 => 'created_at',
                7=> 'actions',
            ];

            $users = User::query()->with('roles');
            $type = $request->type;

            if ($type == 'customers') {

                $users = $users->where(function ($query) {
                    $query->whereHas('roles', function ($query) {
                        $query->where('name', 'customer');
                    });
                });

            } else {
                $users = $users->where(function ($query) {
                    $query->whereHas('roles', function ($query) {
                        $query->where('name', '!=', 'customer');
                    });
                });

            }

            $totalData = $users->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'desc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            if ($order == 'actions' || $order == 'role') {
                $order = 'fname';
            }

            if (empty($request->input('search.value'))) {
                $users = $users->where('id', '!=', auth()->user()->id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');

                $users = $users->where('id', '!=', auth()->user()->id)
                    ->where(function ($query) use ($searchInput) {
                        $query->where('fname', 'LIKE', "%{$searchInput}%");
                        $query->orWhere('lname', 'LIKE', "%{$searchInput}%");
                        $query->orWhere('email', 'LIKE', "%{$searchInput}%");
                        $query->orWhere(function ($query) use ($searchInput) {

                            if ($searchInput == 'active') {
                                $query->where('status', User::STATUS['active']);
                            }

                            if ($searchInput == 'blocked') {
                                $query->where('status', User::STATUS['blocked']);
                            }
                        });

                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered = $users->count();
            }

            $data = [];

            if (! empty($users)) {

                foreach ($users as $user) {

                    $editLink = route('admin.users.edit', $user->username ?? $user->id);
                    $showLink = route('admin.users.show', $user->username ?? $user->id);

                    $userStatus = $user->status == User::STATUS['active'] ? 'ACTIVE' : 'BLOCKED';

                    $userStatusClass = $user->status == User::STATUS['active'] ? 'success' : 'danger';

                    $username = $user->username ?? $user->id;

                    $status = "<button
                                onclick=statusUpdate('{$username}',this)
                                class='main-btn {$userStatusClass}-btn-light btn-hover btn-sm'
                                style='padding:4px 10px'
                                type='button'>{$userStatus}
                                </button>";
                    $roleName = $user->roles[0]->name ?? 'Add Role';

                    if (checkUserPermission('delete_role')) {
                        $role = "<button
                        onclick='setAssignRoleModaldata(this)'
                        data-role='{$roleName}'
                        data-name='{$user->username}'
                        data-id='{$user->username}'
                        data-bs-toggle='modal'
                        data-bs-target='#roleModal'
                        class='main-btn success-btn-light btn-hover btn-sm role-btn-{$user->username}'
                        style='padding:4px 10px' type='button' title='Role : {$roleName}' > {$roleName}</button>";
                    } else {
                        $role = "<button class='main-btn success-btn-light btn-hover btn-sm' style='padding:4px 10px;' type='button' title='DELETE' > {$roleName}</button>";
                    }

                    $view = 'View';
                    $edit = 'Edit';
                    $userImage = asset($user->image);
                    $image = "<img class='rounded' src='{$userImage}' alt='{$user->fname}' width='75'>";
                    $detailsBtn = "<a  href='{$showLink}' title='Details' class='dropdown-item'>{$view}</a>";
                    $editBtn = "<a  href='{$editLink}' title='Edit'  class='dropdown-item'>{$edit}</a>";

                    $nestedData['image'] = $image;
                    $nestedData['fname'] = $user->fname;
                    $nestedData['lname'] = $user->lname ?? "<span class='text-muted text-sm'>Empty<span>";
                    $nestedData['email'] = $user->email;
                    $nestedData['status'] = $status;
                    $nestedData['role'] = $role;
                    $nestedData['created_at'] = $user->created_at->format('d-m-Y');
                    $nestedData['actions'] = "<div class='dropdown text-center'>
                    <button class='dropdown-toggle' onclick='toggleActions(this)' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa-solid fa-ellipsis'></i>
                    </button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                        {$detailsBtn}
                        {$editBtn}
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

            return success('User List', $json_data);
        } catch (\Exception $e) {
            logError('User List Error', $e);

            return error('Something went wrong!');
        }
    }
}
