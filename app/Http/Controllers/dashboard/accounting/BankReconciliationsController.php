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
        $query->orderBy('id', 'asc'); // Default ordering

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
