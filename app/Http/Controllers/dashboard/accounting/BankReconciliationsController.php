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
use App\Models\BankRds;

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

    public function updateBankReconciliation(Request $request,$pro_id){
        //BankRds
        //

    }

    public function disableBankReconciliation(Request $request,$pro_id){
        //BankRds
        //
        $messageType = '';
        $message = '';

        $getDatas = CustomerTransactions::where('id', $request->id)->first();
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'notes' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            $messageType = 'error';
            //$message = 'Errors: '.$validator->errors();
            $message = 'All Fields are Required..!!';
        }else{
            //$getDatas = AcAccounts::find($request->id);

            $rd_no = str_pad($request->id, 8, '0', STR_PAD_LEFT);
            $proData = [
                'rd_no' => $rd_no,
                'date' => $request->date,
                'notes' => $request->notes,
                'bank_account_id' => $getDatas->bank_account_id,
                'customer_id' => $getDatas->customer_id,
                'payment_type' => $getDatas->transaction_type,
                'payment_date' => $getDatas->effective_date,
                'method' => $getDatas->payment_method,
                'reference' => "RD-CHEQUES",
                'bank_nominal_account_id' => $getDatas->nominal_account_id,
                'currency_id' => $getDatas->currency_id,
                'currency_value' => $getDatas->currency_value,
                'payment_amount' => $getDatas->amount,
                'payment_id' => $getDatas->source_reference,
                'transaction_id' => '',
                'created_by' => Auth::user()->id,
                'receipt_no' => $getDatas->transaction_reference

            ];

            $addDatas = new BankRds();

            $addDatas->fill($proData);
            $addDatas->save();

            $insert_id = $addDatas->id;

            // if (!$getDatas) {
            //     return response()->json(['error' => 'Datas are not found, 404']);
            // }

            // if($request->delete_record_type == 'inactive'){
            //     $actveData = 0;
            //     $message = 'You have successfully Deactivate this Nominal Account record..';
            // }else{
            //     $actveData = 1;
            //     $message = 'You have successfully Activate this Nominal Account record..';
            // }

            // $proData = [
            //     'status' => $actveData,
            // ];

            // // update the data
            // $getDatas->update($proData);

            //$getTaxes->delete();
            $messageType = 'success';
            $message = 'You have successfully Deactivate this Nominal Account record..';
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function fetchBankReconciliations(Request $request){
        $query = CustomerTransactions::query();
        //$getAllRoutePermisssions = AcAccounts::all();
        //s_code s_name s_status s_type
        if ($request->has('bank_account_id') && $request->bank_account_id > 0) {
            $query->where('bank_account_id', '=', ''.$request->bank_account_id.'');
        }
        if ($request->has('recon_status') && $request->recon_status != '' && $request->recon_status >= 0) {
            $query->where('is_reconciled', '=', ''.$request->recon_status.'');
        }
        if ($request->has('reconciled_by') && $request->reconciled_by > 0) {
            $query->where('reconciled_by', '=', ''.$request->reconciled_by.'');
        }
        if ($request->has('payment_method') && $request->payment_method != '') {
            $query->where('payment_method', '=', ''.$request->payment_method.'');
        }
        if ($request->has('reference') && $request->reference != '') {
            $query->where('reference', 'LIKE', '%'.$request->reference.'%');
        }
        if ($request->has('receipt_no') && $request->receipt_no != '') {
            $query->where('transaction_reference', 'LIKE', '%'.$request->receipt_no.'%');
        }
        if ($request->has('from_date') && $request->from_date != '') {
            $query->where('transaction_date', '>=', ''.$request->from_date.'');
        }
        if ($request->has('to_date') && $request->to_date != '') {
            $query->where('transaction_date', '<=', ''.$request->to_date.'');
        }

        $query->WHERE('status', 1);
        $query->orderBy('id', 'desc'); // Default ordering

        $fetchTableDetails = $query->get();
        //$fetchTableDetails = Currencies::all();

        $responses = '';

        $debit_total = 0;
        $credit_total = 0;

        $fetchTableDetails = $query->paginate(100);

        //$parentRoute = 'index.productcategories';

        $responses = view('pages.dashboard.accounting.tables.bank_reconciliations_table', compact('fetchTableDetails'))->render();

        return response()->json(['html' => $responses]);

    }
}
