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
use Illuminate\Support\Facades\Log;
use App\Exports\SystemUsersExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
//use Illuminate\Support\Facades\MD5;

class SettingUsersController extends Controller
{
    public function index($route = null){
        $route = $route ?? 'index.settings';
        $route = $route ?? 'home';
        $data = session('data');

        $userPrivileges = UserPrivileges::all();
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
        $getAllRoutePermisssions = RoutesPermissions::all();
        foreach ($routesPermissions as $routesPermission) {
            $routesPermission = $routesPermission->orderBy('id')->get();
        }

        //$getAllRoutePermisssionsUser = RoutesPermissions::where('user_id', Auth::user()->id)->get();
        $permissionsTypes = PermissionsTypes::all();
        $systemUsers = SystemUsers::all();

        $routepermissions = [];
        foreach ($permissionsTypes as $permissionsType) {
            $routepermissions[$permissionsType->name] = 0;
        }
        $getAllRoutePermisssionsUser = RoutesPermissions::where('user_id', Auth::user()->id)
                                                        ->where('route', $getRoutename)
                                                        ->get();

        $currentRoute = request()->route()->getName();
        $parentRoute = 'index.' . explode('.', $currentRoute)[0];
        foreach ($permissionsTypes as $permissionsType) {
            $type = $permissionsType->permission_type;

            // Check if the user has this permission for the current route or parent route
            $hasPermission = $getAllRoutePermisssionsUser->contains(function ($permission) use ($type, $currentRoute, $parentRoute) {
                return $permission->permission_type == $type && ($permission->route == $currentRoute || $permission->route == $parentRoute);
            });

            // Update the routepermissions array
            $routepermissions[$type] = $hasPermission ? 1 : 0;
        }

        $remindersRoute = request()->route()->getName();
        $parentid = 9;
        $mainRouteName = 'index.settings';
        //dd($mainMenus);
        //echo 'test';
        $countCheckThisRoutes = RoutesPermissions::where('route', $getRoutename)
        ->where('user_id', Auth::user()->id)
        ->where('main_route', $mainRouteName)
        ->count();
        if($countCheckThisRoutes == 0){
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access this route.');
        }else{
            return view('pages.dashboard.settings.users', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','userPrivileges','routepermissions'));
        }
    }

    public function generatePDF(Request $request)
{
        // Fetch the data from the SystemUsers model
        //$systemUsers = SystemUsers::all();
        $privilege = $request->input('privilege');
        $status = $request->input('status');

        // Build the query with optional filters
        $query = SystemUsers::query();

        if (!is_null($privilege)) {
            $query->where('privilege', $privilege);
        }

        if (!is_null($status)) {
            $query->where('status', $status);
        }

        $systemUsers = $query->get();
        // Load the view and pass the data
        $pdf = PDF::loadView('pages.dashboard.settings.pdf.system_users_pdf', compact('systemUsers'));

        // Optional: Set additional options like page size, orientation, etc.
        $pdf->setPaper('A4', 'landscape');

        // Return the generated PDF to the browser for download or viewing
        return $pdf->download('system_users_report.pdf');
    }

    public function generateExcel(Request $request){
        // Retrieve filters from the request
        $privilege = $request->input('privilege');
        $status = $request->input('status');

        //echo $privilege.'|'.$status;
        // Pass the filters to the export class
        return Excel::download(new SystemUsersExport($privilege, $status), 'system_users.xlsx');
        //return Excel::download(new SystemUsersExport, 'system_users.xlsx');
    }

    public function userActive(Request $request, $user_id){
        $message = '';
        $systemUsers = SystemUsers::find($request->user_id);
        $user_name = $systemUsers->username;
        $user_id = $systemUsers->id;

        if($request->user_id != Auth::user()->id){
            $updateStatus = ($request->user_status == 1) ? 0 : 1;

            $userData = [
                'status' => $updateStatus,
            ];
            $systemUsers->update($userData);
            $message = 'success';
        }else{
            $message = 'already';
        }
        $responseData = [
            'message' => $message,
            'user_id' => $user_id,
            'user_name' => $user_name,
        ];
        //echo 'test';
        return response()->json($responseData);
        //echo 'success';
    }

    public function userLogStatus(Request $request){
        $message = '';
        $systemUsers = SystemUsers::where('id', $request->user_id)
                          ->where('username', $request->user_name)
                          ->first();

        if($systemUsers->id){
            if($systemUsers->id == Auth::user()->id){
                $message = 'current';
                //Auth::guard('admin')->logout();
            }else{
                $message = 'other';
            }
        }else{
            $message = 'error';
        }

        $responseData = [
            'message' => $message,
        ];
        //echo 'test';
        return response()->json($responseData);
    }

    public function indexPrivilege(Request $request){
        return redirect()->route('index.users');
    }

    public function userPrivilege(Request $request, $user_id){
        $route = $route ?? 'index.settings';
        $route = $route ?? 'home';
        $data = session('data');

        $realUser = SystemUsers::find($user_id);
        $permissionsTypes = PermissionsTypes::all();
        $currentUser = SystemUsers::find(Auth::user()->id);
        $systemUsers = SystemUsers::all();
        $routesPermissions = RoutesPermissions::all();

        if (empty($realUser->id)) {
            return redirect()->route('index.users');
        }

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
        $routesPermissions = RoutesPermissions::where('user_id',$user_id)->orderBy('id')->get();
        $getAllRoutePermisssions = RoutesPermissions::all();
        foreach ($routesPermissions as $routesPermission) {
            $routesPermission = $routesPermission->orderBy('id')->get();
        }

        $remindersRoute = request()->route()->getName();
        $parentid = 9;
        $mainRouteName = 'index.settings';
        $permissionType = '';
        $bulkUsers = $user_id;

        $bulkUsersList = (count(explode(',',$bulkUsers)) > 1)?explode(',',$bulkUsers):$bulkUsers;
        $userPermissionLists = '';

        foreach ($routesPermissions as $routesPermission) {
            if (is_array($bulkUsersList) && count($bulkUsersList) > 1) {
                foreach ($bulkUsersList as $bulkUser) {
                    if ($routesPermission->user_id == $bulkUser) {
                        foreach ($mainMenus as $menu2) {
                            $perMainMenuId = ($menu2->route == $routesPermission->main_route) ? $menu2->id : null;
                            $perMainSubId = null;
                            foreach ($menu2->subMenus as $subMenu) {
                                if ($subMenu->route == $routesPermission->route) {
                                    $perMainSubId = $subMenu->id;
                                    break;
                                }
                            }
                            if ($perMainMenuId && $perMainSubId) {
                                $userPermissionLists .= $perMainMenuId . '/' . $perMainSubId . '/' . $routesPermission->permission_type . ',';
                            }
                        }
                    }
                }
            } else {
                if ($routesPermission->user_id == $bulkUsersList) {
                    foreach ($mainMenus as $menu2) {
                        $perMainMenuId = ($menu2->route == $routesPermission->main_route) ? $menu2->id : null;
                        $perMainSubId = null;
                        foreach ($menu2->subMenus as $subMenu) {
                            if ($subMenu->route == $routesPermission->route) {
                                $perMainSubId = $subMenu->id;
                                break;
                            }
                        }
                        if ($perMainMenuId && $perMainSubId) {
                            $userPermissionLists .= $perMainMenuId . '/' . $perMainSubId . '/' . $routesPermission->permission_type . ',';
                        }
                    }
                }
            }
        }

        $bulkUsersArray = explode(',', $bulkUsers);
        $routesPermissionsPrivilage = RoutesPermissions::whereIn('user_id', $bulkUsersArray)->get();

        // Group the permissions by route and permission type for quick lookup
        $routesPermissionsMap = $routesPermissionsPrivilage->groupBy(function ($item) {
            return $item->route . '_' . $item->permission_type;
        });

        $mainMenusPrivilage = SystemMenus::with(['children:id,parent_id,name,route'])
        ->whereNull('parent_id')
        ->select('id', 'name')
        ->get();

        $permissionsTypesPrivilage = PermissionsTypes::select('permission_type', 'route')->get();

        //dd($mainMenus);
        //echo 'test';
        //$userPermissionLists = $bulkUsers;
        return view('pages.dashboard.settings.privilege', compact('mainMenus','mainMenusPrivilage','routesPermissionsMap','permissionsTypesPrivilage','bulkUsersArray','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','permissionsTypes','currentUser','systemUsers','routesPermissions','bulkUsers','permissionType','userPermissionLists','getAllRoutePermisssions'));

    }

    public function userBulkPrivilege(Request $request){
        // Check if 'bulk_users' input is present in the request
        ///permissions_users_List
        if (!$request->isMethod('post') || !$request->has('bulk_users')) {
            return redirect()->route('index.users');
        }

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
        $getAllRoutePermisssions = RoutesPermissions::all();

        foreach ($subsMenus as $submenu) {
            $submenu->subMenus = $submenu->orderBy('order')->get();
        }
        foreach ($mainMenus as $menu) {
            $menu->subMenus = $menu->children()->orderBy('order')->get();
        }

        $getRoutename = request()->route()->getName();
        //$routesPermissions = RoutesPermissions::where('user_id',Auth::user()->id)->orderBy('id')->get();
        $routesPermissions = RoutesPermissions::all();
        foreach ($routesPermissions as $routesPermission) {
            $routesPermission = $routesPermission->orderBy('id')->get();
        }

        $remindersRoute = request()->route()->getName();
        $parentid = 9;
        $mainRouteName = 'index.settings';
        $bulkUsers = $request->bulk_users;
        $permissionType = $request->permission_type;

        $bulkUsersList = (count(explode(',',$bulkUsers)) > 1)?explode(',',$bulkUsers):$bulkUsers;
        $userPermissionLists = '';
        //$permissionsLists .= $mainMenu->id.'/'.$subMenu->id.'/'.$permissionsType->permission_type;
        foreach ($routesPermissions as $routesPermission) {
            if (is_array($bulkUsersList) && count($bulkUsersList) > 1) {
                foreach ($bulkUsersList as $bulkUser) {
                    if ($routesPermission->user_id == $bulkUser) {
                        foreach ($mainMenus as $menu2) {
                            $perMainMenuId = ($menu2->route == $routesPermission->main_route) ? $menu2->id : null;
                            $perMainSubId = null;
                            foreach ($menu2->subMenus as $subMenu) {
                                if ($subMenu->route == $routesPermission->route) {
                                    $perMainSubId = $subMenu->id;
                                    break;
                                }
                            }
                            if ($perMainMenuId && $perMainSubId) {
                                $userPermissionLists .= $perMainMenuId . '/' . $perMainSubId . '/' . $routesPermission->permission_type . ',';
                            }
                        }
                    }
                }
            } else {
                if ($routesPermission->user_id == $bulkUsersList) {
                    foreach ($mainMenus as $menu2) {
                        $perMainMenuId = ($menu2->route == $routesPermission->main_route) ? $menu2->id : null;
                        $perMainSubId = null;
                        foreach ($menu2->subMenus as $subMenu) {
                            if ($subMenu->route == $routesPermission->route) {
                                $perMainSubId = $subMenu->id;
                                break;
                            }
                        }
                        if ($perMainMenuId && $perMainSubId) {
                            $userPermissionLists .= $perMainMenuId . '/' . $perMainSubId . '/' . $routesPermission->permission_type . ',';
                        }
                    }
                }
            }
        }


        $bulkUsersArray = explode(',', $bulkUsers);
        $routesPermissionsPrivilage = RoutesPermissions::whereIn('user_id', $bulkUsersArray)->get();

        // Group the permissions by route and permission type for quick lookup
        $routesPermissionsMap = $routesPermissionsPrivilage->groupBy(function ($item) {
            return $item->route . '_' . $item->permission_type;
        });

        $mainMenusPrivilage = SystemMenus::with(['children:id,parent_id,name,route'])
        ->whereNull('parent_id')
        ->select('id', 'name')
        ->get();

        $permissionsTypesPrivilage = PermissionsTypes::select('permission_type', 'route')->get();

        return view('pages.dashboard.settings.privilege', compact('mainMenus','mainMenusPrivilage','routesPermissionsMap','permissionsTypesPrivilage','bulkUsersArray','subsMenus', 'data', 'mainRouteName', 'remindersRoute', 'parentid', 'routesPermissions', 'permissionsTypes', 'currentUser', 'systemUsers', 'routesPermissions', 'bulkUsers','permissionType','userPermissionLists','getAllRoutePermisssions'));
    }

    public function userPrivilegeSave(Request $request){
        // permissionsUsersList
        // permissionType
        // permissions
        //print_r($request->permissions);
        // Example dataset string
        //$dataset = "9/78/read,9/78/create";
        $dataset = $request->permissions;
        $datasetUsers = $request->permissionsUsersList;
        $records = explode(',', $dataset);
        $recordsUsers = explode(',', $datasetUsers);

        $routesData = [];

        foreach ($recordsUsers as $recordsUser) {
            RoutesPermissions::where('user_id', $recordsUser)->delete();
        }

        foreach ($records as $record) {
            //list($main_menu_id, $sub_menu_id, $permission_type) = explode('/', $record);
            $main_menu_id = explode('/', $record)[0];
            $sub_menu_id = explode('/', $record)[1];
            $permission_type = explode('/', $record)[2];

            $mainMenu = SystemMenus::find($main_menu_id);
            $subMenu = SystemMenus::find($sub_menu_id);

            foreach($recordsUsers as $recordsUser){
                $systemUsers = SystemUsers::find($recordsUser);

                if ($mainMenu && $subMenu) {
                    $routesData[] = [
                        'user_id' => $systemUsers->id,
                        'main_route' => $mainMenu->route,
                        'route' => $subMenu->route,
                        'userType' => $systemUsers->privilege,
                        'permission_type' => $permission_type
                    ];
                }

            }


        }
        $message = 'success';
        RoutesPermissions::insert($routesData);
        //return redirect()->back();

        // Perform bulk insert
        //try {
            //RoutesPermissions::insert($routesData);
        //} catch (\Exception $e) {
            //Log::error('Error inserting routes permissions', ['error' => $e->getMessage()]);
            //return response()->json(['message' => 'Error saving routes'], 500);
        //}

        // Return a response or redirect as needed
        //return response()->json(['message' => 'Routes saved successfully']);

        return response()->json(['message' => $message]);

    }

    public function userPrivilegeRemove(Request $request)
{
        // Input datasets
        $dataset = $request->permissions;
        $datasetUsers = $request->permissionsUsersList;
        $permissionsToRemove = $request->permissionsRemove;

        // Convert comma-separated strings to arrays
        $records = explode(',', $dataset);
        $recordsUsers = explode(',', $datasetUsers);
        $recordsRemove = explode(',', $permissionsToRemove);

        // Iterate over each user to remove specified permissions
        foreach ($recordsUsers as $userId) {
            foreach ($recordsRemove as $permission) {
                $parts = explode('/', $permission);
                $mainMenuId = $parts[0];
                $subMenuId = $parts[1];
                $permissionType = $parts[2];

                // Find the main menu and sub menu
                $mainMenu = SystemMenus::find($mainMenuId);
                $subMenu = SystemMenus::find($subMenuId);

                if ($mainMenu && $subMenu) {
                    // Delete the specific permission for the user
                    RoutesPermissions::where('user_id', $userId)
                        ->where('main_route', $mainMenu->route)
                        ->where('route', $subMenu->route)
                        ->where('permission_type', $permissionType)
                        ->delete();
                }
            }
        }

        // Reinsert the remaining permissions if necessary
        $routesData = [];
        foreach ($records as $record) {
            $parts = explode('/', $record);
            $mainMenuId = $parts[0];
            $subMenuId = $parts[1];
            $permissionType = $parts[2];

            $mainMenu = SystemMenus::find($mainMenuId);
            $subMenu = SystemMenus::find($subMenuId);

            if ($mainMenu && $subMenu) {
                foreach ($recordsUsers as $userId) {
                    $systemUser = SystemUsers::find($userId);
                    $routesData[] = [
                        'user_id' => $systemUser->id,
                        'main_route' => $mainMenu->route,
                        'route' => $subMenu->route,
                        'userType' => $systemUser->privilege,
                        'permission_type' => $permissionType
                    ];
                }
            }
        }

        if (!empty($routesData)) {
            RoutesPermissions::insert($routesData);
        }

        return response()->json(['message' => 'success']);
    }

    public function userPrivilegeDelete(Request $request){
        $dataset = $request->permissions;
        $datasetUsers = $request->permissionsUsersList;
        $records = explode(',', $dataset);
        $recordsUsers = explode(',', $datasetUsers);

        $routesData = [];

        foreach ($recordsUsers as $recordsUser) {
            RoutesPermissions::where('user_id', $recordsUser)->delete();
        }

        return response()->json(['message' => 'success']);

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
        ]);

