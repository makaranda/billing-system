<?php

namespace App\Http\Controllers\dashboard\accounting;

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

use App\Models\Banks;
use App\Models\BankAccounts;
use App\Models\Currencies;
use App\Models\CustomerTransactions;
use App\Models\AcAccountSubCategories;
use App\Models\AcAccounts;
use App\Models\BankDepositTypes;

class BankdePosittypesController extends Controller
{
    public function index($route = null){
        $route = $route ?? 'index.accounting';
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

        //$acAccountCategoriesDetails = BankDepositTypes::all();
        //$acAccountSubCategoriesDetails = AcAccountSubCategories::all();
        //$banksDetails = Banks::all();
        $banksDetails = Banks::where('status', 1)
        ->get();
        $acAccountsDetails = AcAccounts::where('status', 1)
        ->get();
        $currenciesDetails = Currencies::where('status', 1)
        ->get();
        $bankAccountsDetails = BankAccounts::all();
        $bankDepositTypeDetails = BankDepositTypes::where('status', 1)
        ->get();



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
        $parentid = 8;
        $mainRouteName = 'index.accounting';
        //dd($mainMenus);
        $countCheckThisRoutes = RoutesPermissions::where('route', $getRoutename)
        ->where('user_id', Auth::user()->id)
        ->where('main_route', $mainRouteName)
        ->count();

        if($countCheckThisRoutes == 0){
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access this route.');
        }else{
            return view('pages.dashboard.accounting.bankdeposittypes', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','bankAccountsDetails','routepermissions','banksDetails','acAccountsDetails','currenciesDetails','bankDepositTypeDetails'));
        }
    }


    public function addBankDepositType(Request $request){
        $messageType = '';
        $message = '';
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'deposit_category' => 'required',
                'deposit_type' => 'required',
            ]);

        if ($validator->fails()) {
            $messageType = 'error';
            //$message = $validator->errors();
            $message = 'All Fields are Required..!!';
        }else{
            $proData = [
                'category' => $request->deposit_category,
                'deposit_type' => $request->deposit_type,
                'created_by' => Auth::user()->id,
            ];

            // Assuming DepartmentHead is the model class for the table
            $addDatas = new BankDepositTypes();

            // Save the data
            $addDatas->fill($proData);
            $addDatas->save();

            $messageType = 'success';
            $message = 'You have successfully Added the Bank Deposit Type data to the database..';
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);

    }

    public function updateBankDepositType(Request $request,$pro_id){
        $messageType = '';
        $message = '';

        try {
                $edit_id = $request->edit_id;
                $getTaxes = BankDepositTypes::find($request->edit_id);

                $validator = Validator::make($request->all(), [
                    'deposit_category' => 'required',
                    'deposit_type' => 'required',
                ]);

                if ($validator->fails()) {
                    $messageType = 'error';
                    //$message = 'Errors: '.$validator->errors();
                    $message = 'All Fields are Required..!!';
                }else{
                    $proData = [
                        'category' => $request->deposit_category,
                        'deposit_type' => $request->deposit_type,
                        'created_by' => Auth::user()->id,
                    ];

                    // update the data
                    $getTaxes->update($proData);

                    $messageType = 'success';
                    $message = 'You have successfully Updated the Bank Deposit Type data to the database..';
                }

        } catch (\Exception $e) {
            // Catch any exception and return a response
            $messageType = 'error';
            $message = 'An error occurred while updating the Bank Deposit Type .'.$e->getMessage();

        }

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function editBankDepositType(Request $request,$cat_id){
        //ProductCategories MiniPosConfigurations AcAccounts
        $getDatas = BankDepositTypes::find($request->id);
        //$departments = Departments::all();
        //$departmentHeads = DepartmentHeads::all();

        if (!$getDatas) {
            return response()->json(['error' => 'Bank Deposit Types are not found'], 404);
        }
        $responseData = [
            'bank_deposit_type' => $getDatas
        ];

        return response()->json($responseData);
    }

    public function deleteBankDepositType(Request $request,$cat_id){
        $messageType = '';
        $message = '';

        $getDatas = BankDepositTypes::find($request->delete_record_id);

        if (!$getDatas) {
            return response()->json(['error' => 'Datas are not found'], 404);
        }

        if($request->delete_record_type == 'inactive'){
            $actveData = 0;
            $message = 'You have successfully Deleted this Bank Deposit Type record..';
        }else{
            $actveData = 1;
            $message = 'You have successfully Activate this Bank Deposit Type record..';
        }

        $proData = [
            'status' => $actveData,
        ];

        // update the data
        $getDatas->update($proData);

        //$getTaxes->delete();
        $messageType = 'success';


        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function fetchBankDepositTypes(){
        $query = BankDepositTypes::query();
        //$getAllRoutePermisssions = Taxes::all();
        $query->WHERE('status', 1);
        $query->orderBy('id', 'asc'); // Default ordering

        $fetchTableDetails = $query->get();
        //$fetchTableDetails = Currencies::all();

        $responses = '';

        if ($fetchTableDetails->count() > 0) {
            $responses .= '

                            <small class="p-2"><table class="table table-stripped table-hover" width="100%"><thead>
			                <tr>
                                <td align="left"><strong>#</strong></td>
                                <td align="left"><strong>Category</strong></td>
                                <td align="left"><strong>Deposit Type</strong></td>
                                <td align="left"><strong>Action</strong></td>
                            </tr>
                            </thead>
		                    <tbody>';
            $i=1;
            foreach ($fetchTableDetails as $key => $fetchDetail) {
                //$userPrivileges = UserPrivileges::find($fetchDetail->privilege);
                //$btnActivateType = ($fetchDetail->status == 1)? 'Active':'Inactive';

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

                $deletebtn = '';
                $deleteRoutePath = 'nominalcategories.deletenominalcategory';
                if ($canDelete) {
                    $acInType = $fetchDetail->status == 1 ? 'inactive' : 'active';
                    $acInColor = $fetchDetail->status == 1 ? 'danger' : 'success';
                    $acInIcon = $fetchDetail->status == 1 ? 'x' : 'arrow-repeat';

                    $deletebtn = '<button type="button" class="btn btn-xs btn-'.$acInColor.' deleteRecordButton" onclick="deleteRecord(' . $fetchDetail->id . ', \'' . $deleteRoutePath . '\', \'' . $acInType . '\');" data-id="' . $fetchDetail->id . '" title="'.$acInType.'"><i class="bi bi-'.$acInIcon.'"></i> </button>';
                }

                $editButton = '';
                if ($canEdit) {
                    $editButton = '<button type="button" class="btn btn-xs btn-info" onclick="editRecord('.$fetchDetail->id.');">
                                                <i class="bi bi-pen"></i>
                                            </button>';
                }

                $responses .= '<tr>
                                    <td style="vertical-align: middle;">'.($key+1).'</td>
                                    <td style="vertical-align: middle;">'.$fetchDetail->category.'</td>
                                    <td style="vertical-align: middle;">'.$fetchDetail->deposit_type.'</td>

                                    <td style="vertical-align: middle;">
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
