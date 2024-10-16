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
use App\Models\AcAccounts;
use App\Models\Products;
use App\Models\DebtAssignments;

class CusDebtManagementController extends Controller
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
        $getAllProducts = Products::where('status', 1)->get();
        $getAllCustomers = Customers::where('status', 1)->get();
        $getAllSystemUsers = SystemUsers::where('status', 1)->get();

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
        $debt_collector_name = "***";
        if(session()->has('DCID')){
            $userData = SystemUsers::where('status', 1)->where('id', session('DCID'))->first();
            if($userData){
                $debt_collector_name = $userData->full_name;
            }
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
            return view('pages.dashboard.customers.cusdebtmanagement', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','routepermissions','getAllCollectionBureaus','getAllterritories','getAllProducts','getAllCustomers','getAllSystemUsers','debt_collector_name'));
        }
    }

    public function fetchDebtManagement(Request $request){

        session([
            'report_from_date' => $request->from_date,
            'report_to_date' => $request->to_date,
            'report_user_id'  => $request->user_id
        ]);

        $query = DebtAssignments::query();

        if ($request->has('id') && $request->id != '') {
            $query->where('id', '=', '' . $request->id . '');
        }
        if ($request->has('from_date') && $request->from_date != '') {
            $query->where('assigned_date', '>=', '' . $request->from_date . '');
        }
        if ($request->has('to_date') && $request->to_date != '') {
            $query->where('assigned_date', '<=', '' . $request->to_date . '');
        }
        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', '=', '' . $request->user_id . '');
        }

        $query->where('status', 1);
        $query->orderBy('assigned_date', 'DESC'); // Default ordering

        $fetchTableDetails = $query->get();
        //$fetchTableDetails = Currencies::all();

        $responses = '';

        $debit_total = 0;
        $credit_total = 0;

        $fetchTableDetails = $query->paginate(100);

        $getAcAccounts = AcAccounts::where('control_type','LIKE', '%debtors_control%')->first();
        $system_users = SystemUsers::where('status', 1)->get();
        $debtors_control_account = $getAcAccounts ? $getAcAccounts->id : 0;

        $customer_balances = [];

        foreach ($fetchTableDetails as $fetchDetail) {
            $customer_balance = DB::table('customer_transactions as a')
                ->select(DB::raw('SUM(customer_balance) AS customer_balance'))
                ->whereIn('id', function ($query) use ($fetchDetail, $debtors_control_account) {
                    // Explicitly pass $debtors_control_account into the closure
                    $query->select(DB::raw('MAX(customer_transactions.id) AS id'))
                        ->from('customer_transactions')
                        ->join('debt_assignments', 'debt_assignments.customer_id', '=', 'customer_transactions.customer_id')
                        ->where('customer_transactions.transaction_date', '<=', 'debt_assignments.assigned_upto')
                        ->where('customer_transactions.nominal_account_id', '=', $debtors_control_account)  // Use passed variable
                        ->where('debt_assignments.user_id', '=', $fetchDetail->user_id)
                        ->where('debt_assignments.assigned_upto', '=', $fetchDetail->assigned_upto)
                        ->groupBy('customer_transactions.customer_id');
                })
                ->first();

            // Store the balance in the array with the assignment ID as the key
            $customer_balances[$fetchDetail->id] = $customer_balance->customer_balance ?? 0;
        }

        //var_dump($customer_balances);
        //$parentRoute = 'index.productcategories';

        $responses = view('pages.dashboard.customers.tables.debt_assignments_table', compact('fetchTableDetails','customer_balances'))->render();

        return response()->json(['html' => $responses]);
    }
}
