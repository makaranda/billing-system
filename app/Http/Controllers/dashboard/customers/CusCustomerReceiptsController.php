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
use App\Models\SequentialNumber;

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

    public function postCustomerReceipt(Request $request){

        if(isset($request->cpayment_id)){
            $getCustomerPayments = CustomerPayments::where('id',$request->cpayment_id)->where('status',1)->first();

            $getAcAccounts = AcAccounts::where('control_type','=','debtors_control')->where('status',1)->first();

            $getBankAccounts = BankAccounts::where('id',$getCustomerPayments->bank_account_id)->where('status',1)->first();

            $debtors_control_account = isset($getAcAccounts->id)?$getAcAccounts->id:0;

            $nominal_account_id = isset($getBankAccounts->account_id) && $getBankAccounts->account_id ? $getBankAccounts->account_id : 0;


            $getCustomerTransactionsCustomerCumulative = CustomerTransactions::where('customer_id', '=', $getCustomerPayments->customer_id)
                                                                            ->where('nominal_account_id', '=', $debtors_control_account)
                                                                            ->where('status', 1)
                                                                            ->orderBy('id', 'desc')
                                                                            ->limit(1)
                                                                            ->first(['customer_balance as balance']);

            $getCustomerTransactionsCumalative = CustomerTransactions::where('nominal_account_id', '=', $debtors_control_account)
                                                                    ->where('status', 1)
                                                                    ->orderBy('id', 'desc')
                                                                    ->limit(1)
                                                                    ->first(['customer_balance as balance']);

                                                                        // Check if the record exists
            $customer_cumalative_balance = $getCustomerTransactionsCumalative ? $getCustomerTransactionsCumalative->balance : 0;

            $cumalative_balance = $getCustomerTransactionsCumalative->balance;


            if(isset($getCustomerPayments) && $getCustomerPayments->id != ''){
                if($getCustomerPayments->is_posted == 0){

                    $proData = [
                        'is_posted' => 1,
                        'posted_date' => now()
                    ];
                    // update the data
                    $getCustomerPayments->update($proData);

                    $insertProData1 = [
                        'customer_id' => $getCustomerPayments->customer_id,
                        'transaction_type' => 'customer_receipt',
                        'transaction_reference' => $getCustomerPayments->receipt_no,
                        'source_reference' => $request->cpayment_id,
                        'payment_method' => isset($getCustomerPayments->method) ? $getCustomerPayments->method : 0,
                        'reference' => $getCustomerPayments->reference,
                        'bank_account_id' => $getCustomerPayments->bank_account_id,
                        'nominal_account_id' => $nominal_account_id,
                        'transaction_date' => WORKING_DATE,
                        'effective_date' => $getCustomerPayments->date,
                        'currency_id' => $getCustomerPayments->currency_id,
                        'currency_value' => $getCustomerPayments->currency_value,
                        'amount' => $getCustomerPayments->payment_amount,
                        'debits' => $getCustomerPayments->payment_amount,
                        'credits' => 0,
                        'balance' => $cumalative_balance + $getCustomerPayments->payment_amount,
                        'customer_balance' => 0,
                        'created_by' => Auth::user()->id
                    ];


                    $addDatas = new CustomerTransactions();
                    $addDatas->fill($insertProData1);
                    $addDatas->save();

                    $getCustomerTransactionsCustomerCumulative = CustomerTransactions::where('customer_id', '=', $getCustomerPayments->customer_id)
                                                                                    ->where('nominal_account_id', '=', $debtors_control_account)
                                                                                    ->where('status', 1)
                                                                                    ->orderBy('id', 'desc')
                                                                                    ->limit(1)
                                                                                    ->first(['customer_balance as balance']);

                    $getCustomerTransactionsCumalative = CustomerTransactions::where('nominal_account_id', '=', $debtors_control_account)
                                                                            ->where('status', 1)
                                                                            ->orderBy('id', 'desc')
                                                                            ->limit(1)
                                                                            ->first(['customer_balance as balance']);

                    $customer_cumalative_balance = $getCustomerTransactionsCustomerCumulative->balance;
                    $cumalative_balance = $getCustomerTransactionsCumalative->balance;

                    $insertProData2 = [
                        'customer_id' => $getCustomerPayments->customer_id,
                        'transaction_type' => 'customer_receipt',
                        'transaction_reference' => $getCustomerPayments->receipt_no,
                        'source_reference' => $request->cpayment_id,
                        'payment_method' => $getCustomerPayments->method,
                        'reference' => $getCustomerPayments->reference,
                        'bank_account_id' => 0,
                        'nominal_account_id' => $debtors_control_account,
                        'transaction_date' => WORKING_DATE,
                        'effective_date' => $getCustomerPayments->date,
                        'currency_id' => $getCustomerPayments->currency_id,
                        'currency_value' => $getCustomerPayments->currency_value,
                        'amount' => $getCustomerPayments->payment_amount * -1,
                        'debits' => 0,
                        'credits' => $getCustomerPayments->payment_amount,
                        'balance' => $cumalative_balance - $getCustomerPayments->payment_amount,
                        'customer_balance' => $customer_cumalative_balance - $getCustomerPayments->payment_amount,
                        'created_by' => Auth::user()->id
                    ];

                    $addDatas2 = new CustomerTransactions();
                    $addDatas2->fill($insertProData2);
                    $addDatas2->save();

                    $message = 'Receipt successfully posted !';
                    $messageType = 'success';
                }else{
                    $message = 'Receipt already posted for the payment !';
                    $messageType = 'error';
                }
            }else{
                $message = 'Customer receipt id not found in the request, Please try again !';
                $messageType = 'error';
            }
        }else{
            $message = 'Failed to get information for the selected receipt, Please try again !';
            $messageType = 'error';
        }

        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
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

        $sequentialType = $request->payment_method == 'wht' ? 'wht' : 'customer_receipt';
        $getSequentialNumber = SequentialNumber::where('type', $sequentialType)->where('status', 1)->first();

        // Initialize or update sequential number
        if (!$getSequentialNumber) {
            // Create new sequential number if none found
            $next_number = 1;
            $prefix = '';
            $sufix = '';
            $numeric_length = 8;

            SequentialNumber::create([
                'prefix' => $prefix,
                'sufix' => $sufix,
                'last_number' => $next_number,
                'numeric_length' => $numeric_length,
                'type' => $sequentialType,
                'status' => 1
            ]);
        } else {
            // Update existing sequential number
            $prefix = $getSequentialNumber->prefix;
            $sufix = $getSequentialNumber->sufix;
            $numeric_length = $getSequentialNumber->numeric_length;
            $next_number = $getSequentialNumber->last_number + 1;

            $getSequentialNumber->update(['last_number' => $next_number]);
        }

        // Generate receipt number
        $receipt_no = $prefix . str_pad($next_number, $numeric_length, '0', STR_PAD_LEFT) . $sufix;

        if ($validator->fails()) {
            $messageType = 'error';
            //$message = $validator->errors();
            $message = 'All Fields are Required..!!';
        }else{

            //$getCustomerPayments = CustomerPayments::where('id','=',$request->edit_id)->where('status',1)->get();

            if(isset($request->edit_id) && $request->edit_id > 0){

                    $upquery = "";
                    $data = $request->all(); // Replace as necessary if $data comes from a different source

                    // Fetch the existing customer payment details
                    $getCustomerPayments = CustomerPayments::where('id', $request->edit_id)
                                                        ->where('status', 1)
                                                        ->first();
                if($getCustomerPayments->preceipt_printed == 0){
                    // Initialize the changes array and ignored fields
                    $changes = [];
                    $ignore_fields = ["id", "created_by", "added_user", "added_date"];

                    // Iterate over each field in $getCustomerPayments to compare with new $data
                    foreach ($getCustomerPayments->toArray() as $key => $value) {
                        // Skip ignored fields and check for changes
                        if (!in_array($key, $ignore_fields) && isset($data[$key]) && $data[$key] != $value && $data[$key] !== "") {
                            $changes[$key . "_new"] = $data[$key];
                            $changes[$key . "_old"] = $value;
                        }
                    }
                    // Check if any changes exist
                    if (!empty($changes)) {
                        // Update the record in the database
                        //$getCustomerPayments->update($data);

                        // Log success message
                        $messageType = 'success';
                        $message = "Receipt details successfully saved!";
                    } else {
                        // If no changes are detected
                        $messageType = 'error';
                        $message = "Nothing has changed to update!";
                    }
                    // Assuming DepartmentHead is the model class for the table
                    //$addDatas = new CustomerPayments();

                    // Save the data
                    //$addDatas->fill($proData);
                    //$addDatas->save();
                }else{
                    $messageType = 'error';
                    $message = 'Receipt has been already printed, You cannot change the information !';
                }

                //$messageType = 'error';
                //$message = 'Failed to determine whether receipt has been printed or not, Please try again !';


        }else{
            //"INSERT INTO `customer_payments` (`branch_id`,`receipt_no`,`mcs_id`,`customer_id`, `bank_account_id`, `date`,`currency_id`, `currency_value`, `payment_amount`,`payment`, `method`, `bank_id`, `reference`, `card_type`,`auth_number`, `private_note`, `added_date`, `added_user`) VALUES

            //customer_name payment_date payment_method card_type auth_number reference account_holder_bank currency_id exchange_value  payment_amount effected_payment bank_account
            $getCustomerPayment = CustomerPayments::where('id', $request->edit_id)
                                                        ->where('status', 1)
                                                        ->first();
            if(isset($getCustomerPayment->mcs_id)) $mcs_id = $getCustomerPayment->mcs_id; else $mcs_id = 0;

            $proData = [
                'branch_id' => Auth::user()->branch_id,
                'receipt_no' => $receipt_no,
                'mcs_id' => $mcs_id,
                'customer_id' => $getCustomerPayment->customer_id,
                'bank_account_id' => $request->bank_account,
                'date' => $request->payment_date,
                'currency_id' => $request->currency_id,
                'currency_value' => $request->exchange_value,
                'payment_amount' => $request->payment_amount,
                'payment' => ($request->payment_amount*$request->exchange_value),
                'method' => $request->payment_method,
                'bank_id' => $request->account_holder_bank,
                'reference' => $request->reference,
                'card_type' => $request->card_type,
                'auth_number' => $request->auth_number,
                'private_note' => $getCustomerPayment->private_note,
                'added_date' => WORKING_DATE,
                'added_user' => Auth::user()->id,
            ];

            $addDatas = new CustomerPayments();
            $addDatas->fill($proData);
            $addDatas->save();

        }
    }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];

        //echo $message;
        return response()->json($responseData);
}

    public function deleteCustomerReceipt(Request $request,$cat_id){
        $messageType = '';
        $message = '';

        $getDatas = CustomerPayments::where('id','=',$request->delete_record_id)->where('is_posted','=',0)->first();

        if (!$getDatas) {
            return response()->json(['error' => 'Failed to determine whether receipt has been posted or not, Please try again'], 404);
        }
        // update the data
        //$getDatas->delete();
        if($getDatas->is_posted == 0){
            if($request->delete_record_type == 'Delete'){
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
            $message = 'Customer payment successfully deleted..';
        }else{
            $messageType = 'error';
            $message = 'Receipt has been already posted, You cannot delete this payment..';
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
        $querySum = CustomerPayments::query();
        $currencySymbol = Currencies::where('is_base','=',1)->first();

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
            $querySum->where('is_posted', '=', 1);
        }else{
            if($request->page > 1){
                $query->where('is_posted', '=', 1);
                $querySum->where('is_posted', '=', 1);
            }else{
                $query->where('is_posted', '=', 0);
                $querySum->where('is_posted', '=', 0);
            }
        }
        if ($request->has('is_allocated') && $request->is_allocated != '') {
            $query->where('is_allocated', '=', '' . $request->is_allocated . '');
        }

        $querySum->WHERE('status', 1);
        $totalPayment = $querySum->sum('payment');

        $query->WHERE('status', 1);
        $query->orderBy('receipt_no', 'DESC'); // Default ordering receipt_no DESC

        $fetchTableDetails = $query->get();
        //$fetchTableDetails = Currencies::all();

        $responses = '';

        $debit_total = 0;
        $credit_total = 0;

        $fetchTableDetails = $query->paginate(100);
        $responses = view('pages.dashboard.customers.tables.customers_receipt_table', compact('fetchTableDetails','totalPayment','currencySymbol'))->render();

        return response()->json(['html' => $responses,'is_posted' => $request->is_posted]);
    }


}
