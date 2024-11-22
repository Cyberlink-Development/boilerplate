<?php

namespace App\Http\Controllers\Admin\SiteSettings;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class SiteSettingController extends Controller implements HasMiddleware
{
    public static function middleware():array
    {
        return [
            new Middleware(middleware: 'auth:admin'),
        ];
    }
    public function index()
    { 
        $userId = Auth::user()->id; 
        $data = SiteSetting::where('u_id', $userId)->first();
        // $data = SiteSetting::where('id',1)->first();
        // dd($data, $userId);
        return view('admin.settings.index', compact('data'));
    }

    public function storeOrUpdate(Request $request)
    {
        $fields = [
            'site_name', 'location', 'phone', 'email_primary', 'email_secondary', 
            'facebook_link', 'linkedin_link', 'youtube_link', 'twitter_link', 'instagram_link', 
            'google_map', 'welcome_title', 'copyright_text'
        ];

        $data = SiteSetting::firstOrNew(['id' => $request->id]);

        if ($request->hasFile('logo')) {
            if ($data->logo && File::exists('template-assets/images/' . $data->logo)) {
                File::delete('template-assets/images/' . $data->logo);
            }
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('template-assets/images/', $filename);
            $data->logo = $filename;
        }
        $dataToUpdate = array_filter($request->only($fields), function($value) {
            return !is_null($value) && $value !== '';
        });

        $uid=Auth::user()->id;
        // dd($uid);
        $data->u_id = $uid;
        $data->fill($dataToUpdate);
        $data->save();

        $message = $request->id ? 'Site info updated successfully.' : 'Site info created successfully.';

        return redirect()->back()->with([
            'success' => true,
            'message' => $message
        ]);
    }


    public function delete_logo($id){
        $data = SiteSetting::findOrFail($id);
        
        if($data->logo && File::exists('template-assets/images/'.$data->logo)){
            File::delete('template-assets/images/'.$data->logo);
            $data->update(['logo' => null]);
        }
        // dd($data->image,File::exists('template-assets/images/'.$data->image));
        return response()->json([
            'success' => true,
            'message' => 'Logo removed successfully'
        ]);
    }
}
