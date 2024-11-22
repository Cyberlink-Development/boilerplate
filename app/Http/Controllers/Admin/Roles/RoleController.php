<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'auth:admin'),
            new Middleware(middleware: 'permission:roles_index', only: ['index']),
            new Middleware(middleware: 'permission:roles_show', only: ['show']),
            new Middleware(middleware: 'permission:roles_create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:roles_edit', only: ['edit', 'update']),
            new Middleware(middleware: 'permission:roles_delete', only: ['destroy']),


        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Role::get();
        return view('admin.manage-roles.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hierarchy = Role::get()->max('hierarchy') + 1;
        return view('admin.manage-roles.create',compact('hierarchy'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'role_name' => 'required',
                'guard_name' => 'required',
                'hierarchy' => 'required|unique:roles,hierarchy'
            ]);
    
            if (role_name_exists($request->role_name)) {
                return back()->with([
                    'error' => true,
                    'message' => 'Role already exists.',
                ]);
            }
    
            Role::create([
                'name' => name_format($request->role_name),
                'guard_name' => $request->guard_name,
                'hierarchy' => $request->hierarchy
            ]);
            return redirect()->route('roles.index')->with([
                'success' => true,
                'message' => 'Role created successfully.'
            ]);
        }
        catch(\Exception $e){
            return back()->with([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(compare_roles_hierarchy_with_admins_by_id($id)){
            $data = Role::findOrFail($id);
            $permissions = Permission::get();
            return view('admin.manage-roles.show',compact('data', 'permissions'));
        }
        else{
            return redirect()->route('roles.index')->with([
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
        if(compare_roles_hierarchy_with_admins_by_id($id)){
            $data = Role::findOrFail($id);
            if(role_is_super_admin($data) == true){
                return back()->with([
                    'info' => true,
                    'message' => "Role can't be edit."
                ]);
            }
        }
        else{
            return redirect()->route('roles.index')->with([
                'warning' => true,
                'message' => 'Further violations may result in a ban.'
            ]);
        }
        return view('admin.manage-roles.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{

            $role = Role::findOrFail($id);
            $request->validate([
                'role_name' => 'required',
                'guard_name' => 'required',
                'hierarchy' => "required|unique:roles,hierarchy,$role->id"
            ]);
    
            if (name_format($request->role_name) != $role->name && role_name_exists($request->role_name)) {
                return back()->with([
                    'error' => true, 
                    'message' => 'Role already exists.'
                ]);
            }
            $role->update([
                'name' => name_format($request->role_name),
                'guard_name' => $request->guard_name,
                'hierarchy' => $request->hierarchy
            ]);
            return redirect()->route('roles.index')->with([
                'success' => true,
                'message' => 'Role updated successfully.'
            ]);
        }
        catch(\Exception $e){
            return back()->with([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Role::findOrFail($id);
        if(role_is_super_admin($data) == true){
            return back()->with([
                'success' => true,
                'message' => "Roles can't be deleted",
            ]);
        }

        try{
            $data->permissions()->detach();
            $data->delete();
            return redirect()->back()->with([
                'success' => true,
                'message' => 'Role deleted successsfully.'
            ]);
        }
        catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => true,
                'message' => 'Failed to delete role: ' . $e->getMessage()
            ]);
        }
    }
}
