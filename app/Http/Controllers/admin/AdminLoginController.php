<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        //dd($admin);
        if (!empty($admin->role) && $admin->role > 0) {
            return redirect()->route('admin.dashboard');
        } else {
            return view('pages.login.index');
        }
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'user_password' => 'required',
        ]);

        if ($validator->passes()) {
            if (Auth::guard('admin')->attempt(['username' => $request->user_name, 'password' => $request->user_password], $request->get('remember'))) {
                $admin = Auth::guard('admin')->user();
                if ($admin->status == 2) {
                    return redirect()->route('admin.dashboard');
                } elseif ($admin->status == 1) {
                    return redirect()->route('admin.dashboard');
                } else {
                    Auth::guard('admin')->logout();
                     //echo $admin->status.'test 1';
                    return redirect()->route('login.index')->with('error', 'You are not Authorized to access user control area');
                }
            } else {
                //echo 'test 2';
                return redirect()->route('login.index')->with('error', 'Username or Password is incorrect');
            }
        } else {
            //echo 'test 3';
            return redirect()->route('login.index')->withErrors($validator)->withInput(request()->only('user_name'));
        }
    }
}