        if ($validator->fails()) {
            $messageType = 'wrong';
            $message = $validator->errors()->all()[0];
        } else {
            $userData = [
                'branch_id' => ($request->branch_id)?$request->branch_id:'',
                'username' => $request->login,
                'password' => md5($request->password), // Hashing password with MD5
                'privilege' => $request->privilege,
                'full_name' => $request->full_name,
                'email' => ($request->email)?$request->email:'',
                'phone' => ($request->phone)?$request->phone:'',
                'receipt_printer_id' => 1,
                'employee_id' => ($request->employee_id)?$request->employee_id:'',
                'group_id' => ($request->group_id)?$request->group_id:'',
                'is_debt_collect' => ($request->collection_budebtCollectorValreau)?$request->debtCollectorVal:0,
                'collection_bureau_id' => ($request->collection_bureau)?$request->collection_bureau:'', // Fix field name to match database
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

        if(!empty($request->password) || !empty($request->repassword)){
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'privilege' => 'required',
                'password' => 'required',
                'repassword' => 'required|same:password',
                'login' => 'required',
                'group_id' => 'required',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'privilege' => 'required',
                'login' => 'required',
                'group_id' => 'required',
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
                    'is_debt_collect' => $request->debtCollectorVal,
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
                    'is_debt_collect' => $request->debtCollectorVal,
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
        $getAllRoutePermisssions = RoutesPermissions::all();

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

        $responses = '';

        if ($systemUsers->count() > 0) {
            $responses .= '

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
                $btnActivateType = ($systemUser->status == 1)? 'Active':'Inactive';

                $getAllRoutePermisssions = RoutesPermissions::where('user_id', Auth::user()->id)->get();

                $currentRoute = request()->route()->getName();
                $parentRoute = 'index.'.explode('.', $currentRoute)[0].'';

                $canDelete = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'delete' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });

                $canPrivilege = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'privilege' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });

