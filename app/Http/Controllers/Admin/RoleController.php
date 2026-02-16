<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $roles = Role::withCount('permissions')->get();
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permissions = Permission::all()->groupBy('group_name');
        return view('admin.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $request->role,
            'guard_name' => 'admin',
        ]);

        $role->permissions()->sync($request->permissions);
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect(route('admin.roles.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        $permissions = Permission::all()->groupBy('group_name');
        return view('admin.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'role' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);
        $role->update([
            'name' => $request->role,
        ]);
        $role->permissions()->sync($request->permissions);
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect(route('admin.roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            DB::beginTransaction();
            //remove role from users
            $role->users()->detach();
            //remove permissions from role
            $role->permissions()->detach();
            //delete role
            $role->delete();
            DB::commit();
            return response()->json(['message' => 'Role deleted successfully']);
        }catch(\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error deleting role'], 500);
        }
    }
}
