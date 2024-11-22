<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function userfront()
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            if ($user->can('has_backend')) {
                return redirect()->route('admin.dashboard')->with([
                    'success' => true,
                    'message' => 'Successfully logged in as admin.',
                ]);
            }
            else {
                return redirect()->route('home')->with([
                    'success' => true,
                    'message' => "Successfully logged in. User don't have access for backend",
                ]);
            }
        }

        if (Auth::guard('web')->check()) {
            return redirect()->route('home')->with([
                'success' => true,
                'message' => 'Successfully logged in.',
            ]);
        }

        return redirect()->route('home');
    }

    public function index()
    {
        return view('admin.dashboard.index');
    }
}