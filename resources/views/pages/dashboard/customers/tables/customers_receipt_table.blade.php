@if ($fetchTableDetails->count() > 0)
    <small class="p-2">
        <table class="table table-stripped table-hover" width="100%">
            <thead>
                <tr>
                    <tr>
                        <td align="left"><strong>No.</strong></td>
                        <td align="left"><strong>Receipt No.</strong></td>
                        <td align="left"><strong>Date</strong></td>
                        <td align="left"><strong>Pay Method</strong></td>
                        <td align="left"><strong>Customer</strong></td>
                        <td align="left"><strong>Bank Account</strong></td>
                        <td align="left"><strong>Amount</strong></td>
                        <td align="left"><strong>Reference</strong></td>
                        <td align="center" colspan="3"><strong>Action</strong></td>
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
                        $getTerritories = \App\Models\Territories::where('id', $fetchDetail->territory_id)->first();
                        $getProductCategories = \App\Models\ProductCategories::where('product_category_id', $fetchDetail->group_id)->first();
                        $getCollectionBureaus = \App\Models\CollectionBureaus::where('id', $fetchDetail->collection_bureau_id)->first();
                        $getAllRoutePermisssions = \App\Models\RoutesPermissions::where('user_id', Auth::user()->id)->get();
                        $getAccountSubCategories = \App\Models\AcAccountSubCategories::where('id', $fetchDetail->sub_category_id)->first();
                        $getCustomerTransactions = \App\Models\CustomerTransactions::where('status', 1)
                                                ->where('customer_id',$fetchDetail->id)
                                                ->where('nominal_account_id', 1100)
                                                ->selectRaw('SUM(amount*currency_value) AS balance')
                                                ->first();

                        $getRoomingList = \App\Models\RoomingList::where('id', $fetchDetail->guest_id)
                                                                ->where('status', 1)
                                                                ->first();

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

                            $canPost = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'post' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });

                            $deleteRoutePath = 'cuscustomerreceipts.deletecustomerreceipt';
                            $updateRoutePath = 'cuscustomerreceipts.updatecustomerreceipt';

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

                            $editButton = '';
                            if ($canEdit) {
                                if($fetchDetail->id > 0 && $fetchDetail->is_posted == 0){
                                    $editButton .= '<button type="button" class="btn btn-xs btn-info" onClick="editCustomerReceipt('.$fetchDetail->id.');" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>';
                                }else{
                                    $editButton .= '<button type="button" class="btn btn-xs btn-info" title="Edit" disabled><span class="glyphicon glyphicon-edit"></span></button>';
                                }
                            }

                            $postButton = '';
                            if ($canPost) {
                                if($fetchDetail->id > 0 && $fetchDetail->is_posted == 0){
                                    $postButton .= '
                                    <button type="button" class="btn btn-xs btn-warning" onclick="post_receipt('.$fetchDetail->id.');" title="Post Receipt" id="cr_post171834"><span class="glyphicon glyphicon-send"></span> Post</button>';
                                }
                            }

                            $amount_total += $fetchDetail->payment;
                            $reconciled_total += $fetchDetail->payment;
                    @endphp

                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <small>
                                        <a href="{{ route('cuscustomers.deletecustomer',$fetchDetail->id) }}" target="_blank">
                                            {{ $fetchDetail->receipt_no }}
                                        </a>
                                    </small>
                                </td>
                                <td>{{ $fetchDetail->date ?? '***' }}</td>
                                <td>{{ $fetchDetail->method ?? '***' }}</td>
                                <td>

                                    @if (isset($getAllCustomers,$getAllCustomers->code))
                                        {{ $getAllCustomers->code . ' - ' . $getAllCustomers->company }}
                                    @endif
                                        {{ '****' }}
                                    @if(!empty($getRoomingList->title))
                                        <br/><strong>Guest: </strong>{{ $getRoomingList->title }}
                                    @endif

                                </td>
                                <td>
                                    {{ ($getAllBankAccount->account_code) ? $getAllBankAccount->account_code . ' - ' . $getAllBankAccount->account_name : '' }}
                                </td>
                                <td>{{ number_format($fetchDetail->payment, 2) ?? '' }}</td>
                                <td>
                                    {!! ($fetchDetail->reference) ? $fetchDetail->private_note : $fetchDetail->reference . '<br/>' . $fetchDetail->private_note !!}
                                </td>
                                <td class="tbl_row_width2">{!! $postButton !!}</td>
                                <td class="tbl_row_width">{!! $editButton !!}</td>
                                <td class="tbl_row_width">{!! $deletebtn !!}</td>
                            </tr>

                @endforeach

                <tr>
                    <td><small></small></td>
                    <td><small></small></td>
                    <td><small><small></td>
                    <td><small></small></td>
                    <td><small></small></td>
                    <td><small><strong>PAGE TOTAL</strong></small></td>
                    <td align="right" colspan="2"><small><strong>{{ $currencySymbol->symbol }} {{ number_format($amount_total,2) }}</strong></small></td>
                    <td><small></small></td>
                    <td><small></small></td>
                    <td class="noprint"><small></small></td>
                </tr>

                <tr>
                    <td><small></small></td>
                    <td><small></small></td>
                    <td><small><small></td>
                    <td><small></small></td>
                    <td><small></small></td>
                    <td><small><strong>REPORT TOTAL</strong></small></td>
                    <td align="right" colspan="2"><small><strong>{{ $currencySymbol->symbol }} {{ number_format($totalPayment,2) }}</strong></small></td>
                    <td><small></small></td>
                    <td><small></small></td>
                    <td class="noprint"><small></small></td>
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
