<?php

namespace App\Http\Controllers\dashboard\settings;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Exports\SystemUsersExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Models\SystemMenus;
use App\Models\PermissionsTypes;
use App\Models\RoutesPermissions;
use App\Models\SystemUsers;
use App\Models\Departments;
use App\Models\DepartmentHeads;
use App\Models\UserPrivileges;

class DepartmentsController extends Controller
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
        $getAllRoutePermisssions = RoutesPermissions::all();
        foreach ($routesPermissions as $routesPermission) {
            $routesPermission = $routesPermission->orderBy('id')->get();
        }

        $permissionsTypes = PermissionsTypes::all();
        $departmentsDetails = SystemUsers::all();


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
        $countCheckThisRoutes = RoutesPermissions::where('route', $getRoutename)
        ->where('user_id', Auth::user()->id)
        ->where('main_route', $mainRouteName)
        ->count();

        $allDepartments = Departments::all();
        $allDepartmentHeads = DepartmentHeads::all();

        if($countCheckThisRoutes == 0){
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access this route.');
        }else{
            return view('pages.dashboard.settings.departments', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','routepermissions','allDepartments','allDepartmentHeads'));
        }
    }

    public function addhodInformation(Request $request){
        $messageType = '';
        $message = '';
            // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'hod_title' => 'required',
            'hod_full_name' => 'required',
            'hod_email' => 'required|email',
        ]);

        $existingEmail = DepartmentHeads::where('email', $request->hod_email)->exists();

        // Check if the validation fails
        if ($validator->fails()) {
            $messageType = 'error';
            $message = $validator->errors();
        }else{

        // Prepare the data for saving
            if($existingEmail){
                $messageType = 'error';
                $message = 'The email has already been taken...!! Try an Other Email..';
            }else{
                $userData = [
                    'title' => $request->hod_title,
                    'full_name' => $request->hod_full_name,
                    'email' => $request->hod_email,
                    'phone' => $request->hod_phone,
                    'status' => 1,
                ];

                // Assuming DepartmentHead is the model class for the table
                $departmentHead = new DepartmentHeads();

                // Save the data
                $departmentHead->fill($userData);
                $departmentHead->save();

                $messageType = 'success';
                $message = 'You have successfully Added the HOD data to the database..';
            }
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function addnewdepartmentInformation(Request $request){
        $messageType = '';
        $message = '';
            // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'department_group' => 'required',
            'department_code' => 'required',
            'department_name' => 'required',
        ]);

        $existingCode = Departments::where('code', $request->department_code)->exists();

        // Check if the validation fails
        if ($validator->fails()) {
            $messageType = 'error';
            $message = 'Errors: '.$validator->errors();
        }else{

        // Prepare the data for saving
            if($existingCode){
                $messageType = 'error';
                $message = 'The Department Code has already been taken...!! Try an Other Code..';
            }else{
                $depData = [
                    'code' => $request->department_code,
                    'name' => $request->department_name,
                    'department' => $request->department_group,
                    'status' => 1,
                ];

                // Assuming DepartmentHead is the model class for the table
                $departments = new Departments();

                // Save the data
                $departments->fill($depData);
                $departments->save();

                $messageType = 'success';
                $message = 'You have successfully Added the Department data to the database..';
            }
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function updatedepartmentHead(Request $request,$dep_id){
        $messageType = '';
        $message = '';

        $departmentID = $request->dep_id;
        $getDepartment = Departments::find($request->dep_id);

        $validator = Validator::make($request->all(), [
            'assign_hod' => 'required',
        ]);

        if ($validator->fails()) {
            $messageType = 'error';
            $message = 'Errors: '.$validator->errors();
        }else{
            $depData = [
                'department_head' => $request->assign_hod,
            ];

            // update the data
            $getDepartment->update($depData);

            $messageType = 'success';
            $message = 'You have successfully Updated the Department Head data to the database..';
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function updatedepartmentInformation(Request $request,$dep_id){
        $messageType = '';
        $message = '';

        $departmentID = $request->dep_id;
        $getDepartment = Departments::find($request->dep_id);

        $validator = Validator::make($request->all(), [
            'department_group' => 'required',
            'department_code' => 'required',
            'department_name' => 'required',
        ]);

        if ($validator->fails()) {
            $messageType = 'error';
            $message = 'Errors: '.$validator->errors();
        }else{
            $depData = [
                'code' => $request->department_code,
                'name' => $request->department_name,
                'department' => $request->department_group,
                'status' => 1,
            ];

            // update the data
            $getDepartment->update($depData);

            $messageType = 'success';
            $message = 'You have successfully Updated the Department data to the database..';
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function getdepartmenthead(Request $request){
        $departmentID = $request->id;
        $getDepartment = Departments::find($request->id);
        $departmentHeads = DepartmentHeads::all();

        if (!$getDepartment) {
            return response()->json(['error' => 'Department not found'], 404);
        }
        $responseData = [
            'departments' => $getDepartment,
            'department_heads' => $departmentHeads
        ];

        return response()->json($responseData);
    }

    public function getdepartmentAll(Request $request){
        $departmentID = $request->id;
        $getDepartment = Departments::find($request->id);
        $departmentHeads = DepartmentHeads::all();

        if (!$getDepartment) {
            return response()->json(['error' => 'Department not found'], 404);
        }
        $responseData = [
            'departments' => $getDepartment,
            'department_heads' => $departmentHeads
        ];

        return response()->json($responseData);
    }

    public function fetchdepartmentAll(Request $request){
        $query = Departments::query();
        $getAllRoutePermisssions = RoutesPermissions::all();

        $query->orderBy('name', 'asc'); // Default ordering

        $departmentsDetails = $query->get();

        $responses = '';

        if ($departmentsDetails->count() > 0) {
            $responses .= '

                            <small class="p-2"><table class="table table-stripped table-hover" width="100%"><thead>
			                <tr>
                                <td align="left"><strong>#</strong></td>
                                <td align="left"><strong>Code</strong></td>
                                <td align="left"><strong>Name</strong></td>
                                <td align="left"><strong>Group</strong></td>
                                <td align="left"><strong>HOD</strong></td>
                                <td align="left"><strong>Action</strong></td>
                            </tr>
                            </thead>
		                    <tbody>';
            $i=1;
            foreach ($departmentsDetails as $key => $departmentsDetail) {
                //$userPrivileges = UserPrivileges::find($departmentsDetail->privilege);
                $btnActivateType = ($departmentsDetail->status == 1)? 'Active':'Inactive';

                $getAllRoutePermisssions = RoutesPermissions::where('user_id', Auth::user()->id)->get();

                $currentRoute = request()->route()->getName();
                $parentRoute = 'index.'.explode('.', $currentRoute)[0].'s';

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
                    if($departmentsDetail->status == 1){
                        $activeInactivebtn = '<button type="button" class="btn btn-xs btn-danger userActivete" data-id="'.$departmentsDetail->id.'" data-status="'.$departmentsDetail->status.'" title="Disable">
                                                <i class="bi bi-x"></i>
                                            </button>';
                    }else{
                        $activeInactivebtn = '<button type="button" class="btn btn-xs btn-success userActivete" data-id="'.$departmentsDetail->id.'" data-status="'.$departmentsDetail->status.'" title="Enable">
                                            <i class="bi bi-arrow-repeat"></i>
                                            </button>';
                    }
                }
                // $btnActivate = '';
                // if ($canDelete) {
                //     $btnActivate = '<a><button type="button" class="btn btn-xs btn-success userActivete" data-id="'.$departmentsDetail->id.'" data-status="'.$departmentsDetail->status.'" title="Enable"><i class="bi bi-arrow-repeat"></i></button></a>';
                // }

                $editButton = '';
                if ($canEdit) {
                    $editButton = '<button type="button" class="btn btn-xs btn-info" onclick="editDepartment('.$departmentsDetail->id.');">
                                                <i class="bi bi-pen"></i>
                                            </button>';
                }

                $privilegeButton = '';
                if($departmentsDetail->id != Auth::user()->id){
                    if ($canPrivilege) {
                        $privilegeButton = '<button type="button" class="btn btn-xs btn-success" onclick="assignDepartmentHead('.$departmentsDetail->id.');"><i class="fa fa-user"></i></button>';
                    }
                }
                $userPrivilegesName = UserPrivileges::where('id', $departmentsDetail->privilege)->first();

                $responses .= '<tr>
                                    <td style="vertical-align: middle;">'.($key+1).'</td>
                                    <td style="vertical-align: middle;">'.$departmentsDetail->code.'</td>
                                    <td style="vertical-align: middle;">'.$departmentsDetail->name.'</td>
                                    <td style="vertical-align: middle;">'.$departmentsDetail->department.'</td>
                                    <td style="vertical-align: middle;">'.$departmentsDetail->department_head.'</td>

                                    <td style="vertical-align: middle;">
                                        '.$privilegeButton.'
                                        '.$editButton.'
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