                $canEdit = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'update' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });
                $activeInactivebtn = '';
                if ($canDelete) {
                    if($systemUser->status == 1){
                        $activeInactivebtn = '<a><button type="button" class="btn btn-xs btn-danger userActivete" data-id="'.$systemUser->id.'" data-status="'.$systemUser->status.'" title="Disable">
                                                <i class="bi bi-x"></i>
                                            </button><a>';
                    }else{
                        $activeInactivebtn = '<a><button type="button" class="btn btn-xs btn-success userActivete" data-id="'.$systemUser->id.'" data-status="'.$systemUser->status.'" title="Enable">
                                            <i class="bi bi-arrow-repeat"></i>
                                            </button></a>';
                    }
                }
                // $btnActivate = '';
                // if ($canDelete) {
                //     $btnActivate = '<a><button type="button" class="btn btn-xs btn-success userActivete" data-id="'.$systemUser->id.'" data-status="'.$systemUser->status.'" title="Enable"><i class="bi bi-arrow-repeat"></i></button></a>';
                // }

                $editButton = '';
                if ($canEdit) {
                    $editButton = '<a>
                                    <button type="button" class="btn btn-xs btn-info userEditBtn" data-id="'.$systemUser->id.'" data-bs-toggle="modal" data-bs-target="#addUserModal" role="button" title="Edit">
                                                <i class="bi bi-pen"></i>
                                            </button>
                                        </a>';
                }


                $privilegeButton = '';
                if($systemUser->id != Auth::user()->id){
                    if ($canPrivilege) {
                        $privilegeButton = '<a href="'.route("users.privilege","$systemUser->id").'" title="Privileges">
                                                <button type="button" class="btn btn-xs btn-warning"><i class="fa fa-lock"></i></button>
                                            </a>';
                    }
                }
                $userPrivilegesName = UserPrivileges::where('id', $systemUser->privilege)->first();

                if($systemUser->privilege > Auth::user()->privilege){
                    $responses .= '<tr>
                                        <td style="vertical-align: middle;"><input type="checkbox" name="chk[]" id="chk_'.$i++.'" class="chk_user" value="'.$systemUser->id.'" /></td>
                                        <td style="vertical-align: middle;">'.$systemUser->username.'</td>
                                        <td style="vertical-align: middle;">'.$systemUser->group_id.'</td>
                                        <td style="vertical-align: middle;">'.$userPrivilegesName->name.'</td>
                                        <td style="vertical-align: middle;">'.$systemUser->full_name.'</td>
                                        <td style="vertical-align: middle;">'.$systemUser->email.'</td>
                                        <td style="vertical-align: middle;">'.$systemUser->phone.'</td>
                                        <td style="vertical-align: middle;">'.$btnActivateType.'</td>

                                        <td style="vertical-align: middle;">
                                            '.$privilegeButton.'
                                            '.$editButton.'
                                            '.$activeInactivebtn.'

                                        </td>
                                    </tr>';
                }elseif($systemUser->privilege == Auth::user()->privilege && $systemUser->id == Auth::user()->id){
                    $responses .= '<tr>
                                        <td style="vertical-align: middle;"></td>
                                        <td style="vertical-align: middle;">'.$systemUser->username.'</td>
                                        <td style="vertical-align: middle;">'.$systemUser->group_id.'</td>
                                        <td style="vertical-align: middle;">'.$userPrivilegesName->name.'</td>
                                        <td style="vertical-align: middle;">'.$systemUser->full_name.'</td>
                                        <td style="vertical-align: middle;">'.$systemUser->email.'</td>
                                        <td style="vertical-align: middle;">'.$systemUser->phone.'</td>
                                        <td style="vertical-align: middle;">'.$btnActivateType.'</td>

                                        <td style="vertical-align: middle;">
                                            '.$privilegeButton.'
                                            '.$editButton.'
                                            '.$activeInactivebtn.'

                                        </td>
                                    </tr>';
                }
            }

            $responses .= '<tbody></table>';

            echo $responses;
        }else{
            echo '<h4>No users found in the system !</h4>';
        }
    }
}
