@if ($fetchTableDetails->count() > 0)
    <small class="p-2">
        <table class="table" width="100%">
            <thead>
                <tr>
                    <td width="5%"><strong>#</strong></td>
                    <td width="20%"><strong>Debt Collector (User) Name</strong></td>
                    <td width="10%"><strong>Meeting Date</strong></td>
                    <td width="10%"><strong>Report Date</strong></td>
                    <td width="10%" align="right"><strong>Debt Assigned</strong></td>
                    <td width="10%" align="right"><strong>Debt Collected</strong></td>
                    <td width="10%" align="right"><strong>To Be Collected</strong></td>
                    <td width="10%" align="right"><strong>Performance</strong></td>
                    <td width="5%"></td>
                    <td width="10%" align="right"><strong>Action</strong></td>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_assigned = 0;
                    $total_collected = 0;
                    $amount_total = 0;
                    $reconciled_total = 0;

                    // Fetch the first AcAccounts record with 'debtors_control' in the control_type
                    $getAcAccounts = \App\Models\AcAccounts::where('control_type', 'LIKE', '%debtors_control%')->first();

                    // Fetch all active system users
                    $system_users = \App\Models\SystemUsers::where('status', 1)->get();

                    // Properly assign debtors control account, fallback to 0 if not found
                    $debtors_control_account = $getAcAccounts ? $getAcAccounts->id : 0;

                    // Initialize an array to store system users
                    $system_users_array = [];

                    // Populate system_users_array if there are system users
                    if ($system_users->isNotEmpty()) {
                        foreach ($system_users as $user) {
                            $system_users_array[$user->id] = $user;
                        }
                    }

                    $html = '';

                @endphp
                @foreach ($fetchTableDetails as $key => $fetchDetail)
                    @php

                        $default_assigned_date = '';
                        $assigned_date = $fetchDetail->assigned_date;
                        $total_performance = 0;
                        if($key>1){
                            if($default_assigned_date!=$assigned_date){
                                if ($total_assigned > 0) {
                                    $total_performance = ($total_collected / $total_assigned) * 100;
                                }

                                $html .= '<tr>
                                        <td><strong>#</strong></td>
                                        <td><strong></strong></td>
                                        <td><strong></strong></td>
                                        <td><strong>TOTALS</strong></td>
                                        <td align="right"><strong>'.number_format($total_assigned,2).'</strong></td>
                                        <td align="right"><strong>'.number_format($total_collected,2).'</strong></td>
                                        <td align="right"><strong>'.number_format($total_assigned-$total_collected,2).'</strong></td>
                                        <td align="right"><strong>'.number_format($total_performance,2).'%</strong></td>
                                        <td align="right"><strong></strong></td>
                                        <td align="right"><strong></strong></td>
                                    </tr>';
                                $total_assigned = 0;
                                $total_collected = 0;
                            }
                        }

                        $debt_collector_name = $fetchDetail->user_id;
                        if(isset($fetchDetail->user_id) && $fetchDetail->user_id>0){
                            if(array_key_exists($fetchDetail->user_id, $system_users_array)){
                                $debt_collector_name = $system_users_array[$fetchDetail->user_id]['full_name'];
                            }
                        }


                        // $assigned = 0;
                        // if(isset($fetchDetail->user_id) && $fetchDetail->user_id>0 && $debtors_control_account>0){
                        //     $datavalues = new dataValues();
                        //     $datavalues->debtors_control_account = $debtors_control_account;
                        //     $datavalues->user_id = $fetchDetail->user_id;
                        //     $datavalues->assigned_upto = $fetchDetail->assigned_upto;
                        //     $results = $debt_management_class->get_assigned_debts_totals($datavalues);
                        //     if(isset($results['result']) && $results['result']==true){
                        //         $assigned = $results['result'][0]['customer_balance'];
                        //     }
                        // }

                        // $collected = 0;
                        // if(isset($fetchDetail->user_id) && $fetchDetail->user_id>0 && $debtors_control_account>0){

                        //     $datavalues = new dataValues();
                        //     $datavalues->debtors_control_account = $debtors_control_account;
                        //     $datavalues->user_id = $fetchDetail->user_id;
                        //     $datavalues->assigned_upto = $fetchDetail->assigned_upto;
                        //     $results = $debt_management_class->get_assigned_debts($datavalues);
                        //     if(isset($results['result']) && $results['result']==true){
                        //         foreach($results['result'] as $result){

                        //             $datavalues = new dataValues();
                        //             $datavalues->customer_id = $result['customer_id'];
                        //             $datavalues->from_date = $fetchDetail->assigned_upto;
                        //             $datavalues->to_date = $result['collection_date'];
                        //             $datavalues->is_posted = 1;
                        //             $datavalues->status = 1;
                        //             $collected_line = $customer_class->get_customer_payments_total($datavalues);

                        //             $collected += $collected_line;
                        //         }
                        //     }
                        // }

                        //$to_be_collected = $assigned-$collected;
                        $getAllCustomers = \App\Models\Customers::where('id', $fetchDetail->customer_id)
                                                                ->where('status', 1)
                                                                ->first();
                        if(isset($getAllCustomers)){
                            $getAllCustomers = $getAllCustomers;
                        }else{
                            $getAllCustomers = '*****';
                        }

                        $getAllBankAccount = \App\Models\BankAccounts::where('id', $fetchDetail->bank_account_id)->first();
                        $getAllSystemUsers = \App\Models\SystemUsers::where('id', $fetchDetail->reconciled_by)->first();
                        $getAllCurrencySymbol = \App\Models\Currencies::where('is_base', 1)->where('status', 1)->first();
                        $getCustomerWhtAttachments = \App\Models\CustomerWhtAttachments::where('receipt_id','=', $fetchDetail->id)->where('status', 1)->first();
                        $getAllRoutePermisssions = \App\Models\RoutesPermissions::where('user_id', Auth::user()->id)->get();

                        $currentRoute = request()->route()->getName();
                        $parentRoute = 'index.'.explode('.', $currentRoute)[0].'';

                        //$debtors_control_account = $getAcAccounts ? $getAcAccounts->id : 0;
                        $user_id = $fetchDetail->user_id;
                        $assigned_upto = $fetchDetail->assigned_upto;

                        $query_cus_tran = \App\Models\CustomerTransactions::query();
                        $query_debt_assign = \App\Models\DebtAssignments::query();

                        $maxIdSubquery = \App\Models\CustomerTransactions::selectRaw('MAX(customer_transactions.id)')
                            ->join('debt_assignments', 'debt_assignments.customer_id', '=', 'customer_transactions.customer_id')
                            ->where('customer_transactions.transaction_date', '<=', DB::raw('debt_assignments.assigned_upto'))  // Transaction date <= assigned_upto
                            ->where('customer_transactions.nominal_account_id', $debtors_control_account)  // Match nominal account
                            ->where('debt_assignments.user_id', $user_id)  // Match user_id
                            ->where('debt_assignments.assigned_upto', $assigned_upto)  // Match assigned_upto
                            ->groupBy('customer_transactions.customer_id');

                        $query_cus_tran
                            ->selectRaw('SUM(customer_transactions.customer_balance) AS customer_balance')
                            ->whereIn('customer_transactions.id', $maxIdSubquery)
                            ->join('debt_assignments', 'debt_assignments.customer_id', '=', 'customer_transactions.customer_id')
                            ->where('customer_transactions.transaction_date', '<=', $assigned_upto)  // Ensure transaction date <= assigned_upto
                            ->where('customer_transactions.nominal_account_id', $debtors_control_account)  // Match nominal account again for the main query
                            ->where('debt_assignments.user_id', $user_id);  // Match user_id again for the main query

                        $assigned = $query_cus_tran->first();

                        // Step 1: Subquery to get MAX(id) for each customer
                        $maxIdSubquery2 = \App\Models\CustomerTransactions::selectRaw('MAX(customer_transactions.id)')
                            ->join('debt_assignments', 'debt_assignments.customer_id', '=', 'customer_transactions.customer_id')
                            ->where('customer_transactions.transaction_date', '<=', DB::raw('debt_assignments.assigned_upto'))  // Transaction date <= assigned_upto
                            ->where('customer_transactions.nominal_account_id', '=', $debtors_control_account)  // Match nominal account
                            ->where('debt_assignments.user_id', '=', $user_id)  // Match user_id
                            ->where('debt_assignments.assigned_upto', '=', $assigned_upto)  // Match assigned_upto
                            ->groupBy('customer_transactions.customer_id');

                        // Step 2: Main query to get SUM(customer_balance)
                        $customer_balance = \App\Models\CustomerTransactions::selectRaw('SUM(customer_transactions.customer_balance) AS customer_balance')
                            ->whereIn('customer_transactions.id', $maxIdSubquery2)
                            ->join('debt_assignments', 'debt_assignments.customer_id', '=', 'customer_transactions.customer_id')
                            ->where('customer_transactions.transaction_date', '<=', $assigned_upto)  // Ensure transaction date <= assigned_upto
                            ->where('customer_transactions.nominal_account_id', '=', $debtors_control_account)  // Match nominal account again
                            ->where('debt_assignments.user_id', '=', $user_id)  // Match user_id again
                            ->first();


                        // $is_total_debits = ($getCustomerTransactions->total_debits)?number_format($getCustomerTransactions->total_debits,2):'0.00';
                        // $is_total_credits = ($getCustomerTransactions->total_credits)?number_format($getCustomerTransactions->total_credits,2):'0.00';
                        // $is_balance = ($getCustomerTransactions->balance)?number_format($getCustomerTransactions->balance,2):'0.00';

                        // $debit_total += $getCustomerTransactions->total_debits;
                        // $credit_total += $getCustomerTransactions->total_credits;

                        //$subcategoryName = ($getAccountSubCategories && $getAccountSubCategories->name) ? $getAccountSubCategories->name : '';
                        $isControll = ($fetchDetail && $fetchDetail->is_control == 1) ? 'Yes' : 'No';
                        $isFloating = ($fetchDetail && $fetchDetail->is_floating == 1) ? 'Yes' : 'No';
                        $isStatus = ($fetchDetail && $fetchDetail->status == 1) ? 'Active' : 'Inactive';

                            $canCreate = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'create' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });

                            $canDelete = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'delete' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });

                            $canPrivilege = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'privilege' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });

                            $deleteRoutePath = 'cuscreditnotes.deletecuscreditnote';


                            $readButton = '';
                            // if ($canRead) {
                            //     $readButton = '<button type="button" class="btn btn-xs btn-info" onclick="editRecord('.$fetchDetail->id.');">
                            //                                 <span class="glyphicon glyphicon-open"></span>
                            //                             </button>';
                            // }

                            $createRoutePath = 'fiscalreceiptupload.addfiscalreceipt';
                            $deleteRoutePath = 'fiscalreceiptupload.deletefiscalreceipt';
                            $updateRoutePath = 'fiscalreceiptupload.updatefiscalreceipt';

                            $attachement_id = isset($getCustomerWhtAttachments->id)? $getCustomerWhtAttachments->id:0;
                            $receipt_id = ($fetchDetail->id)? $fetchDetail->id:0;
                            $fiscal_type = ($fetchDetail->type)? $fetchDetail->type:'';

                            $editButton = '';
                            // if ($canEdit) {
                            //     $Type = $fetchDetail->status == 1 ? 'Add' : '';
                            //     $editButton .= '<button type="button" class="btn btn-xs btn-primary" onClick="uploadFiscalReceipt(' . $attachement_id . ', \'' . $receipt_id. '\', \'' . $fiscal_type . '\', \'' . $createRoutePath . '\');" title="Add Attachment"><span class="glyphicon glyphicon-upload"></span></button>';
                            // }else{
                            //     $editButton .= '<button type="button" class="btn btn-xs btn-primary" title="Add Attachement" disabled><span class="glyphicon glyphicon-upload"></span></button>';
                            // }

                            $deletebtn = '';
                            $activebtn = '';
                            if ($canDelete) {

                                $acInType = $fetchDetail->active == 1 ? 'Disable' : 'Enable';
                                $acInColor = $fetchDetail->active == 1 ? 'warning' : 'success';
                                $acInIcon = $fetchDetail->active == 0 ? 'refresh' : 'remove';
                                $deleteType = $fetchDetail->status == 1 ? 'Delete' : '';

                                if($fetchDetail->id > 0 && $fetchDetail->is_posted == 0){
                                    $deletebtn .= '<button type="button" class="btn btn-xs btn-danger" onClick="deleteCustomerReceipt(' . $fetchDetail->id . ', \'' . $deleteRoutePath . '\', \'' . $deleteType . '\');" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>';
                                }else{
                                    $deletebtn .= '<button type="button" class="btn btn-xs btn-danger" title="Delete" disabled><span class="glyphicon glyphicon-trash"></span></button>';
                                }
                            }


                            $postButton = '';
                            // if ($canPost) {
                            //     if($fetchDetail->id > 0 && $fetchDetail->is_posted == 0){
                            //         $postButton .= '
                            //         <button type="button" class="btn btn-xs btn-warning" onclick="post_receipt('.$fetchDetail->id.');" title="Post Receipt" id="cr_post171834"><span class="glyphicon glyphicon-send"></span> Post</button>';
                            //     }
                            // }

                            $customer_code = "***";
                            $customer_name = "***";
                            $getAllCustomers = \App\Models\Customers::where('id', $fetchDetail->customer_id)->get();
                            if(isset($getAllCustomers->id)){
                                $customer_code = $getAllCustomers->code;
                                $customer_name = $getAllCustomers->company;
                            }
                            $unallocated_amount = 0;

                            $assigned = ($assigned->customer_balance)?$assigned->customer_balance:0;
                            $collected = ($customer_balance->customer_balance)?$customer_balance->customer_balance:0;
                    @endphp

                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td style="vertical-align: middle;">{{ $fetchDetail->cdn_no }}</td>
                                <td style="vertical-align: middle;">{{ $fetchDetail->date }}</td>
                                <td style="vertical-align: middle;"></td>
                                <td style="vertical-align: middle;">{{ number_format($assigned,2) }}</td>
                                <td style="vertical-align: middle;">{{ number_format($collected,2) }}</td>
                                <td style="vertical-align: middle;">{{ number_format($fetchDetail->amount,2) }}</td>
                                <td style="vertical-align: right;"></td>

                                <td style="vertical-align: middle;">
                                    {!! $readButton !!}
                                </td>
                            </tr>
                @endforeach


            </tbody>
        </table>
    </small>

    <!-- Render Pagination Links -->
    <div class="pagination">
        {{ $fetchTableDetails->links() }}
    </div>
@else
    <h4>No Data found in the system!</h4>
@endif


@push('scripts')
<script>

</script>
@endpush
