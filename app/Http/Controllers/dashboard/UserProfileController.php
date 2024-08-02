<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    protected $users;

    public function __construct()
    {
        $this->users = new User();
    }


    public function edit(Request $request)
    {
        // $page_id = $request->page_id;
        // $response['users'] = User::find($page_id);

        // // return response()->view('admin.pages.edit_page');
        // return view('pages.dashboard.profile')->with($response);
        // echo $student;
        $users = Auth::user();
        return view('pages.dashboard.profile', compact('users'));
    }

    public function update(Request $request, $page_id)
    {
        $UserDatas = User::find($request->user_id);
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
         ]);
         //var_dump(count($UserDatas));
        if($UserDatas) {
            if ($validator->fails()) {
                Session::forget('message');

                return redirect()->Back()->withInput()->withErrors($validator);
            } else {


                if(!empty($request->newpassword) && !empty($request->newconfirmpassword)){

                    $validator = Validator::make($request->all(), [
                        'username' => 'required',
                        'email' => 'required|email',
                        'newpassword' => 'required|min:8',
                        'privilege' => 'required',
                        'extensions' => 'required',
                        'newconfirmpassword' => 'required|same:newpassword',
                     ]);

                    Session::forget('message');

                    if ($validator->fails()) {
                        Session::forget('message');

                        return redirect()->Back()->withInput()->withErrors($validator);
                    } else {


                        $userData = [
                            'username' => $request->username,
                            'email' => $request->email,
                            'privilege' => $request->privilege,
                            'extensions' => $request->extensions,
                            'status' => $request->status,
                            'password' => Hash::make($request->newpassword),
                        ];

                        Session::put('message', 'User updated Successfully.');
                        $UserDatas->update($userData);
                        return redirect()->back();
                    }

                }else{
                    $userData = [
                        'username' => $request->username,
                        'email' => $request->email,
                        'privilege' => $request->privilege,
                        'extensions' => $request->extensions,
                        'status' => $request->status,
                    ];
                }
            }
        }else{
            Session::put('message', 'Sometyhing Wrong');
        }
        Session::put('message', 'User Updated Successfully.');
        $UserDatas->update($userData);
        // $this->blogs->create($request->all());
        return redirect()->back();
        // $user = Auth::user();

        // $request->validate([
        //     'username' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        //     'password' => 'nullable|string|min:8|confirmed',
        // ]);

        // $user->username = $request->username;
        // $user->email = $request->email;

        // if ($request->password) {
        //     $user->password = bcrypt($request->password);
        // }

        // $user->save();

        // return redirect()->route('profile.edit',$user->id)->with('success', 'Profile updated successfully');
    }
}
