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
use App\Models\DefaultPaymentBanks;

use Illuminate\Support\Facades\Log;

class BankAccountsController extends Controller
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

        //$acAccountCategoriesDetails = AcAccountCategories::all();
        //$acAccountSubCategoriesDetails = AcAccountSubCategories::all();
        //$banksDetails = Banks::all();
        $banksDetails = Banks::where('status', 1)
        ->get();
        $acAccountsDetails = AcAccounts::where('status', 1)
        ->get();
        $currenciesDetails = Currencies::where('status', 1)
        ->get();
        $bankAccountsDetails = BankAccounts::all();


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
            return view('pages.dashboard.accounting.bankaccounts', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','bankAccountsDetails','routepermissions','banksDetails','acAccountsDetails','currenciesDetails'));
        }
    }


    public function getDefaultBankPaymentMethod(Request $request){
        $query = DefaultPaymentBanks::query()
        ->join('currencies', 'currencies.id', '=', 'default_payment_banks.currency_id')
        ->join('bank_accounts', 'bank_accounts.id', '=', 'default_payment_banks.bank_account_id')
        ->leftJoin('card_types', 'card_types.id', '=', 'default_payment_banks.card_type_id')
        ->select('default_payment_banks.*', 'currencies.name as currency_name',
                 'bank_accounts.account_name', 'bank_accounts.account_no',
                 'card_types.name as card_type_name');

            // Apply filters
            if ($request->has('id') && $request->id != '') {
                $query->where('default_payment_banks.id', $request->id);
            }

            if ($request->has('payment_method') && $request->payment_method != '') {
                $query->where('default_payment_banks.payment_method','LIKE', '%'.$request->payment_method.'%');
            }

            if ($request->has('currency_id') && $request->currency_id != '') {
                $query->where('default_payment_banks.currency_id','=',$request->currency_id);
            }

            if ($request->has('card_type_id') && $request->card_type_id != '') {
                $query->where('default_payment_banks.card_type_id','=', $request->card_type_id);
            }else{
                $query->where('default_payment_banks.card_type_id','=', 0);
            }

            if ($request->has('bank_account_id') && $request->bank_account_id != '') {
                $query->where('default_payment_banks.bank_account_id', '>=', $request->bank_account_id);
            }

            // Get count before applying limit or ordering
            $count = $query->count();

            // Apply ordering
            if ($request->filled('order')) {
                $query->orderByRaw($request->order);
            }

            // Apply limit if specified
            if ($request->filled('limit')) {
                $query->limit($request->limit);
            }

            // Execute query
            $result = $query->get();

                // For debugging: Log the final SQL query
            //\Log::info($query->toSql());
            //\Log::info($query->getBindings());

            // Return the data in JSON format
            return response()->json([
                'count' => $count,
                'result' => $result
            ]);
    }

    public function addBankAccount(Request $request){
        $messageType = '';
        $message = '';
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'bank' => 'required',
                'account_code' => 'required',
                'account_name' => 'required',
                'account_type' => 'required',
                'currency_id' => 'required',
                'nominal_account' => 'required',
                'account_no' => 'required',
                'last_cheque_no' => 'required',
                'payment_method' => 'required',
            ]);

        if ($validator->fails()) {
            $messageType = 'error';
            //$message = $validator->errors();
            $message = 'All Fields are Required..!!';
        }else{
            $proData = [
                'bank_id' => $request->bank,
                'account_code' => $request->account_code,
                'account_name' => $request->account_name,
                'account_type' => $request->account_type,
                'currency_id' => $request->currency_id,
                'account_id' => $request->nominal_account,
                'account_no' => $request->account_no,
                'last_cheque_no' => $request->last_cheque_no,
                'payment_method' => $request->payment_method,
            ];

            // Assuming DepartmentHead is the model class for the table
            $addDatas = new BankAccounts();

            // Save the data
            $addDatas->fill($proData);
            $addDatas->save();

            $messageType = 'success';
            $message = 'You have successfully Added the Bank Account data to the database..';
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);

    }

    public function updateBankAccount(Request $request,$pro_id){
        $messageType = '';
        $message = '';

        try {
                $edit_id = $request->edit_id;
                $getTaxes = BankAccounts::find($request->edit_id);

                $validator = Validator::make($request->all(), [
                    'bank' => 'required',
                    'account_code' => 'required',
                    'account_name' => 'required',
                    'account_type' => 'required',
                    'currency_id' => 'required',
                    'nominal_account' => 'required',
                    'account_no' => 'required',
                    'last_cheque_no' => 'required',
                    'payment_method' => 'required',
                ]);

                if ($validator->fails()) {
                    $messageType = 'error';
                    //$message = 'Errors: '.$validator->errors();
                    $message = 'All Fields are Required..!!';
                }else{
                    $proData = [
                        'bank_id' => $request->bank,
                        'account_code' => $request->account_code,
                        'account_name' => $request->account_name,
                        'account_type' => $request->account_type,
                        'currency_id' => $request->currency_id,
                        'account_id' => $request->nominal_account,
                        'account_no' => $request->account_no,
                        'last_cheque_no' => $request->last_cheque_no,
                        'payment_method' => $request->payment_method,
                    ];

                    // update the data
                    $getTaxes->update($proData);

                    $messageType = 'success';
                    $message = 'You have successfully Updated the Bank Account data to the database..';
                }

        } catch (\Exception $e) {
            // Catch any exception and return a response
            $messageType = 'error';
            $message = 'An error occurred while updating the Bank Account .'.$e->getMessage();

        }

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function editBankAccount(Request $request,$cat_id){
        //ProductCategories MiniPosConfigurations BankAccounts
        $getDatas = BankAccounts::find($request->id);
        //$sub_category_id = $getDatas->sub_category_id;

        //$getSubCategory = AcAccountSubCategories::where('id', $sub_category_id)->first();
        $getCurrencies = Currencies::where('id', $getDatas->currency_id)->first();
        $getNominalAccount = AcAccounts::where('id', $getDatas->account_id)->first();
        //$getSubCategory = AcAccountSubCategories::where('id', $sub_category_id)->first();
        //$departments = Departments::all();
        //$departmentHeads = DepartmentHeads::all(); Currencies AcAccounts

        if (!$getDatas) {
            return response()->json(['error' => 'Account Categories are not found'], 404);
        }
        $responseData = [
            'bank_account' => $getDatas,
            'nominal_account' => $getNominalAccount->id,
            'currenncy_id' => $getCurrencies->id,

        ];

        return response()->json($responseData);
    }

    public function disableBankAccount(Request $request,$cat_id){
        $messageType = '';
        $message = '';

        $getDatas = BankAccounts::find($request->delete_record_id);

        if (!$getDatas) {
            return response()->json(['error' => 'Datas are not found'], 404);
        }

        if($request->delete_record_type == 'inactive'){
            $actveData = 0;
            $message = 'You have successfully Deactivate this Bank Account record..';
        }else{
            $actveData = 1;
            $message = 'You have successfully Activate this Bank Account record..';
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



    public function deleteBankAccount(Request $request,$cat_id){
        $messageType = '';
        $message = '';

        $getDatas = BankAccounts::find($request->delete_record_id);

        if (!$getDatas) {
            return response()->json(['error' => 'Datas are not found'], 404);
        }
        // update the data
        //$getDatas->delete();
        if($request->delete_record_type == 'inactive'){
            $actveData = 0;
        }else{
            $actveData = 1;
        }

        $proData = [
            'status' => $actveData,
        ];

        // update the data
        $getDatas->update($proData);

        //$getTaxes->delete();
        $messageType = 'success';
        $message = 'You have successfully Delete this Bank Account record..';

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }


    public function fetchBankAccounts(Request $request){
        $query = BankAccounts::query();
        //$getAllRoutePermisssions = BankAccounts::all();
        //s_code s_name s_status s_type
        if ($request->has('code') && $request->code != '') {
            $query->where('account_code', 'LIKE', '%' . $request->code . '%');
        }
        if ($request->has('name') && $request->name != '') {
            $query->where('account_name', 'LIKE', '%' . $request->name . '%');
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('bank_id', $request->status);
        }

        $query->where('status', 1);

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
                                <td align="left"><strong>Account Code</strong></td>
                                <td align="left"><strong>Account Name</strong></td>
                                <td align="left"><strong>Bank Account</strong></td>
                                <td align="left"><strong>Currency</strong></td>
                                <td align="left"><strong>Debit</strong></td>
                                <td align="left"><strong>Credit</strong></td>
                                <td align="left"><strong>Balance</strong></td>
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
                                                                ->whereNotNull('nominal_account_id')
                                                                ->where('nominal_account_id', $fetchDetail->account_id)
                                                                ->selectRaw('
                                                                    COALESCE(SUM(debits * currency_value), 0) AS total_debits,
                                                                    COALESCE(SUM(credits * currency_value), 0) AS total_credits,
                                                                    COALESCE(SUM(debits * currency_value) - SUM(credits * currency_value), 0) AS balance
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
                $disableRoutePath = 'bankaccounts.deletebankaccount';
                if ($canDisable) {
                    $acInType = $fetchDetail->status == 1 ? 'inactive' : 'active';
                    $actitleType = $fetchDetail->status == 1 ? 'Click to Disable' : 'Click to Enable';
                    $acInColor = $fetchDetail->status == 1 ? 'warning' : 'success';
                    $acInIcon = $fetchDetail->status == 1 ? 'x' : 'arrow-repeat';

                    $disablebtn = '<button type="button" class="btn btn-xs btn-'.$acInColor.' disableRecordButton" onclick="disableRecord(' . $fetchDetail->id . ', \'' . $disableRoutePath . '\', \'' . $acInType . '\');" data-id="' . $fetchDetail->id . '" title="'.$actitleType.'"><i class="bi bi-'.$acInIcon.'"></i> </button>';
                }

                $deletebtn = '';
                $deleteRoutePath = 'bankaccounts.deletebankaccount';
                if ($canDelete) {
                    $acInType = $fetchDetail->status == 1 ? 'inactive' : 'active';
                    $acInColor = $fetchDetail->status == 1 ? 'danger' : 'success';

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

                $nominalAccountsDetail = AcAccounts::where('id', $fetchDetail->account_id)
                ->where('status', 1)
                ->first();

                $getCurrenciesDetail = Currencies::where('id', $fetchDetail->currency_id)
                ->where('status', 1)
                ->first();

                $getBanksDetail = Banks::where('id', $fetchDetail->bank_id)
                ->where('status', 1)
                ->first();

                $responses .= '<tr>
                                    <td style="vertical-align: middle;">'.($key+1).'</td>
                                    <td style="vertical-align: middle;"><button type="button" class="btn btn-link" onclick="open_account_activity('.$fetchDetail->code.')">'.$fetchDetail->account_code.'</button></td>
                                    <td style="vertical-align: middle;">'.ucwords($fetchDetail->account_name).'<br/><small><i>'.$getBanksDetail->name.' - '.ucwords($fetchDetail->account_type).'Account</i><br/>Account No: '.$fetchDetail->account_no.'</small></td>
                                    <td style="vertical-align: middle;">'.$nominalAccountsDetail->code.' - '.$nominalAccountsDetail->name.'</td>
                                    <td style="vertical-align: middle;">'.$getCurrenciesDetail->code.'</td>
                                    <td style="vertical-align: middle;">'.$is_total_debits.'</td>
                                    <td style="vertical-align: middle;">'.$is_total_credits.'</td>
                                    <td style="vertical-align: middle;">'.$is_balance.'</td>

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
