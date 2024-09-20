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

class CusCustomersController extends Controller
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
            return view('pages.dashboard.customers.customers', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','productCategoriesDetails','getAllRoutePermisssions','routepermissions','getAllCollectionBureaus','getAllPriceTypes','getAllBranches','getAllCustomerGroup','getAllcurrencies','getAllterritories'));
        }
    }

    public function addCustomer(Request $request){

        $messageType = '';
        $message = '';

            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'c_code' => 'required',
                'c_company' => 'required',
                'c_address' => 'required',
                'c_city' => 'required',
                'c_postal_code' => 'required',
                'c_email' => 'required',
                'c_telephone' => 'required',
                'c_territory_id' => 'required',
                'c_currency' => 'required',
                'c_category' => 'required',
                'c_group' => 'required',
                'c_branch' => 'required',
            ]);

        if ($validator->fails()) {
            $messageType = 'error';
            //$message = $validator->errors();
            $message = 'All Fields are Required..!!';
        }else{
            $proData = [
                'group_id' => $request->c_group,
                'branch_id' => $request->c_branch,
                'code' => $request->c_code,
                'category_id' => $request->c_category,
                'company' => $request->c_company,
                'address' => $request->c_address,
                'postal_code' => $request->c_postal_code,
                'city' => $request->c_city,
                'telephone' => $request->c_telephone,
                'mobile' => $request->c_mobile,
                'fax' => $request->c_fax,
                'email' => $request->c_email,
                'web_site' => $request->c_web,
                'currency_id' => $request->c_currency,
                'default_price_type' => $request->c_price_type,
                'territory_id' => $request->c_territory_id,
                'contact_position' => $request->c_position1,
                'contact_name' => $request->c_name1,
                'contact_telephone' => $request->c_telephone1,
                'contact_mobile' => $request->c_mobile1,
                'contact_email' => $request->c_email1,
                'contact_position2' => $request->c_position2,
                'contact_name2' => $request->c_name2,
                'contact_telephone2' => $request->c_telephone2,
                'contact_mobile2' => $request->c_mobile2,
                'contact_email2' => $request->c_email2,
                'contact_person_details_last_updated_by' => null,
                'contact_person_details_last_updated_at' => now(),
                'vat_reg_no' => $request->c_vat_reg_no,
                'wht_reg_no' => $request->c_wht_reg_no,
                'collection_bureau_id' => $request->c_collection_bureau,
                'credit_limit' => $request->c_credit_limit,
                'account_balance' => $request->c_book_balance,
                'settlement_due' => $request->c_settlement_due_days,
                'discount_period' => $request->c_discount_period,
                'interest' => $request->c_interest,
                'settlement_discount' => $request->c_settlement_discount,
                'last_credit_review' => $request->c_last_credit_review,
                'next_credit_review' => $request->c_next_credit_review,
                't_n_c' => $request->c_t_n_c,
                'notes' => $request->c_notes,
                'active' => 1,
                'status' => 1,
                'sales_user_id' => null,
                'created_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Assuming DepartmentHead is the model class for the table
            $addDatas = new Customers();

            // Save the data
            $addDatas->fill($proData);
            $addDatas->save();

            $messageType = 'success';
            $message = 'You have successfully Added the Customer datas successfully..!!';
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];

        //echo $message;
        return response()->json($responseData);
    }


    public function updateCustomer(Request $request,$pro_id){
        $messageType = '';
        $message = '';

        try {
                $edit_id = $request->edit_id;
                $getTaxes = Customers::find($request->edit_id);

                $validator = Validator::make($request->all(), [
                    'c_code' => 'required',
                    'c_company' => 'required',
                    'c_address' => 'required',
                    'c_city' => 'required',
                    'c_postal_code' => 'required',
                    'c_email' => 'required',
                    'c_telephone' => 'required',
                    'c_territory_id' => 'required',
                    'c_currency' => 'required',
                    'c_category' => 'required',
                    'c_group' => 'required',
                    'c_branch' => 'required',
                ]);

                if ($validator->fails()) {
                    $messageType = 'error';
                    //$message = 'Errors: '.$validator->errors();
                    $message = 'All Fields are Required..!!';
                }else{
                    $proData = [
                        'group_id' => $request->c_group,
                        'branch_id' => $request->c_branch,
                        'code' => $request->c_code,
                        'category_id' => $request->c_category,
                        'company' => $request->c_company,
                        'address' => $request->c_address,
                        'postal_code' => $request->c_postal_code,
                        'city' => $request->c_city,
                        'telephone' => $request->c_telephone,
                        'mobile' => $request->c_mobile,
                        'fax' => $request->c_fax,
                        'email' => $request->c_email,
                        'web_site' => $request->c_web,
                        'currency_id' => $request->c_currency,
                        'default_price_type' => $request->c_price_type,
                        'territory_id' => $request->c_territory_id,
                        'contact_position' => $request->c_position1,
                        'contact_name' => $request->c_name1,
                        'contact_telephone' => $request->c_telephone1,
                        'contact_mobile' => $request->c_mobile1,
                        'contact_email' => $request->c_email1,
                        'contact_position2' => $request->c_position2,
                        'contact_name2' => $request->c_name2,
                        'contact_telephone2' => $request->c_telephone2,
                        'contact_mobile2' => $request->c_mobile2,
                        'contact_email2' => $request->c_email2,
                        'contact_person_details_last_updated_by' => null,
                        'contact_person_details_last_updated_at' => now(),
                        'vat_reg_no' => $request->c_vat_reg_no,
                        'wht_reg_no' => $request->c_wht_reg_no,
                        'collection_bureau_id' => $request->c_collection_bureau,
                        'credit_limit' => $request->c_credit_limit,
                        'account_balance' => $request->c_book_balance,
                        'settlement_due' => $request->c_settlement_due_days,
                        'discount_period' => $request->c_discount_period,
                        'interest' => $request->c_interest,
                        'settlement_discount' => $request->c_settlement_discount,
                        'last_credit_review' => $request->c_last_credit_review,
                        'next_credit_review' => $request->c_next_credit_review,
                        't_n_c' => $request->c_t_n_c,
                        'notes' => $request->c_notes,
                        'sales_user_id' => null,
                        'created_by' => auth()->id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // update the data
                    $getTaxes->update($proData);

                    $messageType = 'success';
                    $message = 'You have successfully Updated the Customer data to the database..';
                }

        } catch (\Exception $e) {
            // Catch any exception and return a response
            $messageType = 'error';
            $message = 'An error occurred while updating the Customer .'.$e->getMessage();

        }

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function editCustomer(Request $request,$cat_id){
        //ProductCategories MiniPosConfigurations AcAccounts
        $getDatas = Customers::find($request->id);
        //$departments = Departments::all();
        //$departmentHeads = DepartmentHeads::all();

        if (!$getDatas) {
            return response()->json(['error' => 'Customers are not found'], 404);
        }
        $responseData = [
            'customers' => $getDatas
        ];

        return response()->json($responseData);
    }

    public function deleteCustomer(Request $request,$cat_id){
        $messageType = '';
        $message = '';

        $getDatas = Customers::find($request->delete_record_id);

        if (!$getDatas) {
            return response()->json(['error' => 'Datas are not found'], 404);
        }

        if($request->delete_record_type == 'Disable'){
            $actveData = 0;
            $message = 'You have successfully Deleted this Customer record..';
        }elseif($request->delete_record_type == 'Enable'){
            $actveData = 1;
            $message = 'You have successfully Activate this Customer record..';
        }elseif($request->delete_record_type == 'Delete'){
            $actveData = 0;
            $message = 'You have successfully Delete this Customer record..';
        }
        if($request->delete_record_type == 'Delete'){
            $proData = [
                'status' => $actveData,
            ];
        }else{
            $proData = [
                'active' => $actveData,
            ];
        }

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

    public function fetchCustomers(Request $request){
        $query = Customers::query();
        //$getAllRoutePermisssions = AcAccounts::all();
        //s_code s_name s_status s_type
        if ($request->has('code') && $request->code > 0) {
            $query->where('code', '=', ''.$request->code.'');
        }
        if ($request->has('name') && $request->name > 0) {
            $query->where('company', 'LIKE', '%'.$request->name.'%');
        }
        if ($request->has('email') && $request->email != '') {
            $query->where('email', 'LIKE', '%'.$request->email.'%');
        }
        if ($request->has('telephone') && $request->telephone != '') {
            $query->where('telephone', 'LIKE', '%'.$request->telephone.'%');
        }
        if ($request->has('group') && $request->group != '') {
            $query->where('group_id', '=', ''.$request->group.'');
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

        $responses = view('pages.dashboard.customers.tables.customers_table', compact('fetchTableDetails'))->render();

        return response()->json(['html' => $responses]);
    }
}
