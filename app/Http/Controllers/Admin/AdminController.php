<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AdminController extends Controller implements HasMiddleware
{
    public static function middleware():array
    {
        return [
            new Middleware(middleware: 'auth:admin'),
            new Middleware(middleware: 'permission:admins_index', only: ['index']),
            new Middleware(middleware: 'permission:admins_create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:admins_edit', only: ['edit', 'update']),
            new Middleware(middleware: 'permission:admins_delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id(); 
        $data = Admin::where('u_id', $userId)->get();
        // $data = Admin::get();
        return view('admin.manage-admins.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $roleData = Role::get();
        $roleData = Role::where('name', '!=', 'super_admin')->get();
        return view('admin.manage-admins.create',compact('roleData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'admin_name' => 'required',
                'admin_email' => 'required|email|unique:admins,email',
                'pin'   => 'required|numeric',
                'phone' => 'required',
                'password' => 'required|min:6',
                'image' => 'nullable|mimes:jpeg,jpg,png|max:2048',
                'role' => 'required|exists:roles,id'
            ]);
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalName();
                $file->move('admin/images/profile', $filename);
            }
            else{
                $filename = null;
            }
            $uid= Auth::id();
            // dd($uid, $request);
            $now = Carbon::now();
            $data = Admin::create([
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'pin'   => $request->pin,
                'phone' => $request->phone,
                'image' => $filename,
                'email_verified_at' => $now,
                'u_id'  => $uid,
                'password' => Hash::make($request->password),
            ]);
            $role = Role::findOrFail($request->role);
            $data->assignRole($role);
            return redirect()->route('manage-admins.index')->with([
                'success' => true,
                'message' => 'Admin created successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error creating admin: ' . $e->getMessage());
            return redirect()->back()->withInput()->with([
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
            $data = Admin::findOrFail($id);
            $role = $data->roles->first();
            $permissions = get_admin_all_permissoins_by_role_id($role->id);
            // dd('test');
            return view('admin.manage-admins.show',compact('data', 'role', 'permissions'));
        }
        else{
            return redirect()->route('manage-admins.index')->with([
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
            $data = Admin::findOrFail($id);
            $roleData = Role::where('name', '!=', 'super_admin')->get();
            return view('admin.manage-admins.edit',compact('data','roleData'));
        }
        else{
            return redirect()->route('manage-admins.index')->with([
                'warning' => true,
                'message' => 'Further violations may result in a ban.'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Admin::findOrFail($id);
        try {
            $request->validate([
                'admin_name' => 'required',
                'admin_email' => 'required|email|unique:admins,email,' . $data->id,
                'pin'   => 'required|numeric',
                'phone' => 'required',
                'password' => 'nullable|min:6',
                'image' => 'nullable|mimes:jpeg,jpg,png|max:2048',
                'role' => 'required|exists:roles,id'
            ]);
            if($request->hasFile('image')) {
                $previousFileName = $data->image;
                if($previousFileName && File::exists('admin/images/profile/' . $previousFileName)){
                    File::delete('admin/images/profile/' . $previousFileName);
                }
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalName();
                $file->move('admin/images/profile/', $filename);
            }
            else{
                $filename = $data->image;
            }

            $updateData = [
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'pin'   => $request->pin,
                'phone' => $request->phone,
                'image' => $filename,
                'email_verified_at' => Carbon::now(),
            ];
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }
            $data->update($updateData);

            $data->roles()->detach();
            $role = Role::findOrFail($request->role);
            $data->assignRole($role);
            return redirect()->route('manage-admins.index')->with([
                'success' => true,
                'message' => 'Admin updated successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating admin: ' . $e->getMessage());
            return redirect()->back()->withInput()->with([
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
        try{
            $data = Admin::findOrFail($id);
            if($data->image && File::exists('admin/images/profile' . $data->image)){
                File::delete('admin/images/profile' . $data->image);
            }
            $data->roles()->detach();
            $data->delete();
            return redirect()->route('manage-admins.index')->with([
                'success' => true,
                'message' => 'Admin deleted successfully'
            ]);
        } catch (\Exception $e){
            Log::error('Error deleting admin: ' . $e->getMessage());

            return redirect()->route('manage-admins.index')->with([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete_image($id){
        $data = Admin::findOrFail($id);
        
        if($data->image && File::exists('admin/images/profile/'.$data->image)){
            File::delete('admin/images/profile/'.$data->image);
            $data->update(['image' => null]); 
        }
        // dd($data->image,File::exists('admin/images/'.$data->image));
        return response()->json([
            'success' => true,
            'message' => 'Image removed successfully'
        ]);
    }
}
