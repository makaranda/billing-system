<?php

namespace App\Http\Controllers\dashboard\settings;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemMenus;
use App\Models\RoutesPermissions;
use App\Models\SystemUsers;
use App\Models\UserPrivileges;
use App\Models\Employees;
use App\Models\CollectionBureaus;
use App\Models\PermissionsTypes;
use App\Models\Branches;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\MD5;

class SettingUsersController extends Controller
{
    public function index($route = null){
        $route = $route ?? 'index.settings';
        $route = $route ?? 'home';
        $data = session('data');

        $mainMenus = SystemMenus::whereNull('parent_id')
                                ->orderBy('order')
                                ->get();
        $subsMenus = SystemMenus::where('route',$route)
                                ->orderBy('order')
                                ->get();
        foreach ($subsMenus as $submenu) {
            $submenu->subMenus = $submenu->orderBy('order')->get();
        }
        foreach ($mainMenus as $menu) {
            $menu->subMenus = $menu->children()->orderBy('order')->get();
        }

        $getRoutename = request()->route()->getName();
        $routesPermissions = RoutesPermissions::where('route',$getRoutename)->orderBy('id')->get();
        foreach ($routesPermissions as $routesPermission) {
            $routesPermission = $routesPermission->orderBy('id')->get();
        }

        $remindersRoute = request()->route()->getName();
        $parentid = 9;
        $mainRouteName = 'index.settings';
        //dd($mainMenus);
        //echo 'test';
        return view('pages.dashboard.settings.users', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions'));
    }

    public function userActive(Request $request, $user_id){
        $systemUsers = SystemUsers::find($request->user_id);

        $updateStatus = ($request->user_status == 1) ? 0 : 1;

        $userData = [
            'status' => $updateStatus,
        ];
        $systemUsers->update($userData);

        echo 'success';
    }

    public function indexPrivilege(Request $request){
        $route = $route ?? 'index.settings';
        $route = $route ?? 'home';
        $data = session('data');

        $mainMenus = SystemMenus::whereNull('parent_id')
                                ->orderBy('order')
                                ->get();
        $subsMenus = SystemMenus::where('route',$route)
                                ->orderBy('order')
                                ->get();

        $permissionsTypes = PermissionsTypes::all();
        $currentUser = SystemUsers::find(Auth::user()->id);
        $systemUsers = SystemUsers::all();
        $routesPermissions = RoutesPermissions::all();

        foreach ($subsMenus as $submenu) {
            $submenu->subMenus = $submenu->orderBy('order')->get();
        }
        foreach ($mainMenus as $menu) {
            $menu->subMenus = $menu->children()->orderBy('order')->get();
        }

        $getRoutename = request()->route()->getName();
        $routesPermissions = RoutesPermissions::where('route',$getRoutename)->orderBy('id')->get();
        foreach ($routesPermissions as $routesPermission) {
            $routesPermission = $routesPermission->orderBy('id')->get();
        }

        $remindersRoute = request()->route()->getName();
        $parentid = 9;
        $mainRouteName = 'index.settings';
        //dd($mainMenus);
        //echo 'test';
        return view('pages.dashboard.settings.privilege', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','permissionsTypes','currentUser','systemUsers','routesPermissions'));
    }

    public function userPrivilege(Request $request, $user_id){
        $route = $route ?? 'index.settings';
        $route = $route ?? 'home';
        $data = session('data');

        $mainMenus = SystemMenus::whereNull('parent_id')
                                ->orderBy('order')
                                ->get();
        $subsMenus = SystemMenus::where('route',$route)
                                ->orderBy('order')
                                ->get();

        $permissionsTypes = PermissionsTypes::all();
        $currentUser = SystemUsers::find(Auth::user()->id);
        $systemUsers = SystemUsers::all();
        $routesPermissions = RoutesPermissions::all();

        foreach ($subsMenus as $submenu) {
            $submenu->subMenus = $submenu->orderBy('order')->get();
        }
        foreach ($mainMenus as $menu) {
            $menu->subMenus = $menu->children()->orderBy('order')->get();
        }

        $getRoutename = request()->route()->getName();
        $routesPermissions = RoutesPermissions::where('route',$getRoutename)->orderBy('id')->get();
        foreach ($routesPermissions as $routesPermission) {
            $routesPermission = $routesPermission->orderBy('id')->get();
        }

        $remindersRoute = request()->route()->getName();
        $parentid = 9;
        $mainRouteName = 'index.settings';
        //dd($mainMenus);
        //echo 'test';
        return view('pages.dashboard.settings.privilege', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','permissionsTypes','currentUser','systemUsers','routesPermissions'));
    }

    public function userEdit(Request $request, $user_id){
        $systemUsers = SystemUsers::find($request->user_id);
        $userPrivileges = UserPrivileges::all();
        $employees = Employees::all();
        $collectionBureaus = CollectionBureaus::all();
        $branches = Branches::all();
        $usersGroups = SystemUsers::select('group_id')
                    ->distinct()
                    ->orderBy('id')
                    ->get();

        $userProfile = '';
        if (!$systemUsers) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $responseData = [
            'systemUsers' => $systemUsers,
            'userPrivileges' => $userPrivileges,
            'collectionBureaus' => $collectionBureaus,
            'userEmployees' => $employees,
            'branches' => $branches,
            'usersGroups' => $usersGroups
        ];

        return response()->json($responseData);
    }

    public function userOpenForm(Request $request){
        $userPrivileges = UserPrivileges::all();
        $employees = Employees::all();
        $collectionBureaus = CollectionBureaus::all();
        $branches = Branches::all();
        $groups = SystemUsers::select('group_id')
                    ->distinct()
                    ->orderBy('id')
                    ->get();

        $responseData = [
            'userPrivileges' => $userPrivileges,
            'collectionBureaus' => $collectionBureaus,
            'userEmployees' => $employees,
            'branches' => $branches,
            'groups' => $groups
        ];
        //echo 'test';
        return response()->json($responseData);
    }

    public function userSave(Request $request){
        $message = '';

        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'privilege' => 'required',
            'login' => 'required|unique:system_users,username',
            'password' => 'required',
            'repassword' => 'required|same:password',
            'group_id' => 'required',
            'branch_id' => 'required',
            'employee_id' => 'required',
            'collection_bureau' => 'required',
            'email' => 'required|email|unique:system_users,email'
        ]);

        if ($validator->fails()) {
            $messageType = 'wrong';
            $message = $validator->errors()->all()[0];
        } else {
            $userData = [
                'branch_id' => $request->branch_id,
                'username' => $request->login,
                'password' => md5($request->password), // Hashing password with MD5
                'privilege' => $request->privilege,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'receipt_printer_id' => 1,
                'employee_id' => $request->employee_id,
                'group_id' => $request->group_id,
                'is_debt_collect' => 0,
                'collection_bureau_id' => $request->collection_bureau, // Fix field name to match database
                'last_login_time' => now(),
                'session_timeout' => $request->session_timeout,
                'tfa_phone' => 0,
                'tfa_email' => 0,
                'status' => 1,
                'created_by' => Auth::user()->id,
            ];

            SystemUsers::create($userData);
            $messageType = 'success';
            $message = 'You have successfully Added the user data to the database..';
        }

        $responseData = [
            'messageType' => $messageType,
            'message' => $message
        ];

        return response()->json($responseData);
        //echo 'test';
    }

    public function userUpdate(Request $request, $user_id){
        $UserDatas = SystemUsers::find($request->form_user_id);
        $oldpassword = $UserDatas['password'];
        $message = '';
        $messageType = '';

        if(!empty($request->password) && !empty($request->repassword)){
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'privilege' => 'required',
                'login' => 'required',
                'password' => 'required',
                'repassword' => 'required|same:password',
                'group_id' => 'required',
                'branch_id' => 'required',
                'employee_id' => 'required',
                'collection_bureau' => 'required',
                'email' => 'required'
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'privilege' => 'required',
                'login' => 'required',
                'group_id' => 'required',
                'branch_id' => 'required',
                'employee_id' => 'required',
                'collection_bureau' => 'required',
                'email' => 'required'
            ]);
        }


