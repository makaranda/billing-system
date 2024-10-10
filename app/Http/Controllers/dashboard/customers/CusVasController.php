<?php

namespace App\Http\Controllers\dashboard\customers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Models\SystemMenus;
use App\Models\PermissionsTypes;
use App\Models\RoutesPermissions;
use App\Models\SystemUsers;
use App\Models\Customers;
use App\Models\CustomerPayments;
use App\Models\Currencies;
use App\Models\CustomerWhtAttachments;
use App\Models\ProductCategories;
use App\Models\CustomerVas;

use App\Models\Products;

class CusVasController extends Controller
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
        $systemUsersDetails = SystemUsers::where('status','=',1)->get();


        $routepermissions = [];
        foreach ($permissionsTypes as $permissionsType) {
            $routepermissions[$permissionsType->name] = 0;
        }

        $getAllRoutePermisssionsUser = RoutesPermissions::where('user_id', Auth::user()->id)
                                                        ->where('route', $getRoutename)
                                                        ->get();

        $getAllCustomers = Customers::where('status','=', 1)
                                      ->get();
        $getProductCategories = ProductCategories::where('status','=', 1)
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

        $getAllRoutePermisssions = RoutesPermissions::all();
        $remindersRoute = request()->route()->getName();
        $parentid = 3;
        $mainRouteName = 'index.customers';

        $countCheckThisRoutes = RoutesPermissions::where('route', $getRoutename)
        ->where('user_id', Auth::user()->id)
        ->where('main_route', $mainRouteName)
        ->count();
        if($countCheckThisRoutes == 0){
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access this route.');
        }else{
            return view('pages.dashboard.customers.cusvas', compact('mainMenus','subsMenus', 'data','mainRouteName', 'remindersRoute', 'parentid','routesPermissions','getAllRoutePermisssions','routepermissions','getAllCustomers','getProductCategories','systemUsersDetails'));
        }
    }

    public function addVas(Request $request){
        $messageType = '';
        $message = '';
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'group_name' => 'required',
            ]);

        if ($validator->fails()) {
            $messageType = 'error';
            //$message = $validator->errors();
            $message = 'All Fields are Required..!!';
        }else{
            $proData = [
                'code' => '',
                'name' => $request->group_name,
                'default_customer_id' => 0,
                'created_by' => Auth::user()->id,
            ];

            // Assuming DepartmentHead is the model class for the table
            $addDatas = new CustomerGroup();

            // Save the data
            $addDatas->fill($proData);
            $addDatas->save();

            $messageType = 'success';
            $message = 'You have successfully Added the Customer Group data to the database..';
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);

    }
    public function getProductCategory(Request $request){
        $query = Products::join('product_categories', 'product_categories.id', '=', 'products.category_id')
                        ->select(
                            'products.id',
                            'products.category_id',
                            'products.code',
                            'products.name as item_name',
                            'products.price',
                            'products.is_taxable',
                            'products.stock_type',
                            'product_categories.department_id',
                            'product_categories.name as category_name',
                            'products.currency_id'
                        );

            // Add filters conditionally based on the request input
            if ($request->has('id') && !empty($request->id)) {
                $query->where('products.id', $request->id);
            }

            if ($request->has('code') && !empty($request->code)) {
                $query->where('products.code', $request->code);
            }

            if ($request->has('category') && $request->category > 0) {
                $query->where('products.category_id', $request->category);
            }

            if ($request->has('department_id') && $request->department_id > 0) {
                $query->where('product_categories.department_id', $request->department_id);
            }

            if ($request->has('status') && !empty($request->status)) {
                $query->where('products.status', $request->status);
            }

            // Get the count of results (similar to the count query in your original code)
            $count = $query->count();

            // Handle sorting and limiting the results
            if ($request->has('order') && !empty($request->order)) {
                $query->orderBy($request->order);
            } else {
                // Default sorting by name if no order is provided
                $query->orderBy('products.name', 'ASC');
            }

            if ($request->has('limit') && !empty($request->limit)) {
                $query->limit($request->limit);
            }

            // Fetch the final result set
            $results = $query->get();

            // Create the <option> HTML elements for the dropdown
            $select = '<option value="" data-price="0.00">- SELECT ITEM -</option>';

            foreach ($results as $product) {
                $select .= '<option value="' . $product->id . '" data-price="' . $product->price . '">' . $product->item_name . '</option>';
            }

            // Return response as JSON (or output as needed)
            return response()->json([
                'select' => $select,
                'count' => $count
            ]);
    }

    public function deleteVas(Request $request,$cat_id){
        $messageType = '';
        $message = '';

        $getDatas = CustomerVas::find($request->delete_record_id);

        if (!$getDatas) {
            return response()->json(['error' => 'Datas are not found'], 404);
        }

        if($request->delete_record_type == 'Delete'){
            $proData = [
                'status' => 0,
            ];
        }else{
            $proData = [
                'status' => 1,
            ];
        }

        // update the data
        $getDatas->update($proData);

        // update the data
        //$getDatas->delete();

        //$getTaxes->delete();
        $messageType = 'success';
        $message = 'You have successfully Delete this Customer Group record..';

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }


    public function fetchVas(Request $request){

        $fetchTableDetails = DB::table('customer_vas')
                                //->join('customers', 'customer_vas.customer_id', '=', 'customers.id')
                                ->select(
                                    'customer_vas.id',
                                    'customer_vas.customer_id',
                                    'customer_vas.product_id',
                                    'customer_vas.qty',
                                    'customer_vas.product_description',
                                    'customer_vas.start_date',
                                    'customer_vas.end_date',
                                    'customer_vas.approved_by',
                                    'customer_vas.attach',
                                    'customer_vas.invoice_id',
                                    'customer_vas.created_at',
                                    'customer_vas.updated_at',
                                    'customer_vas.created_by',
                                    'customer_vas.status',
                                    //'customers.old_code',
                                    //'customers.company',
                                    //'customers.address'
                                )
                                ->where('customer_vas.status', 1)  // Apply the status filter
                                ->orderBy('customer_vas.id', 'DESC'); // Apply ordering by ID

        // Apply filters based on the request
        if ($request->has('search_category') && $request->search_category != '') {
            $fetchTableDetails->where('customer_vas.receipt_no', 'LIKE', '%' . $request->search_category . '%');
        }

        if ($request->has('search_description') && $request->search_description != '') {
            $fetchTableDetails->where('customer_vas.product_description', 'LIKE', '%' . $request->search_description . '%');
        }

        if ($request->has('search_from_date') && $request->search_from_date != '') {
            $fetchTableDetails->where('customer_vas.start_date', '>=', $request->search_from_date);
        }

        if ($request->has('search_to_date') && $request->search_to_date != '') {
            $fetchTableDetails->where('customer_vas.start_date', '<=', $request->search_to_date . ' 23:59:59');
        }

        if ($request->has('search_customer_id') && $request->search_customer_id != '') {
            $fetchTableDetails->whereIn('customer_vas.customer_id', explode(',', $request->search_customer_id));
        }

        if ($request->has('search_customer_name') && $request->search_customer_name != '') {
            $getCustomer = Customers::where('company','LIKE','%'.$request->search_customer_name.'%')->first();
            $fetchTableDetails->where('customers.company', 'LIKE', '%' . $getCustomer->id . '%');
        }

        if ($request->has('type') && $request->type != '') {
            $fetchTableDetails->where('customer_vas.type', '=', $request->type);
        }

        $responses = '';

        $debit_total = 0;
        $credit_total = 0;

        $fetchTableDetails = $fetchTableDetails->paginate(100);
        $responses = view('pages.dashboard.customers.tables.customer_vas_table', compact('fetchTableDetails'))->render();

        return response()->json(['html' => $responses,'is_posted' => $request->is_posted]);
    }
}
