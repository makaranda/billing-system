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

use App\Models\AcAccountCategories;
use App\Models\AcAccountSubCategories;
use App\Models\CustomerTransactions;
use App\Models\AcAccounts;
use App\Models\Currencies;

class NominalAccountsController extends Controller
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

        $acAccountCategoriesDetails = AcAccountCategories::all();
        $acAccountSubCategoriesDetails = AcAccountSubCategories::all();
        $customerTransactionsDetails = CustomerTransactions::all();
        $acAccountsDetails = AcAccounts::all();


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
            return view('pages.dashboard.accounting.nominalaccounts', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','routepermissions','acAccountCategoriesDetails','acAccountSubCategoriesDetails','customerTransactionsDetails','acAccountsDetails'));
        }
    }

    public function getSubCategories($categoryId){
        $subCategories = AcAccountSubCategories::where('category_id', $categoryId)->get();
        // Return the subcategories as JSON
        return response()->json($subCategories);
    }




    public function addNominalAccount(Request $request){
        $messageType = '';
        $message = '';
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'account_code' => 'required',
                'account_name' => 'required',
            ]);

        if ($validator->fails()) {
            $messageType = 'error';
            //$message = $validator->errors();
            $message = 'All Fields are Required..!!';
        }else{
            $proData = [
                'sub_category_id' => $request->sub_category_id,
                'code' => $request->account_code,
                'name' => $request->account_name,
                'is_control' => ($request->is_control)?1:0,
                'allow_dr' => ($request->allow_dr)?1:0,
                'allow_cr' => ($request->allow_cr)?1:0,
                'is_floating' => ($request->is_floating)?1:0,
                'created_by' => Auth::user()->id,
            ];

            // Assuming DepartmentHead is the model class for the table
            $addDatas = new AcAccounts();

            // Save the data
            $addDatas->fill($proData);
            $addDatas->save();

            $messageType = 'success';
            $message = 'You have successfully Added the Nominal Account data to the database..';
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);

    }

    public function updateNominalAccount(Request $request,$pro_id){
        $messageType = '';
        $message = '';

        try {
                $edit_id = $request->edit_id;
                $getTaxes = AcAccounts::find($request->edit_id);

                $validator = Validator::make($request->all(), [
                    'category_id' => 'required',
                    'sub_category_id' => 'required',
                    'account_code' => 'required',
                    'account_name' => 'required',
                ]);

                if ($validator->fails()) {
                    $messageType = 'error';
                    //$message = 'Errors: '.$validator->errors();
                    $message = 'All Fields are Required..!!';
                }else{
                    $proData = [
                        'sub_category_id' => $request->sub_category_id,
                        'code' => $request->account_code,
                        'name' => $request->account_name,
                        'is_control' => ($request->is_control)?1:0,
                        'allow_dr' => ($request->allow_dr)?1:0,
                        'allow_cr' => ($request->allow_cr)?1:0,
                        'is_floating' => ($request->is_floating)?1:0,
                        'created_by' => Auth::user()->id,
                    ];

                    // update the data
                    $getTaxes->update($proData);

                    $messageType = 'success';
                    $message = 'You have successfully Updated the Nominal Account data to the database..';
                }

        } catch (\Exception $e) {
            // Catch any exception and return a response
            $messageType = 'error';
            $message = 'An error occurred while updating the Nominal Account .'.$e->getMessage();

        }

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function editNominalAccount(Request $request,$cat_id){
        //ProductCategories MiniPosConfigurations AcAccounts
        $getDatas = AcAccounts::find($request->id);
        $sub_category_id = $getDatas->sub_category_id;

        $getSubCategory = AcAccountSubCategories::where('id', $sub_category_id)->first();
        //$departments = Departments::all();
        //$departmentHeads = DepartmentHeads::all();

        if (!$getDatas) {
            return response()->json(['error' => 'Account Categories are not found'], 404);
        }
        $responseData = [
            'nominalaccount' => $getDatas,
            'main_category' => $getSubCategory->category_id,
        ];

        return response()->json($responseData);
    }

    public function disableNominalAccount(Request $request,$cat_id){
        $messageType = '';
        $message = '';

        $getDatas = AcAccounts::find($request->delete_record_id);

        if (!$getDatas) {
            return response()->json(['error' => 'Datas are not found'], 404);
        }

        if($request->delete_record_type == 'inactive'){
            $actveData = 0;
            $message = 'You have successfully Deactivate this Nominal Account record..';
        }else{
            $actveData = 1;
            $message = 'You have successfully Activate this Nominal Account record..';
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



    public function deleteNominalAccount(Request $request,$cat_id){
        $messageType = '';
        $message = '';

        $getDatas = AcAccounts::find($request->delete_record_id);

        if (!$getDatas) {
            return response()->json(['error' => 'Datas are not found'], 404);
        }
        // update the data
        $getDatas->delete();

        //$getTaxes->delete();
        $messageType = 'success';
        $message = 'You have successfully Delete this Nominal Account record..';

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function fetchAccountsActivities(Request $request){
        $query = CustomerTransactions::query()
        ->leftJoin('customers', 'customers.id', '=', 'customer_transactions.customer_id')
        ->select(
            'customer_transactions.*',
            'customers.code as customer_code',
            'customers.company as customer_company'
        );

        // Apply the filters
        if ($request->has('customer_id') && $request->customer_id > 0) {
            $query->where('customer_transactions.customer_id', '=', $request->customer_id);
        }
        if ($request->has('bank_account_id') && $request->bank_account_id > 0) {
            $query->where('customer_transactions.bank_account_id', '=', $request->bank_account_id);
        }
        if ($request->has('account_id') && $request->account_id > 0) {
            $query->where('customer_transactions.nominal_account_id', '=', $request->account_id);
        }
        if ($request->has('recon_status') && $request->recon_status != '' && $request->recon_status >= 0) {
            $query->where('customer_transactions.is_reconciled', '=', $request->recon_status);
        }
        if ($request->has('reconciled_by') && $request->reconciled_by > 0) {
            $query->where('customer_transactions.reconciled_by', '=', $request->reconciled_by);
        }
        if ($request->has('payment_method') && $request->payment_method != '') {
            $query->where('customer_transactions.payment_method', '=', $request->payment_method);
        }
        if ($request->has('reference') && $request->reference != '') {
            $query->where('customer_transactions.transaction_reference', 'LIKE', '%'.$request->reference.'%');
        }
        if ($request->has('receipt_no') && $request->receipt_no != '') {
            $query->where('customer_transactions.transaction_reference', 'LIKE', '%'.$request->receipt_no.'%');
        }
        if ($request->has('from_date') && $request->from_date != '') {
            $query->where('customer_transactions.transaction_date', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date != '') {
            $query->where('customer_transactions.transaction_date', '<=', $request->to_date);
        }

        // Status filter
        $query->where('customer_transactions.status', 1);

        // Handle ordering if specified
        if ($request->has('order') && $request->order != '') {
            $query->orderByRaw($request->order);
        } else {
            $query->orderBy('customer_transactions.id', 'desc'); // Default ordering
        }

        // Handle limiting if specified
        if ($request->has('limit') && $request->limit != '') {
            $query->limit($request->limit);
        }

        // Fetch sum totals
        $sumQuery = clone $query;
        $sumResult = $sumQuery->selectRaw('
            SUM(customer_transactions.debits * currency_value) AS debit_total,
            SUM(customer_transactions.credits * currency_value) AS credit_total
        ')->first();

        // Paginate the main query
        $fetchTableDetails = $query->paginate(10);

        // Render the view
        $responses = view('pages.dashboard.accounting.tables.account_activities_table', compact('fetchTableDetails'))->render();

        // Return JSON response with data and sum totals
        return response()->json([
            'html' => $responses,
            'debit_total' => $sumResult->debit_total,
            'credit_total' => $sumResult->credit_total,
        ]);
    }

    public function fetchNominalAccounts(Request $request){
        //$acAccountCategoriesDetails = AcAccountCategories::all();
        //$acAccountSubCategoriesDetails = AcAccountSubCategories::all();
        //$customerTransactionsDetails = CustomerTransactions::all();
        //$acAccountsDetails = AcAccounts::all();

        $query = AcAccounts::query();
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
                                <td align="left"><strong>Code</strong></td>
                                <td align="left"><strong>Account Name</strong></td>
                                <td align="left"><strong>Category</strong></td>
                                <td align="left"><strong>Is Controll</strong></td>
                                <td align="left"><strong>Is Floating</strong></td>
                                <td align="left"><strong>Stauts</strong></td>
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
