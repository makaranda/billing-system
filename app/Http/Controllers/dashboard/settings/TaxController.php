<?php

namespace App\Http\Controllers\dashboard\settings;

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
use App\Models\Departments;
use App\Models\DepartmentHeads;
use App\Models\UserPrivileges;

use App\Models\AcAccounts;
use App\Models\MiniPosConfigurations;
use App\Models\ProductCategories;
use App\Models\Taxes;
use App\Models\Currencies;
use App\Models\Products;

class TaxController extends Controller
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
        $systemUsersDetails = SystemUsers::all();

        $acAccountsDetails = AcAccounts::all();
        $proCategoriesDetails = ProductCategories::all();
        $taxesDetails = Departments::all();
        $taxesDetails = Taxes::all();
        $currenciesDetails = Currencies::all();


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

        if($countCheckThisRoutes == 0){
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access this route.');
        }else{
            return view('pages.dashboard.settings.tax', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','taxesDetails','routepermissions','acAccountsDetails'));
        }
    }


    public function addTax(Request $request){
        $messageType = '';
        $message = '';
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'tax_name' => 'required',
                'tax_percentage' => 'required',
                'nominal_account' => 'required',
            ]);
//`category_id`, `code`, `name`, `description`, `currency_id`, `price`, `is_taxable`, `stock_type`, `created_at`, `updated_at`, `status`, `Kbilling_product_id`
        // Check if the validation fails
        if ($validator->fails()) {
            $messageType = 'error';
            $message = $validator->errors();
        }else{
            $proData = [
                'code' => $request->tax_name,
                'name' => $request->tax_name,
                'rate' => $request->tax_percentage,
                'nominal_account_id' => $request->nominal_account,
                'calc_method' => '',
                'calc_order' => 0,
            ];

            // Assuming DepartmentHead is the model class for the table
            $addTaxes = new Taxes();

            // Save the data
            $addTaxes->fill($proData);
            $addTaxes->save();

            $messageType = 'success';
            $message = 'You have successfully Added the Tax data to the database..';
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);

    }

    public function updateTax(Request $request,$pro_id){
        $messageType = '';
        $message = '';

        try {
                $edit_id = $request->edit_id;
                $getTaxes = Taxes::find($request->edit_id);

                $validator = Validator::make($request->all(), [
                    'tax_name' => 'required',
                    'tax_percentage' => 'required',
                    'nominal_account' => 'required',
                ]);

                if ($validator->fails()) {
                    $messageType = 'error';
                    $message = 'Errors: '.$validator->errors();
                }else{
                    $proData = [
                        'code' => $request->tax_name,
                        'name' => $request->tax_name,
                        'rate' => $request->tax_percentage,
                        'nominal_account_id' => $request->nominal_account,
                        'calc_method' => '',
                        'calc_order' => 0,
                    ];

                    // update the data
                    $getTaxes->update($proData);

                    $messageType = 'success';
                    $message = 'You have successfully Updated the Tax data to the database..';
                }

        } catch (\Exception $e) {
            // Catch any exception and return a response
            $messageType = 'error';
            $message = 'An error occurred while updating the Tax .'.$e->getMessage();

        }

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function edittax(Request $request,$cat_id){
        //ProductCategories MiniPosConfigurations AcAccounts
        $getTaxes = Taxes::find($request->id);
        //$departments = Departments::all();
        //$departmentHeads = DepartmentHeads::all();

        if (!$getTaxes) {
            return response()->json(['error' => 'Taxes are not found'], 404);
        }
        $responseData = [
            'taxes' => $getTaxes
        ];

        return response()->json($responseData);
    }

    public function deleteTax(Request $request,$cat_id){
        $messageType = '';
        $message = '';

        $getTaxes = Taxes::find($request->delete_record_id);

        if (!$getTaxes) {
            return response()->json(['error' => 'Tax is not found'], 404);
        }

        if($request->delete_record_type == 'inactive'){
            $actveData = 0;
            $message = 'You have successfully Deactivate this Tax record..';
        }else{
            $actveData = 1;
            $message = 'You have successfully Activate this Tax record..';
        }

        $proData = [
            'status' => $actveData,
        ];

        // update the data
        $getTaxes->update($proData);

        //$getTaxes->delete();
        $messageType = 'success';


        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function fetchproTaxesAll(Request $request){
        //$query = Products::query();
        $getAllRoutePermisssions = Taxes::all();

        //$query->orderBy('name', 'asc'); // Default ordering

        //$taxesDetails = $query->get();

        $taxesDetails = DB::table('taxes')
                                    ->join('ac_accounts', 'taxes.nominal_account_id', '=', 'ac_accounts.code') // Adding join with products table
                                    ->select(
                                        'ac_accounts.code as ac_account_code',
                                        'ac_accounts.name as ac_account_name',
                                        'taxes.id',
                                        'taxes.code as taxes_code',
                                        'taxes.name as taxes_name',
                                        'taxes.rate',
                                        'taxes.category',
                                        'taxes.calc_method',
                                        'taxes.calc_order',
                                        'taxes.added_date',
                                        'taxes.status'
                                    )->get();

        $responses = '';

        if ($taxesDetails->count() > 0) {
            $responses .= '

                            <small class="p-2"><table class="table table-stripped table-hover" width="100%"><thead>
			                <tr>
                                <td align="left"><strong>#</strong></td>
                                <td align="left"><strong>Tax Name</strong></td>
                                <td align="left"><strong>Tax Percentage</strong></td>
                                <td align="left"><strong>Nominal Account</strong></td>
                                <td align="left"><strong>Action</strong></td>
                            </tr>
                            </thead>
		                    <tbody>';
            $i=1;
            foreach ($taxesDetails as $key => $taxesDetail) {
                //$userPrivileges = UserPrivileges::find($taxesDetail->privilege);
                //$btnActivateType = ($taxesDetail->status == 1)? 'Active':'Inactive';

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
                $deleteRoutePath = 'tax.deletetax';
                if ($canDelete) {
                    $acInType = $taxesDetail->status == 1 ? 'inactive' : 'active';
                    $acInColor = $taxesDetail->status == 1 ? 'danger' : 'success';
                    $acInIcon = $taxesDetail->status == 1 ? 'x' : 'arrow-repeat';

                    $deletebtn = '<button type="button" class="btn btn-xs btn-'.$acInColor.' deleteRecordButton" onclick="deleteRecord(' . $taxesDetail->id . ', \'' . $deleteRoutePath . '\', \'' . $acInType . '\');" data-id="' . $taxesDetail->id . '" title="'.$acInType.'"><i class="bi bi-'.$acInIcon.'"></i> </button>';
                }

                $editButton = '';
                if ($canEdit) {
                    $editButton = '<button type="button" class="btn btn-xs btn-info" onclick="editTaxes('.$taxesDetail->id.');">
                                                <i class="bi bi-pen"></i>
                                            </button>';
                }

                $responses .= '<tr>
                                    <td style="vertical-align: middle;">'.($key+1).'</td>
                                    <td style="vertical-align: middle;">'.$taxesDetail->taxes_name.'</td>
                                    <td style="vertical-align: middle;">'.$taxesDetail->rate.'</td>
                                    <td style="vertical-align: middle;">'.$taxesDetail->ac_account_code.'-'.$taxesDetail->ac_account_name.'</td>

                                    <td style="vertical-align: middle;">
                                        '.$editButton.'
                                        '.$deletebtn.'

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
