<?php

namespace App\Http\Controllers\Admin\RolesAndPermissions;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'auth:admin'),
            new Middleware(middleware: 'permission:roles_and_permissions', only: ['index']),
        ];
    }
    public function index(){
        $roles = Role::get();
        $permissions = Permission::get();
        return view('admin.rolesandpermissions.index',compact('roles','permissions'));
    }

    public function permission_update($id){
        list($roleId, $permissionId) = explode('-', $id);
        $role = Role::find($roleId);
        $permission = Permission::find($permissionId);
        if ($role && $permission) {
            // Assign the permission to the role using Spatie's method
            if($role->hasPermissionTo($permission)){
                $role->revokePermissionTo($permission);
                $this->clearPermissionCache();
                return response()->json([
                    'success' => true,
                    'message' => 'Permisson removed successfully.'
                ]);
            }
            else{
                $role->givePermissionTo($permission);
                $this->clearPermissionCache();
                return response()->json([
                    'success' => true,
                    'message' => 'Permission assigned successfully.'
                ]);
            }
        } else {
            // Handle the case where either role or permission is not found
            return response()->json([
                'error' => true,
                'message' => 'Role or Permission not found.'
            ]);
        }
    }

    private function clearPermissionCache()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
