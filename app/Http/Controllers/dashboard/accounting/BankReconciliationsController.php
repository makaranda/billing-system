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

class BankReconciliationsController extends Controller
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
        //$systemUsersDetails = SystemUsers::all();

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
        $systemUsersDetails = SystemUsers::where('status', 1)
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
            return view('pages.dashboard.accounting.bankreconciliations', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','bankAccountsDetails','routepermissions','banksDetails','acAccountsDetails','currenciesDetails','bankDepositTypeDetails','systemUsersDetails'));
        }
    }

    public function fetchBankReconciliations(Request $request){
        $query = CustomerTransactions::query();
        //$getAllRoutePermisssions = AcAccounts::all();
        //s_code s_name s_status s_type
        if ($request->has('code') && $request->code != '') {
            $query->where('code', 'LIKE', '%' . $request->code . '%');
        }
        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        if ($request->has('filter_param') && $request->filter_param != '') {
            if($request->filter_param == 'control'){
                $query->where('is_control', 1);
            }elseif($request->filter_param == 'non-control'){
                $query->where('is_control', 0);
            }elseif($request->filter_param == 'floating'){
                $query->where('is_floating', 1);
            }

        }

        //$query->WHERE('status', 1);
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
                                <td align="left"><strong>Date</strong></td>
                                <td align="left"><strong>Customer</strong></td>
                                <td align="left"><strong>Receipt No.</strong></td>
                                <td align="left"><strong>Pay Method</strong></td>
                                <td align="left"><strong>Bank Account</strong></td>
                                <td align="left"><strong>Transaction Amount</strong></td>
                                <td align="left"><strong>Reconciled By</strong></td>
                                <td align="left"><strong>Reconciled Amount</strong></td>
                                <td align="left"><strong>Action</strong></td>
                            </tr>
                            </thead>
		                    <tbody>';
            $i=1;
            foreach ($fetchTableDetails as $key => $fetchDetail) {
                //$userPrivileges = UserPrivileges::find($fetchDetail->privilege);
                //$btnActivateType = ($fetchDetail->status == 1)? 'Active':'Inactive';

                $getAllRoutePermisssions = RoutesPermissions::where('user_id', Auth::user()->id)->get();
                $getAccountSubCategories = AcAccountSubCategories::where('id', $fetchDetail->sub_category_id)->first();
                $getCustomerTransactions = CustomerTransactions::where('status', 1)
                                                                ->where('nominal_account_id', $fetchDetail->id)
                                                                ->selectRaw('
                                                                    SUM(debits * currency_value) AS total_debits,
                                                                    SUM(credits * currency_value) AS total_credits,
                                                                    (SUM(debits * currency_value) - SUM(credits * currency_value)) AS balance
                                                                ')
                                                                ->first();

                $is_total_debits = ($getCustomerTransactions->total_debits)?number_format($getCustomerTransactions->total_debits,2):'0.00';
                $is_total_credits = ($getCustomerTransactions->total_credits)?number_format($getCustomerTransactions->total_credits,2):'0.00';
                $is_balance = ($getCustomerTransactions->balance)?number_format($getCustomerTransactions->balance,2):'0.00';

                $subcategoryName = ($getAccountSubCategories && $getAccountSubCategories->name) ? $getAccountSubCategories->name : '';
                $isControll = ($fetchDetail && $fetchDetail->is_control == 1) ? 'Yes' : 'No';
                $isFloating = ($fetchDetail && $fetchDetail->is_floating == 1) ? 'Yes' : 'No';
                $isStatus = ($fetchDetail && $fetchDetail->status == 1) ? 'Active' : 'Inactive';

                $currentRoute = request()->route()->getName();
                $parentRoute = 'index.'.explode('.', $currentRoute)[0].'';
                //$parentRoute = 'index.productcategories';

                $canDelete = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'delete' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });

                $canDisable = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'disable' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });

                $canPrivilege = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'privilege' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });

                $canEdit = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                    return $permission->permission_type == 'update' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                });

                $disablebtn = '';
                $disableRoutePath = 'nominalaccounts.disablenominalaccount';
                if ($canDisable) {
                    $acInType = $fetchDetail->status == 1 ? 'inactive' : 'active';
                    $actitleType = $fetchDetail->status == 1 ? 'Click to Disable' : 'Click to Enable';
                    $acInColor = $fetchDetail->status == 1 ? 'warning' : 'success';
                    $acInIcon = $fetchDetail->status == 1 ? 'x' : 'arrow-repeat';

                    $disablebtn = '<button type="button" class="btn btn-xs btn-'.$acInColor.' disableRecordButton" onclick="disableRecord(' . $fetchDetail->id . ', \'' . $disableRoutePath . '\', \'' . $acInType . '\');" data-id="' . $fetchDetail->id . '" title="'.$actitleType.'"><i class="bi bi-'.$acInIcon.'"></i> </button>';
                }

                $deleteRoutePath = 'nominalaccounts.deletenominalaccount';
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
                $debit_total += $getCustomerTransactions->total_debits;
                $credit_total += $getCustomerTransactions->total_credits;

                $responses .= '<tr>
                                    <td style="vertical-align: middle;">'.($key+1).'</td>
                                    <td style="vertical-align: middle;"><button type="button" class="btn btn-link" onclick="open_account_activity('.$fetchDetail->code.')">'.$fetchDetail->code.'</button></td>
                                    <td style="vertical-align: middle;">'.$fetchDetail->name.'</td>
                                    <td style="vertical-align: middle;">'.$subcategoryName.'</td>
                                    <td style="vertical-align: middle;">'.$isControll.'</td>
                                    <td style="vertical-align: middle;">'.$isFloating.'</td>
                                    <td style="vertical-align: middle;">'.$isStatus.'</td>
                                    <td style="vertical-align: middle;">'.$is_total_debits.'</td>
                                    <td style="vertical-align: middle;">'.$is_total_credits.'</td>
                                    <td style="vertical-align: middle;">'.$is_balance.'</td>

                                    <td style="vertical-align: middle;">
                                        '.$editButton.'
                                        '.$disablebtn.'
                                        '.$deletebtn.'

                                    </td>
                                </tr>';

            }

            $responses .= '<tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>TOTALS</strong></td>
                            <td align="right"><strong>'.number_format($debit_total,2).'</strong></td>
                            <td align="right"><strong>'.number_format($credit_total,2).'</strong></td>
                            <td align="right"><strong>'.number_format(($debit_total - $credit_total),2).'</strong></td>
                            <td width="100" class="text-right"></td>
                            </tr>';

            $responses .= '<tbody></table>';

            echo $responses;
        }else{
            echo '<h4>No Datas found in the system !</h4>';
        }
    }
}
