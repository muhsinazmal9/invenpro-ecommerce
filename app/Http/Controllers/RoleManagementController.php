<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\User;
use App\Services\RoleManagementService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleManagementController extends Controller
{
    public function __construct(private RoleManagementService $roleManagementService)
    {
        $this->middleware('can:list_role')->only('index');
        $this->middleware('can:create_role')->only(['create', 'store']);
        $this->middleware('can:update_role')->only(['edit', 'update']);
        $this->middleware('can:delete_role')->only('destroy');
        $this->middleware('can:assign_role_user')->only('assignRole');
    }

    public function index(): View
    {
        $roles = Role::orderBy('name', 'asc')->get();

        return view('backend.role.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = Permission::orderBy('name', 'asc')->get();

        return view('backend.role.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {

        $role = Role::create(['name' => $request->name]);
        $role->givePermissionTo($request->permissions);

        return redirect()->route('admin.role.index')->with('success', 'Role created!');
    }

    public function edit(Role $role): View
    {
        $permissions = Permission::orderBy('name', 'asc')->with('roles')->get();

        return view('backend.role.edit', compact('permissions', 'role'));
    }

    public function update(Role $role, UpdateRoleRequest $request): RedirectResponse
    {
        $role->update($request->only('name'));
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.role.index')->with('success', 'Role updated!');
    }

    public function destroy(Role $role): JsonResponse
    {

        $this->getRolePermissions($role) && $role->revokePermissionTo($this->getRolePermissions($role));

        if ($role->delete()) {
            return success('Role Deleted!');
        }

        return error('Something went wrong!');

    }

    protected function getRolePermissions(Role $role): array
    {
        return $role->permissions->pluck('name')->toArray();
    }

    public function assignRole(User $user, Role $role): JsonResponse
    {
        $user->syncRoles($role);

        return success('User Assigned to '.$role->name, $user);
    }

    public function storePermission()
    {
        // Permission::create(['name' => "Site Settings"]);
        // return 'Permission Created';
    }

    public function getList(Request $request)
    {

        $roles = $this->roleManagementService->getList($request);

        if ($roles->getData()->success) {
            return response()->json($roles->getData()->data);
        }

        return response()->json([]);

    }
}
