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
                        <td align="right"><strong>Action</strong></td>
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

                            $canDisable = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'disable' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });

                            $canPrivilege = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'privilege' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });

                            $canEdit = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'update' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });


                            $disablebtn = '';
                            $disableRoutePath = 'nominalaccounts.disablenominalaccount';
                            if ($canDisable) {
                                $acInType = $fetchDetail->status == 1 ? 'inactive' : 'active';
                                $actitleType = $fetchDetail->status == 1 ? 'Click to Disable' : 'Click to Enable';
                                $acInColor = $fetchDetail->status == 1 ? 'warning' : 'success';
                                $acInIcon = $fetchDetail->status == 1 ? 'x' : 'arrow-repeat';

                                $disablebtn = '<button type="button" class="btn btn-xs btn-'.$acInColor.' disableRecordButton" onclick="disableRecord(' . $fetchDetail->id . ', \'' . $disableRoutePath . '\', \'' . $acInType . '\');" data-id="' . $fetchDetail->id . '" title="'.$actitleType.'"><i class="bi bi-'.$acInIcon.'"></i> </button>';
                            }

                            $deleteRoutePath = 'nominalaccounts.deletenominalaccount';
                            $deletebtn = '';
                            if ($canDelete) {
                                $acInType = $fetchDetail->status == 1 ? 'Delete' : 'Delete';
                                $acInColor = $fetchDetail->status == 1 ? 'danger' : 'danger';

                                $deletebtn = '<button type="button" class="btn btn-xs btn-'.$acInColor.' deleteRecordButton" onclick="deleteRecord(' . $fetchDetail->id . ', \'' . $deleteRoutePath . '\', \'' . $acInType . '\');" data-id="' . $fetchDetail->id . '" title="'.$acInType.'"><i class="glyphicon glyphicon-trash"></i> </button>';
                            }

                            $editButton = '';
                            if ($canEdit) {
                                $editButton = '<button type="button" class="btn btn-xs btn-info" onclick="editRecord('.$fetchDetail->id.');">
                                                            <i class="bi bi-pen"></i>
                                                        </button>';
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
                        <td>{{ number_format($fetchDetail->amount,2) }}</td>
                        <td>{{ isset($getAllSystemUsers->full_name) ? $getAllSystemUsers->full_name : '' }}<br/><small>{{$fetchDetail->reconciled_at}} </small></td>
                        <td>{{ number_format($fetchDetail->amount_received,2) }}</td>
                        <td>
                            @php echo ''.$editButton.' '.$disablebtn.' '.$deletebtn.''; @endphp
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
