<?php

namespace App\Http\Controllers\dashboard\customers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Models\SystemMenus;
use App\Models\PermissionsTypes;
use App\Models\RoutesPermissions;
use App\Models\SystemUsers;

use App\Models\CustomerGroup;

class CusAddCustomerGroupsController extends Controller
{
    public function index($route = null){
        $route = $route ?? 'index.customers';
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
        $systemUsersDetails = SystemUsers::all();

        // $banksDetails = Banks::where('status', 1)
        // ->get();

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
        $parentid = 3;
        $mainRouteName = 'index.customers';
        //dd($mainMenus);
        $countCheckThisRoutes = RoutesPermissions::where('route', $getRoutename)
        ->where('user_id', Auth::user()->id)
        ->where('main_route', $mainRouteName)
        ->count();
        if($countCheckThisRoutes == 0){
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access this route.');
        }else{
            return view('pages.dashboard.customers.addcustomergroup', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','routepermissions'));
        }
    }


    public function editCustomerGroup(Request $request,$cat_id){
        //ProductCategories MiniPosConfigurations AcAccounts
        $getDatas = CustomerGroup::find($request->id);

        if (!$getDatas) {
            return response()->json(['error' => 'Customer Groups are not found'], 404);
        }
        $responseData = [
            'customergroups' => $getDatas,
        ];

        return response()->json($responseData);
    }



    public function addCustomerGroup(Request $request){
        $messageType = '';
        $message = '';
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'group_name' => 'required',
            ]);

        if ($validator->fails()) {
            $messageType = 'error';
            //$message = $validator->errors();
            $message = 'All Fields are Required..!!';
        }else{
            $proData = [
                'code' => '',
                'name' => $request->group_name,
                'default_customer_id' => 0,
                'created_by' => Auth::user()->id,
            ];

            // Assuming DepartmentHead is the model class for the table
            $addDatas = new CustomerGroup();

            // Save the data
            $addDatas->fill($proData);
            $addDatas->save();

            $messageType = 'success';
            $message = 'You have successfully Added the Customer Group data to the database..';
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);

    }

    public function updateCustomerGroup(Request $request,$pro_id){
        $messageType = '';
        $message = '';

        try {
                $edit_id = $request->edit_id;
                $getTableVal = CustomerGroup::find($request->edit_id);

                $validator = Validator::make($request->all(), [
                    'group_name' => 'required',
                ]);

                if ($validator->fails()) {
                    $messageType = 'error';
                    //$message = 'Errors: '.$validator->errors();
                    $message = 'All Fields are Required..!!';
                }else{
                    $proData = [
                        'code' => '',
                        'name' => $request->group_name,
                        'default_customer_id' => 0,
                        'created_by' => Auth::user()->id,
                    ];

                    // update the data
                    $getTableVal->update($proData);

                    $messageType = 'success';
                    $message = 'You have successfully Updated the Customer Group data to the database..';
                }

        } catch (\Exception $e) {
            // Catch any exception and return a response
            $messageType = 'error';
            $message = 'An error occurred while updating the Customer Group .'.$e->getMessage();

        }

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function deleteCustomerGroup(Request $request,$cat_id){
        $messageType = '';
        $message = '';

        $getDatas = CustomerGroup::find($request->delete_record_id);

        if (!$getDatas) {
            return response()->json(['error' => 'Datas are not found'], 404);
        }
        // update the data
        $getDatas->delete();

        //$getTaxes->delete();
        $messageType = 'success';
        $message = 'You have successfully Delete this Customer Group record..';

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function fetchAddCustomerGroups(Request $request){
        $query = CustomerGroup::query();

        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $query->WHERE('status', 1);
        $query->orderBy('id', 'asc'); // Default ordering

        $fetchTableDetails = $query->get();
        //$fetchTableDetails = Currencies::all();

        $responses = '';

        $debit_total = 0;
        $credit_total = 0;

        if ($fetchTableDetails->count() > 0) {
            $responses .= '

                            <small class="p-2"><table class="table table-stripped table-hover" width="100%"><thead>
			                <tr>
                                <td align="left"><strong>#</strong></td>
                                <td align="left"><strong>Name</strong></td>
                                <td align="right"><strong>Action</strong></td>
                            </tr>
                            </thead>
		                    <tbody>';
            $i=1;
            foreach ($fetchTableDetails as $key => $fetchDetail) {

                $getAllRoutePermisssions = RoutesPermissions::where('user_id', Auth::user()->id)->get();

                $currentRoute = request()->route()->getName();
                $parentRoute = 'index.'.explode('.', $currentRoute)[0].'';
                //$parentRoute = 'index.productcategories';

                $canDelete = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'delete' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });

                $canPrivilege = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'privilege' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });

                $canEdit = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'update' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });


                $deleteRoutePath = 'cusaddcustomergroups.deletecustomergroup';
                $deletebtn = '';
                if ($canDelete) {
                    $acInType = $fetchDetail->status == 1 ? 'Delete' : 'Delete';
                    $acInColor = $fetchDetail->status == 1 ? 'danger' : 'danger';

                    $deletebtn = '<button type="button" class="btn btn-xs btn-'.$acInColor.' deleteRecordButton" onclick="deleteRecord(' . $fetchDetail->id . ', \'' . $deleteRoutePath . '\', \'' . $acInType . '\');" data-id="' . $fetchDetail->id . '" title="'.$acInType.'"><i class="glyphicon glyphicon-trash"></i> </button>';
                }

                $editButton = '';
                if ($canEdit) {
                    $editButton = '<button type="button" class="btn btn-xs btn-info" onclick="editRecord('.$fetchDetail->id.');">
                                                <i class="bi bi-pen"></i>
                                            </button>';
                }


                $responses .= '<tr>
                                    <td style="vertical-align: middle;">'.($key+1).'</td>
                                    <td style="vertical-align: middle;">'.$fetchDetail->name.'</td>

                                    <td style="vertical-align: ;" align="right">
                                        '.$editButton.'
                                        '.$deletebtn.'

                                    </td>
                                </tr>';

            }


            $responses .= '<tbody></table>';

            echo $responses;
        }else{
            echo '<h4>No Datas found in the system !</h4>';
        }
    }
}
