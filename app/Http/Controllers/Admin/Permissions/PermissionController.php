<?php

namespace App\Http\Controllers\Admin\Permissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware():array
    {
        return [
            new Middleware(middleware: 'auth:admin'),
            new Middleware(middleware: 'permission:permissions_index', only: ['index']),
            new Middleware(middleware: 'permission:permissions_create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:permissions_edit', only: ['edit', 'update']),
            new Middleware(middleware: 'permission:permissions_delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Permission::get();
        return view('admin.manage-permissions.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.manage-permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'permission_name' => 'required',
            'guard_name' => 'required'
        ]);

        if (permission_name_exists($request->permission_name)) {
            return back()->with([
                'error' => true,
                'message' => 'Permission already exists.',
            ]);
        }

        $permission = Permission::create([
            'name' => name_format($request->permission_name),
            'guard_name' => $request->guard_name
        ]);

        $super_admin_role = Role::where('name', 'super_admin')->first();
        if($super_admin_role){
            $super_admin_role->givePermissionTo($permission);
        }

        return redirect()->route('permissions.index')->with([
            'success' => true,
            'message' => 'Permission created successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Permission::findOrFail($id);
        if(compare_roles_permission_with_permission($data)){
            $roles = $data->roles;
            return view('admin.manage-permissions.show',compact('data', 'roles'));
        }
        else{
            return redirect()->route('permissions.index')->with([
                'warning' => true,
                'message' => 'Further violations may result in a ban.'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Permission::findOrFail($id);
        if(permission_is_has_backend($data) == true){
            return back()->with([
                'info' => true,
                'message' => "Permission can't be edit."
            ]);
        }
        return view('admin.manage-permissions.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'permission_name' => 'required',
            'guard_name' => 'required'
        ]);
        $permission = Permission::findOrFail($id);
        if (name_format($request->permission_name) != $permission->name && permission_name_exists($request->permission_name)) {
            return back()->with([
                'error' => true, 
                'message' => 'Permission already exists.'
            ]);
        }
        $permission->update([
            'name' => name_format($request->permission_name),
            'guard_name' => $request->guard_name
        ]);
        return redirect()->route('permissions.index')->with([
            'success' => true,
            'message' => 'Permission updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Permission::findOrFail($id);
        if(permission_is_has_backend($data) == true){
            return back()->with([
                'success' => true,
                'message' => "Permission can't be deleted",
            ]);
        }

        try{
            $data->roles()->detach();
            $data->delete();
            return redirect()->back()->with([
                'success' => true,
                'message' => 'Permission deleted successsfully.'
            ]);
        }
        catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => true,
                'message' => 'Failed to delete permission: ' . $e->getMessage()
            ]);
        }
    }
}
