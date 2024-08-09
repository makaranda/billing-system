<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    protected $users;

    public function __construct()
    {
        $this->users = new User();
    }

    public function index()
    {
        $users = User::all();
        // return response()->view('admin.pages.edit_page');
        return view('pages.dashboard.users', ['users' => $users]);
        // echo $student;
    }

    public function create(){
        return view('pages.dashboard.createuser');
    }


    public function delete($page_id)
    {
        $users = $this->users->find($page_id);
        $users->delete();
        Session::forget('message');
        Session::put('message', 'User Deleted Successfully.');
        return redirect()->back();
    }

    public function edit(Request $request)
    {
        $page_id = $request->page_id;
        $response['users'] = User::find($page_id);
        // return response()->view('admin.pages.edit_page');
        return view('pages.dashboard.userprofile')->with($response);
        // echo $student;
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

                //newpassword newconfirmpassword
                if(!empty($request->newpassword) && !empty($request->newconfirmpassword)){

                    $validator = Validator::make($request->all(), [
                        'username' => 'required',
                        'email' => 'required|email|unique:users,email',
                        'password' => 'required|min:8',
                        'privilege' => 'required',
                        'extensions' => 'required',
                        'confirmpassword' => 'required|same:password',
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


                Session::put('message', 'User Updated Successfully.');
                $UserDatas->update($userData);
            }
        }else{
            Session::put('message', 'Sometyhing Wrong');
        }

        // $this->blogs->create($request->all());
        return redirect()->back();
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'privilege' => 'required',
            'extensions' => 'required',
            'status' => 'required',
            'confirmpassword' => 'required|same:password',
         ]);
         //var_dump(count($UserDatas));

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
                    'password' => Hash::make($request->password),
                ];

                Session::put('message', 'User Created Successfully.');
                User::create($userData);
            }

        // $this->blogs->create($request->all());
        return redirect()->back();
    }
}