        if ($validator->fails()) {
            $messageType = 'wrong';
            $message = $validator->errors()->all()[0];
        } else {
            if(!empty($request->password) && !empty($request->repassword)){
                $userData = [
                    'branch_id' => $request->branch_id,
                    'username' => $request->login,
                    'password' => md5($request->password), // Hashing password with MD5
                    'privilege' => $request->privilege,
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'receipt_printer_id' => 1,
                    'employee_id' => $request->employee_id,
                    'group_id' => $request->group_id,
                    'is_debt_collect' => 0,
                    'collection_bureau_id' => $request->collection_bureau, // Fix field name to match database
                    'last_login_time' => now(),
                    'session_timeout' => $request->session_timeout,
                    'tfa_phone' => 0,
                    'tfa_email' => 0,
                    'status' => 1,
                    'created_by' => Auth::user()->id,
                ];
            }else{
                $userData = [
                    'branch_id' => $request->branch_id,
                    'username' => $request->login,
                    'password' => $oldpassword,
                    'privilege' => $request->privilege,
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'receipt_printer_id' => 1,
                    'employee_id' => $request->employee_id,
                    'group_id' => $request->group_id,
                    'is_debt_collect' => 0,
                    'collection_bureau_id' => $request->collection_bureau,
                    'last_login_time' => now(),
                    'session_timeout' => $request->session_timeout,
                    'tfa_phone' => 0,
                    'tfa_email' => 0,
                    'status' => 1,
                    'created_by' => Auth::user()->id,
                ];
            }

            $UserDatas->update($userData);
            $messageType = 'success';
            $message = 'You have successfully updated the user data to the database..';
        }

        // $messageType = 'success';
        // $message = 'You have successfully updated the user data to the database..';

