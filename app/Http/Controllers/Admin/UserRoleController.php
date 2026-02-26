<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\AlertService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $admins = Admin::all();
        return view('admin.user-role.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.user-role.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role' => ['required', 'exists:roles,id']
        ]);

        $role = Role::findOrFail($request->role);

        if ($role->name == 'Super Admin') {
            AlertService::error('You can not create Super Admin user.');
            return to_route('admin.user-role.index');
        }

        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->save();

        // assign role
        $admin->assignRole($role);

        AlertService::created();

        return to_route('admin.user-role.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $user_role)
    {
        $admin = $user_role;
        $roles = Role::all();
        return view('admin.user-role.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $user_role)
    {
        if ($user_role->hasRole('Super Admin')) {
            AlertService::error('You can not update Super Admin user.');
            return to_route('admin.user-role.index');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email,' . $user_role->id],
            'role' => ['required', 'exists:roles,id'],
            'password' => ['nullable', 'confirmed', 'min:8']
        ]);

        $role = Role::findOrFail($request->role);

        if ($role->name == 'Super Admin') {
            AlertService::error('You can not create Super Admin user.');
            return to_route('admin.user-role.index');
        }

        $admin = $user_role;
        $admin->name = $request->name;
        $admin->email = $request->email;
        if ($request->filled('password')) {
            $admin->password = bcrypt($request->password);
        }
        $admin->save();

        // 5. Replace the old role with the new one
        $admin->syncRoles($role);

        AlertService::updated();

        return to_route('admin.user-role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $user_role): JsonResponse
    {
        if ($user_role->hasRole('Super Admin')) {
            return response()->json(['status' => 'error', 'message' => 'You can not update Super Admin user.']);
        }

        try {
            // remove roles from user
            foreach ($user_role->getRoleNames() as $role) {
                $user_role->removeRole($role);
            }

            $user_role->delete();

            AlertService::deleted();

            return response()->json(['status' => 'success', 'message' => 'Deleted Successfully']);
        } catch (\Throwable $th) {
            Log::error('Role Delete Error: ', $th);
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
