<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
        // Check User Permissions
        $this->middleware('can:'.User::LIST)->only(['index', 'getList']);
        $this->middleware('can:'.User::READ)->only('show');
        $this->middleware('can:'.User::CREATE)->only(['create', 'store']);
        $this->middleware('can:'.User::UPDATE)->only(['edit', 'update']);
        $this->middleware('can:'.User::DELETE)->only('destroy');
        $this->middleware('can:'.User::STATUS_UPDATE)->only('statusUpdate');
    }

    public function index(): View
    {
        $roles = Role::latest()->get();

        return view('backend.users.index', compact('roles'));
    }

    public function create(): View
    {
        $roles = Role::latest()->get();

        return view('backend.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {

        $create = $this->userService->create($request);

        if ($create->getData()->success) {

            if ($create->getData()->data->roles[0]->name == 'customer') {
                return redirect()->route('admin.users.index', ['type' => 'customers'])->with('success', $create->getData()->message);
            }

            return redirect()->route('admin.users.index')->with('success', $create->getData()->message);
        }

        return back()->with('error', $create->getData()->message);
    }

    public function show(User $user): View
    {
        $roles = Role::latest()->get();
        $user->load('addresses');

        return view('backend.users.show', compact('user', 'roles'));
    }

    public function edit(User $user): View
    {

        $roles = Role::latest()->get();

        return view('backend.users.edit', compact('user', 'roles'));
    }

    public function update(User $user, UpdateUserRequest $request): RedirectResponse
    {

        $update = $this->userService->update($request, $user);

        if ($update->getData()->success) {

            if ($update->getData()->data->roles[0]->name == 'customer') {
                return redirect()->route('admin.users.index', ['type' => 'customers'])->with('success', $update->getData()->message);
            }

            return redirect()->route('admin.users.index')->with('success', updateMessage('User'));
        }

        return back()->with('error', $update->getData()->message);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return success('User deleted');
    }

    public function getList(Request $request): JsonResponse
    {

        $users = $this->userService->getList($request);

        if ($users->getData()->success) {
            return response()->json($users->getData()->data);
        }

        return response()->json([]);
    }

    public function statusUpdate(User $user): JsonResponse
    {
        $user->status = $user->status === User::STATUS['active'] ? User::STATUS['blocked'] : User::STATUS['active'];
        $user->save();

        return success('User status updated successfully', $user);
    }
}
