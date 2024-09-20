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
use App\Models\CustomerPayments;
use App\Models\CustomerPaymentAllocations;

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
        $messageType = '';
        $message = '';
        try {
            $getDatas = CustomerTransactions::where('id', $request->id)->first();
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'update_date' => 'required',
                'statement_no' => 'required',
                'update_amount' => 'required',
            ]);
            if ($validator->fails()) {
                $messageType = 'error';
                //$message = 'Errors: '.$validator->errors();
                $message = 'All Fields are Required..!!';
            }else{
                $proData = [
                    'update_date' => $request->update_date,
                    'amount_received' => $request->update_amount,
                    'statement_no' => $request->statement_no,
                    'reconciled_by' => Auth::user()->id,
                    'reconciled_at' => date("Y-m-d H:i:s"),
                    'is_reconciled' => 1,
                ];
                // update the data
                $getDatas->update($proData);
                $messageType = 'success';
                $message = 'Reconciliation details successfully saved..';
            }

        } catch (\Exception $e) {
            // Catch any exception and return a response
            $messageType = 'error';
            $message = 'Failed to save reconciliation details .'.$e->getMessage();

        }
        $responseData = [
            'message' => $message,
            'messageType' => $messageType
        ];
        //echo $message;
        return response()->json($responseData);
    }

    public function disableBankReconciliation(Request $request,$pro_id){
        //BankRds
        //
        $messageType = '';
        $message = '';

        $getDatas = CustomerTransactions::where('id', $request->id)->first();

        //$getupdateData = CustomerTransactions::where('id', $request->id)-first();

        $updateproData = [
            'is_rd' => 1,
        ];
        $getDatas->update($updateproData);
        //CustomerTransactions::where('id', $request->id)->update(['is_rd' => 1]);

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

            $getCustomerPayments = CustomerPayments::find($getDatas->source_reference);

            if ($getCustomerPayments) {
                $updateDatas = [
                    'status' => 2,
                    'recon_bank_account_id' => 1,
                    'statement_no' => $insert_id,
                    'reconciled_by' => Auth::user()->id,
                    'is_reconciled' => 1,
                    'reconciled_at' => now()
                ];

                $getCustomerPayments->update($updateDatas);
            }

            if($insert_id >0){

                $getAccountBalanceDatas = CustomerTransactions::where('bank_account_id', $getDatas->bank_account_id)->where('status',1)->first();
                $cumalative_balance = $getAccountBalanceDatas->balance;
                $payment_amount = $getDatas->amount;

                $proDataCusTras = [
                    'customer_id' => $getDatas->customer_id,
                    'transaction_type' => 'rd',
                    'transaction_reference' => $rd_no,
                    'payment_method' => $getDatas->payment_method,
                    'reference' => $request->notes,
                    'source_reference' => $insert_id,
                    'bank_account_id' => $getDatas->bank_account_id,
                    'nominal_account_id' => $getDatas->nominal_account_id,
                    'transaction_date' => $request->date,
                    'effective_date' => $getDatas->effective_date,
                    'currency_id' => $getDatas->currency_id,
                    'currency_value' => $getDatas->currency_value,
                    'amount' => $payment_amount * (-1),
                    'credits' => 0,
                    'debits' => $payment_amount,
                    'balance' => $cumalative_balance - $payment_amount,
                    'customer_balance' => 0,
                    'created_by' => Auth::user()->id
                ];

                $addCustTraDatas = new CustomerTransactions();
                $addCustTraDatas->fill($proDataCusTras);
                $addCustTraDatas->save();

                $getCustomerCumalativeBalanceDatas = CustomerTransactions::where('customer_id', $getDatas->customer_id)->where('status',1)->first();
                $customer_cumalative_balance = $getCustomerCumalativeBalanceDatas->balance;
                $payment_currency_value = $getDatas->currency_value;

                $getNominalBalanceDatas = CustomerTransactions::where('bank_account_id', $getDatas->bank_account_id)->where('status',1)->first();
                $cumalative_balance_nominal = $getNominalBalanceDatas->balance;

                $proDataCusTras2 = [
                    'customer_id' => $getDatas->customer_id,
                    'transaction_type' => 'rd',
                    'transaction_reference' => $rd_no,
                    'payment_method' => $getDatas->payment_method,
                    'reference' => $request->notes,
                    'source_reference' => $insert_id,
                    'bank_account_id' => 0,
                    'nominal_account_id' => $getDatas->nominal_account_id,
                    'transaction_date' => $request->date,
                    'effective_date' => $getDatas->effective_date,
                    'currency_id' => $getDatas->currency_id,
                    'currency_value' => $getDatas->currency_value,
                    'amount' => ($payment_amount*$payment_currency_value),
                    'credits' => 0,
                    'debits' =>  $payment_amount*$payment_currency_value,
                    'balance' => ($cumalative_balance_nominal+($payment_amount*$payment_currency_value)),
                    'customer_balance' => ($customer_cumalative_balance+($payment_amount*$payment_currency_value)),
                    'created_by' => Auth::user()->id
                ];

                $addCustTraDatas2 = new CustomerTransactions();
                $addCustTraDatas2->fill($proDataCusTras2);
                $addCustTraDatas2->save();

                $getCustomerPaymentsAllocations = CustomerPaymentAllocations::where('payment_id', $getDatas->source_reference)->get();

                if(count($getCustomerPaymentsAllocations) > 0){
                    foreach ($getCustomerPaymentsAllocations as $paymentsAllocation) {
                        $getInvoice = Invoices::where('id', $paymentsAllocation->source_id)->first();

                        if($getInvoice && count($getInvoice)){
                            $allocated_customer_id = $getInvoice->customer_id;
                            $allocated_invoice_id = $getInvoice->id;
                            $allocated_invoice_no = $getInvoice->invoice_no;
                            $allocated_amount = $paymentsAllocation->allocated_amount;

                            // Update `customer_payment_allocations` table - set `status = 0`
                            CustomerPaymentAllocations::where('id', $paymentsAllocation->id)
                                        ->update(['status' => 0]);

                            // Update `invoices` table
                            $getInvoice->update([
                            'total_receipts' => $getInvoice->total_receipts - $allocated_amount,
                            'payments_due' => $getInvoice->payments_due + $allocated_amount,
                            'is_paid' => 0
                            ]);

                            // Log the audit trail
                            $logData = [
                            'Receipt_no' => $receipt_no,
                            'Invoice_no' => $allocated_invoice_no,
                            'Amount' => $allocated_amount,
                            ];

                            // Assuming you're using Laravel's built-in logging system
                            // \Log::info('RD Payment Allocation', [
                            // 'user_id' => auth()->id(),
                            // 'data' => json_encode($logData),
                            // 'customer_id' => $allocated_customer_id,
                            // 'invoice_no' => $allocated_invoice_no
                            // ]);
                        }
                    }
                }

            }

            $messageType = 'success';
            $message = 'You have successfully cancelled this Selected transaction..!';
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
