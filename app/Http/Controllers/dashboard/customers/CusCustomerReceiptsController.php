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

    public function addCustomerReceipt(Request $request){

        $messageType = '';
        $message = '';
            // Validate the incoming request data payment_date payment_method  currency_id exchange_value payment_amount bank_account
            $validator = Validator::make($request->all(), [
                'payment_method' => 'required',
                'currency_id' => 'required',
                'payment_date' => 'required',
                'exchange_value' => 'required',
                'bank_account' => 'required',
                'payment_amount' => 'required',
            ]);

        $getCurrenciesDatas = BankAccounts::where('id',$request->bank_account)->where('status',1)->first();

        if($request->payment_method == 'wht'){
            $getSequentialNumber = SequentialNumber::where('type','wht')->where('status',1)->first();
        }else{
            $getSequentialNumber = SequentialNumber::where('type','customer_receipt')->where('status',1)->first();
        }

        if(count($getSequentialNumber) == 0){
            $last_number = 0;
            $next_number = $getSequentialNumber->last_number + 1;

            $proSequentialData = [
                'prefix' => '',
                'sufix' => '',
                'last_number' => $next_number,
                'numeric_length' => 8,
                'type' => 'wht'
            ];
            $addSequentialDatas = new SequentialNumber();
            $addSequentialDatas->fill($proSequentialData);
            $addSequentialDatas->save();

        }else{
            $prefix = $getSequentialNumber->prefix;
            $sufix = $getSequentialNumber->sufix;
            $numeric_length = $getSequentialNumber->numeric_length;
            $next_number = $getSequentialNumber->last_number;

            $last_number = 0;
            $next_number = $getSequentialNumber->last_number + 1;
            $getSequentialData = SequentialNumber::where('type','=',''.$request->payment_method.'');

            $proSequentialData = [
                'prefix' => '',
                'sufix' => '',
                'last_number' => $next_number,
                'numeric_length' => 8,
                'type' => 'wht'
            ];
            $getSequentialData->update($proData);
        }

        $receipt_no = $prefix.str_pad($next_number,$numeric_length,'0',STR_PAD_LEFT).$sufix;

        if ($validator->fails()) {
            $messageType = 'error';
            //$message = $validator->errors();
            $message = 'All Fields are Required..!!';
        }else{

            $getCustomerPayments = CustomerPayments::where('type','wht')->where('status',1)->first();

            if($getCurrenciesDatas->currency_id == $request->bank_account){
                $proData = [
                    'group_id' => $request->payment_method,
                    'branch_id' => $request->currency_id,
                    'code' => $request->payment_date,
                    'category_id' => $request->card_type,
                    'company' => $request->auth_number,
                    'address' => $request->account_holder_bank,
                    'postal_code' => $request->reference,
                    'city' => $request->exchange_value,
                    'telephone' => $request->bank_account,
                    'mobile' => $request->payment_amount,
                    'fax' => $request->effected_payment,
                ];

                // Assuming DepartmentHead is the model class for the table
                $addDatas = new CustomerPayments();

                // Save the data
                $addDatas->fill($proData);
                $addDatas->save();

                $messageType = 'success';
                $message = 'You have successfully Added the Customer datas successfully..!!';

            }else{
                $messageType = 'error';
                $message ='unsuccess|Failed to process transaction with selected currency. Bank account doesn`t allow transactions with selected currency, Please try again !';
            }
        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];

        //echo $message;
        return response()->json($responseData);
    }

    public function getConvertedPaymentAmount(Request $request){

        $convertedValue = null;
        $rate = null;
        $symbol = null;

        // Check if 'currency_id' is provided and greater than 0
        if ($request->filled('currency_id') && $request->currency_id > 0) {
            // Check if 'payment_amount' is provided and greater than or equal to 0
            if ($request->filled('payment_amount') && $request->payment_amount >= 0) {
                // Retrieve currency details
                $currency = Currencies::find($request->currency_id); // Fetch currency using the model

                // Check if currency exists and has a rate
                if ($currency && isset($currency->rate)) {
                    $rate = $currency->rate;
                    $symbol = $currency->symbol;

                    // Calculate the converted value
                    $paymentAmount = floatval($request->payment_amount);
                    $convertedValue = round($paymentAmount / $rate, 5);
                }
            }
        }

        // Prepare response data
        $msg = [
            "converted_value" => $convertedValue,
            "currency_value" => $rate,
            "currency_symbol" => $symbol,
        ];

        // Return response as JSON
        return response()->json($msg);
    }

    public function getCustomerReceiptsHistory(Request $request){

    }

    public function editCustomerReceipt(Request $request,$cus_id){

        $getDatas = CustomerPayments::find($request->id);
        $getCustomersDatas = Customers::where('id',$getDatas->customer_id)->where('status',1)->first();
        //$departments = Departments::all();
        //$departmentHeads = DepartmentHeads::all();

        if (!$getDatas) {
            return response()->json(['error' => 'Customers Payments are not found'], 404);
        }
        $responseData = [
            'customer_receipts' => $getDatas,
            'customer_details' => $getCustomersDatas
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
