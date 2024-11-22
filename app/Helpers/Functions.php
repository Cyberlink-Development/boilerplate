<?php
use App\Models\Admin;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

function name_format($roleName){
    // Eg: Super admin = super_admin
    $role = strtolower($roleName);
    $data = str_replace(' ','_',$role);
    return $data;
}

function name_deformat($roleName){
    // Eg: super_admin = Super Admin
    $role = str_replace('_', ' ', $roleName);
    // Capitalize the first letter of each word
    $data = ucwords($role);
    return $data;
}

function role_name_exists($roleName){
    $role = name_format($roleName);
    return Role::where('name', $role)->exists();
}

function role_is_super_admin($role){
    if($role->name == 'super_admin'){
        return true;
    }
    else{
        return false;
    }
}

function compare_roles_hierarchy_with_admins_by_id($id){
    $currentUserRoleHierarchy = Auth::guard('admin')->user()->roles->first()->hierarchy;
    $dataRoleHierarchy = Admin::where('id', $id)->first()->roles->first()->hierarchy;
    if($currentUserRoleHierarchy < $dataRoleHierarchy){
        return true;
    }
    else{
        return false;
    }
}
function compare_roles_hierarchy_with_admins($data){
    $currentUserRoleHierarchy = Auth::guard('admin')->user()->roles->first()->hierarchy;
    $dataRoleHierarchy = Admin::where('id', $data->id)->first()->roles->first()->hierarchy;
    if($currentUserRoleHierarchy < $dataRoleHierarchy){
        return true;
    }
    else{
        return false;
    }
}

function compare_roles_hierarchy_with_roles($data){
    $currentUserRoleHierarchy = Auth::guard('admin')->user()->roles->first()->hierarchy;
    $dataRoleHierarchy = Role::where('id', $data->id)->first()->hierarchy;
    if($currentUserRoleHierarchy < $dataRoleHierarchy){
        return true;
    }
    else{
        return false;
    }
}

function get_permissions_roles($data){
    $currentUserRoleHierarchy = Auth::guard('admin')->user()->roles->first()->hierarchy;
    $dataRoleHierarchy = Role::where('id', $data->id)->first()->hierarchy;
    if($currentUserRoleHierarchy <= $dataRoleHierarchy){
        return true;
    }
    else{
        return false;
    }
}

function permission_is_has_backend($permission){
    if($permission->name == 'has_backend'){
        return true;
    }
    else{
        return false;
    }
}

function permission_name_exists($permissionName){
    $permission = name_format($permissionName);
    return Permission::where('name', $permission)->exists();
}

function get_admin_all_roles($id){
    $admin = Admin::find($id);
    $roles = $admin->getRoleNames();
    return $roles;
}

function get_admin_role($id) {
    $admin = Admin::find($id);
    $role = $admin->roles->first();
    if (!$role) {
        return null; // or a default value, or throw an exception
    }
    return name_deformat($role->name);
}

function get_admin_all_permissoins_by_role_id($id){
    $role = Role::find($id);
    $permissions = $role->permissions;
    return $permissions;
}


function compare_roles_permission_with_permission($data){
    $hasPermission = Auth::guard('admin')->user()->roles->first()->hasPermissionTo($data->name);
    return $hasPermission;
}