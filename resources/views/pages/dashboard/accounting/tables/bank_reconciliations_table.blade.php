@if ($fetchTableDetails->count() > 0)
    <small class="p-2">
        <table class="table table-stripped table-hover" width="100%">
            <thead>
                <tr>
                    <tr>
                        <td align="left"><strong>#</strong></td>
                        <td align="left"><strong>Date</strong></td>
                        <td align="left"><strong>Customer</strong></td>
                        <td align="left"><strong>Receipt No.</strong></td>
                        <td align="left"><strong>Pay Method</strong></td>
                        <td align="left"><strong>Bank Account</strong></td>
                        <td align="left"><strong>Transaction Amount</strong></td>
                        <td align="left"><strong>Reconciled By</strong></td>
                        <td align="left"><strong>Reconciled Amount</strong></td>
                        <td align="center"><strong>Action</strong></td>
                    </tr>
                </tr>
            </thead>
            <tbody>
                @php
                    $amount_total = 0;
                    $reconciled_total = 0;
                @endphp
                @foreach ($fetchTableDetails as $key => $fetchDetail)
                    @php
                        //bank_account_id
                        $getAllRoutePermisssions = \App\Models\RoutesPermissions::where('user_id', Auth::user()->id)->get();
                        $getAccountSubCategories = \App\Models\AcAccountSubCategories::where('id', $fetchDetail->sub_category_id)->first();
                        $getCustomerTransactions = \App\Models\CustomerTransactions::where('status', 1)
                                                ->where('nominal_account_id', $fetchDetail->id)
                                                ->selectRaw('
                                                    SUM(debits * currency_value) AS total_debits,
                                                    SUM(credits * currency_value) AS total_credits,
                                                    (SUM(debits * currency_value) - SUM(credits * currency_value)) AS balance
                                                ')
                                                ->first();

                        $getAllCustomers = \App\Models\Customers::where('id', $fetchDetail->customer_id)->first();
                        $getAllBankAccount = \App\Models\BankAccounts::where('id', $fetchDetail->bank_account_id)->first();
                        $getAllSystemUsers = \App\Models\SystemUsers::where('id', $fetchDetail->reconciled_by)->first();
                        $getAllCurrencySymbol = \App\Models\Currencies::where('is_base', 1)->where('status', 1)->first();


                        $currentRoute = request()->route()->getName();
                        $parentRoute = 'index.'.explode('.', $currentRoute)[0].'';

                        // $is_total_debits = ($getCustomerTransactions->total_debits)?number_format($getCustomerTransactions->total_debits,2):'0.00';
                        // $is_total_credits = ($getCustomerTransactions->total_credits)?number_format($getCustomerTransactions->total_credits,2):'0.00';
                        // $is_balance = ($getCustomerTransactions->balance)?number_format($getCustomerTransactions->balance,2):'0.00';

                        // $debit_total += $getCustomerTransactions->total_debits;
                        // $credit_total += $getCustomerTransactions->total_credits;

                        $subcategoryName = ($getAccountSubCategories && $getAccountSubCategories->name) ? $getAccountSubCategories->name : '';
                        $isControll = ($fetchDetail && $fetchDetail->is_control == 1) ? 'Yes' : 'No';
                        $isFloating = ($fetchDetail && $fetchDetail->is_floating == 1) ? 'Yes' : 'No';
                        $isStatus = ($fetchDetail && $fetchDetail->status == 1) ? 'Active' : 'Inactive';

                            $canDelete = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'delete' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });

                            $canPrivilege = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'privilege' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });

                            $canEdit = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'update' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });

                            $deleteRoutePath = 'bankreconciliations.deletebankreconciliation';
                            $updateRoutePath = 'bankreconciliations.updatebankreconciliation';

                            $deletebtn = '';
                            if ($canDelete) {
                                if($fetchDetail->is_rd == 1 || $fetchDetail->transaction_type=='rd'){
                                    $deletebtn .= '<button type="button" class="btn btn-xs btn-warning disabled" title="Cancel bank transaction">
                                                <span class="glyphicon glyphicon-retweet"></span> RD
                                            </button></div>';
                                }else{
                                    if($fetchDetail->amount > 0){
                                        $bank_account_name = isset($getAllBankAccount) ? ($getAllBankAccount->account_code ?? '') . ' - ' . ($getAllBankAccount->account_name ?? '') : '';
                                        $deletebtn = '<button type="button" class="btn btn-xs btn-warning cancelRecordButton" onclick="cancel_bank_transaction(' . $fetchDetail->id . ', \'' . $getAllCustomers->code.' - '.$getAllCustomers->company . '\', \'' . $fetchDetail->transaction_reference . '\', \'' .$getAllCurrencySymbol->symbol.' '.number_format($fetchDetail->amount,2) . '\', \'' . $fetchDetail->payment_method . '\', \'' . $bank_account_name . '\', \'' . $fetchDetail->reference . '\', \'' . $updateRoutePath . '\');" data-id="' . $fetchDetail->id . '" title="Cancel bank transaction"><span class="glyphicon glyphicon-retweet"></span> RD </button>';
                                    }else{
                                        $deletebtn .= '<button type="button" class="btn btn-xs btn-warning disabled" title="Cancel bank transaction">
                                                <span class="glyphicon glyphicon-retweet"></span> RD
                                            </button></div>';
                                    }
                                }

                            }

                            $editButton = '';
                            if ($canEdit) {
                                if($fetchDetail->is_rd == 1 || $fetchDetail->transaction_type=='rd'){
                                    $deletebtn .= '<div class="btn-group"><button type="button" class="btn btn-xs btn-success disabled" title="Reconcile bank transaction">
                                                        <span class="glyphicon glyphicon-ok"></span> Recon
                                                    </button>';
                                }else{
                                    $editButton = '<button type="button" class="btn btn-xs btn-success" onclick="addReconciliation('.$fetchDetail->id.');" title="Reconcile bank transaction">
                                                            <span class="glyphicon glyphicon-ok"></span> Recon
                                                        </button>';
                                }
                            }

                            $amount_total += $fetchDetail->amount;
                            $reconciled_total += $fetchDetail->amount_received;
                    @endphp

                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $fetchDetail->transaction_date }}</td>
                        <td><small>{{ $getAllCustomers->code.' - '.$getAllCustomers->company }}</small></td>
                        <td>{{ $fetchDetail->transaction_reference}}<br/><small>{{ $fetchDetail->transaction_type}}</small></td>
                        <td>{{ $fetchDetail->payment_method}}<br/><small>{{$fetchDetail->reference}}</small></td>
                        <td>{{ isset($getAllBankAccount) ? ($getAllBankAccount->account_code ?? '') . ' - ' . ($getAllBankAccount->account_name ?? '') : '' }}</td>
                        <td>{{ $getAllCurrencySymbol->symbol.' '.number_format($fetchDetail->amount,2) }}</td>
                        <td>{{ isset($getAllSystemUsers->full_name) ? $getAllSystemUsers->full_name : '' }}<br/><small>{{$fetchDetail->reconciled_at}} </small></td>
                        <td>{{ $getAllCurrencySymbol->symbol.' '.number_format($fetchDetail->amount_received,2) }}</td>
                        <td>
                            <div class="btn-group bank_recon">
                                @php echo ''.$editButton.' '.$deletebtn.''; @endphp
                            </div>
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>TOTALS</strong></td>
                    <td align="left"><strong>{{ number_format($amount_total,2) }}</strong></td>
                    <td align="left"></td>
                    <td align="left"><strong>{{ number_format($reconciled_total,2) }}</strong></td>
                    <td width="100" class="text-left"></td>
                </tr>
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
