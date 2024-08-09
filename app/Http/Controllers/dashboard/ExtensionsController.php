<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ExtensionsController extends Controller
{
    protected $users;

    public function __construct()
    {
        $this->users = new User();
    }
    public function edit(Request $request)
    {
        $page_id = $request->page_id;
        $response['users'] = User::find($page_id);

        // return response()->view('admin.pages.edit_page');
        return view('pages.dashboard.extensions')->with($response);
        // echo $student;
    }
    public function update(Request $request)
    {
        $UserDatas = User::find($request->user_id);
        $validator = Validator::make($request->all(), [
            'extensions' => 'required',
         ]);
         //var_dump(count($UserDatas));
        if($UserDatas) {
            if ($validator->fails()) {
                Session::forget('message');

                return redirect()->Back()->withInput()->withErrors($validator);
            } else {


                $userData = [
                    'extensions' => $request->extensions,
                ];

                Session::put('message', 'Extension Updated Successfully.');
                $UserDatas->update($userData);
            }
        }else{
            Session::put('message', 'Sometyhing Wrong');
        }

        // $this->blogs->create($request->all());
        return redirect()->back();
        // echo $student;
    }
}
