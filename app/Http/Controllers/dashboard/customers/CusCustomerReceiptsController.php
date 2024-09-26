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
use App\Models\BankAccounts;
use App\Models\CardTypes;

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
            return view('pages.dashboard.customers.cuscustomerreceipts', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','routepermissions','getAllBankAccounts','getAllCardTypes'));
        }
    }
}
