<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function admin_login()
    {
        return view('auth.admin-login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        return $this->handleAuthentication($request, 'web');
    }

    public function admin_authenticate(Request $request): RedirectResponse
    {
        return $this->handleAuthentication($request, 'admin');
    }

    protected function handleAuthentication(Request $request, $guard)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
                'pin' => $guard === 'admin' ? ['required'] : [],
            ]);
            if (Auth::guard($guard)->attempt($credentials)) {
                $request->session()->regenerate();

                $user = Auth::guard($guard)->user();

                if (!$user->active) {
                    Auth::guard($guard)->logout();
                    return redirect()->route('account-status')->with([
                        'info' => true,
                        'error' => $user->name . ' is inactive',
                    ]);
                }

                return redirect()->intended('userfront');
            }

            return back()->with([
                'error' => true,
                'message' => 'The provided credentials do not match our records.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $message = $e->validator->errors()->all();
            $response = [
                'error' => true,
                'message' => $message,
            ];
            return back()->with($response)->withInput();
        }
    }

    public function logout()
    {
        $route = 'home';
        if (Auth::guard('admin')->check())
        {
            $admin = Auth::guard('admin')->user();
            // $permission = $admin->role->permissions()->where('slug', 'has_backend')->first();
            // if ($permission && $permission->slug === 'has_backend')
            // {
            //     $route = 'admin.login';
            // }
            if ($admin->can('has_backend')) {
                $route = 'admin.login';
            }

            Auth::guard('admin')->logout();
        } 
        else if (Auth::guard('web')->check())
        {
            Auth::guard('web')->logout();
        }
        else
        {
            return redirect()->back()->with([
                'info' => true,
                'message' => 'You are not logged in to the system.',
            ]);
        }
        Session::flush();
        return redirect()->route($route)->with([
            'success' => true,
            'message' => 'Successfully logged out',
        ]);
    }

}