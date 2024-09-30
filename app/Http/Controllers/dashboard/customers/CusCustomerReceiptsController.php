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

use App\Models\ProductCategories;
use App\Models\Customers;
use App\Models\CollectionBureaus;
use App\Models\PriceTypes;
use App\Models\Branches;
use App\Models\CustomerGroup;
use App\Models\Currencies;
use App\Models\Territories;
use App\Models\CustomerTransactions;
use App\Models\CustomerPayments;
use App\Models\AcAccounts;
use App\Models\BankAccounts;
use App\Models\CardTypes;
use App\Models\Banks;

class CusCustomerReceiptsController extends Controller
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
        //$systemUsersDetails = SystemUsers::all();


        $routepermissions = [];
        foreach ($permissionsTypes as $permissionsType) {
            $routepermissions[$permissionsType->name] = 0;
        }

        $getAllRoutePermisssionsUser = RoutesPermissions::where('user_id', Auth::user()->id)
                                                        ->where('route', $getRoutename)
                                                        ->get();
        $getAllCollectionBureaus = CollectionBureaus::where('status',1)->get();
        $getAllPriceTypes = PriceTypes::where('status',1)->get();
        $getAllBranches = Branches::where('status',1)->get();
        $productCategoriesDetails = ProductCategories::where('status', 1)->get();
        $getAllCustomerGroup = CustomerGroup::where('status', 1)->get();
        $getAllcurrencies = Currencies::where('status', 1)->get();
        $getAllterritories = Territories::where('status', 1)->get();
        $getAllBankAccounts = BankAccounts::where('status', 1)->get();
        $getAllCardTypes = CardTypes::where('status', 1)->get();
        $getAllBanks = Banks::where('status', 1)->get();
        $getCurrencySymbol = Currencies::where('status', 1)->where('is_base', 1)->get();

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
            return view('pages.dashboard.customers.cuscustomerreceipts', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','routepermissions','getAllBankAccounts','getAllCardTypes','getAllBanks','getAllcurrencies','getCurrencySymbol'));
        }
    }

    public function getConvertedPaymentAmount(Request $request){

    }

    public function getCustomerReceiptsHistory(Request $request){

    }

    public function editCustomerReceipt(Request $request,$cus_id){

        $getDatas = CustomerPayments::find($request->id);
        //$departments = Departments::all();
        //$departmentHeads = DepartmentHeads::all();

        if (!$getDatas) {
            return response()->json(['error' => 'Customers Payments are not found'], 404);
        }
        $responseData = [
            'customer_payments' => $getDatas
        ];

        return response()->json($responseData);

    }

    public function fetchCustomerReceipts(Request $request){

        $query = CustomerPayments::query();
        //$getAllRoutePermisssions = AcAccounts::all();
        //s_code s_name s_status s_type
        if ($request->has('receipt_no') && $request->receipt_no != '') {
            $query->where('receipt_no', 'LIKE', '%' . $request->receipt_no . '%');
        }
        if ($request->has('method') && $request->method != '') {
            $query->where('method', '=', '' . $request->method . '');
        }
        if ($request->has('from_date') && $request->from_date != '') {
            $query->where('date', '>=', '' . $request->from_date . '');
        }
        if ($request->has('to_date') && $request->to_date != '') {
            $query->where('date', '<=', '' . $request->to_date . '');
        }
        if ($request->has('customer_id') && $request->customer_id != '') {
            $query->where('customer_id', '=', '' . $request->customer_id . '');
        }
        if ($request->has('bank_account_id') && $request->bank_account_id != '') {
            $query->where('bank_account_id', '=', '' . $request->bank_account_id . '');
        }
        if ($request->has('is_posted') && $request->is_posted == 1) {
            $query->where('is_posted', '=', 1);
        }else{
            if($request->page > 1){
                $query->where('is_posted', '=', 1);
            }else{
                $query->where('is_posted', '=', 0);
            }
        }
        if ($request->has('is_allocated') && $request->is_allocated != '') {
            $query->where('is_allocated', '=', '' . $request->is_allocated . '');
        }

        $query->WHERE('status', 1);
        $query->orderBy('receipt_no', 'DESC'); // Default ordering receipt_no DESC

        $fetchTableDetails = $query->get();
        //$fetchTableDetails = Currencies::all();

        $responses = '';

        $debit_total = 0;
        $credit_total = 0;

        $fetchTableDetails = $query->paginate(100);
        $responses = view('pages.dashboard.customers.tables.customers_receipt_table', compact('fetchTableDetails'))->render();

        return response()->json(['html' => $responses,'is_posted' => $request->is_posted]);
    }


}