        $responseData = [
            'messageType' => $messageType,
            'message' => $message
        ];

        return response()->json($responseData);
    }


    public function fetchuserAll(Request $request) {
        //$systemUsers = SystemUsers::all();
        $query = SystemUsers::query();

        if ($request->has('name') && $request->name != '') {
            $query->where('full_name', 'LIKE', '%' . $request->name . '%');
        }
        if ($request->has('email') && $request->email != '') {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }
        if ($request->has('privilege') && $request->privilege != '') {
            $query->where('privilege', $request->privilege);
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // if ($request->has('order_by') && $request->order_by != '') {
        //     $query->orderBy('username', $request->order_by);
        // } else {
            $query->orderBy('username', 'asc'); // Default ordering
        //}

        $systemUsers = $query->get();

        $print_btn = '<a href="ajax/users/excel.php" target="_blank"><button style="margin:2px;" class="btn btn-success btn-xs pull-right">
                                <span class="glyphicon glyphicon-save-file"></span> Excel
                        </button> </a>
                        <a href="ajax/users/pdf.php" target="_blank"><button style="margin:2px;" class="btn btn-danger btn-xs pull-right">
                                <span class="glyphicon glyphicon-save-file"></span> Pdf
                        </button> </a>
                        <br/>';


        $responses = '';

        if ($systemUsers->count() > 0) {
            $responses .= '<div class="p-3">
                                <a href="ajax/users/excel.php" target="_blank"><button style="margin:2px;" class="btn btn-success btn-xs pull-right">
                                        <i class="bi bi-file-earmark-excel"></i> Excel
                                </button> </a>
                                <a href="ajax/users/pdf.php" target="_blank"><button style="margin:2px;" class="btn btn-danger btn-xs pull-right">
                                        <i class="bi bi-file-earmark-pdf"></i> Pdf
                                </button> </a>
                            </div>
                                <br/>
                            <small class="p-2"><table class="table table-stripped table-hover" width="100%"><thead>
			                <tr>
                                <td align="left"><strong><input type="checkbox" id="check_all" /></strong></td>
                                <td align="left"><strong>Login Name</strong></td>
                                <td align="left"><strong>Group</strong></td>
                                <td align="left"><strong>Privilege</strong></td>
                                <td align="left"><strong>Name</strong></td>
                                <td align="left"><strong>Email</strong></td>
                                <td align="left"><strong>Phone</strong></td>
                                <td align="left"><strong>Status</strong></td>
                                <td class="text-center"><strong>Action</strong></td>
                            </tr>
                            </thead>
		                    <tbody>';
            $i=1;
            foreach ($systemUsers as $systemUser) {
                //$userPrivileges = UserPrivileges::find($systemUser->privilege);
                $btnActivate = ($systemUser->status == 1)? 'Active':'Inactive';

                if($systemUser->status == 1){
                    $activeInactivebtn = '<a><button type="button" class="btn btn-xs btn-danger userActivete" data-id="'.$systemUser->id.'" data-status="'.$systemUser->status.'" title="Disable">
                                            <i class="bi bi-x"></i>
                                        </button><a>';
                }else{
                    $activeInactivebtn = '<a><button type="button" class="btn btn-xs btn-success userActivete" data-id="'.$systemUser->id.'" data-status="'.$systemUser->status.'" title="Enable">
                                        <i class="bi bi-arrow-repeat"></i>
                                        </button></a>';
                }

                $responses .= '<tr>
                                    <td style="vertical-align: middle;"><input type="checkbox" name="chk[]" id="chk_'.$i++.'" class="chk_user" value="'.$systemUser->id.'" /></td>
                                    <td style="vertical-align: middle;">'.$systemUser->username.'</td>
                                    <td style="vertical-align: middle;">'.$systemUser->group_id.'</td>
                                    <td style="vertical-align: middle;"></td>
                                    <td style="vertical-align: middle;">'.$systemUser->full_name.'</td>
                                    <td style="vertical-align: middle;">'.$systemUser->email.'</td>
                                    <td style="vertical-align: middle;">'.$systemUser->phone.'</td>
                                    <td style="vertical-align: middle;">'.$btnActivate.'</td>

                                    <td style="vertical-align: middle;">
                                        <a href="'.route("users.privilege","$systemUser->id").'" title="Privileges">
                                            <button type="button" class="btn btn-xs btn-warning"><i class="fa fa-lock"></i></button>
                                        </a>

                                        <a>
                                            <button type="button" class="btn btn-xs btn-info userEditBtn" data-id="'.$systemUser->id.'" data-bs-toggle="modal" data-bs-target="#addUserModal" role="button" title="Edit">
                                                <i class="bi bi-pen"></i>
                                            </button>
                                        </a>
                                        '.$activeInactivebtn.'
                                    </td>
                                </tr>';
            }

            $responses .= '<tbody></table>';

            echo $responses;
        }else{
            echo '<h4>No users found in the system !</h4>';
        }
    }
}
