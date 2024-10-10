@if ($fetchTableDetails->count() > 0)
    <small class="p-2">
        <table class="table table-stripped table-hover" width="100%">
            <thead>
                <tr>
                    <tr>
                        <td align="left"><strong>No.</strong></td>
                        <td align="left"><strong>Receipt No.</strong></td>
                        <td align="left"><strong>WHT Certificate No.</strong></td>
                        <td align="left"><strong>Date</strong></td>
                        <td align="left"><strong>Customer</strong></td>
                        <td align="left"><strong>Bank Account</strong></td>
                        <td align="left"><strong>Amount</strong></td>
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
                        $getCustomerWhtAttachments = \App\Models\CustomerWhtAttachments::where('receipt_id','=', $fetchDetail->id)->where('status', 1)->first();


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

                            $canCreate = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'create' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });

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
                            //cuswhtcetificates.editwhtcetificate cuswhtcetificates.updatewhtcetificate cuswhtcetificates.addwhtcetificate
                            $createRoutePath = 'cuswhtcetificates.addwhtcetificate';
                            $deleteRoutePath = 'cuswhtcetificates.deletewhtcetificate';
                            $updateRoutePath = 'cuswhtcetificates.updatewhtcetificate';

                            $attachement_id = isset($getCustomerWhtAttachments->id)? $getCustomerWhtAttachments->id:0;
                            $receipt_id = ($fetchDetail->id)? $fetchDetail->id:0;
                            $fiscal_type = ($fetchDetail->type)? $fetchDetail->type:'';

                            $editButton = '';
                            if ($canEdit) {
                                $Type = $fetchDetail->status == 1 ? 'Add' : '';
                                $editButton .= '<button type="button" class="btn btn-xs btn-primary" onClick="uploadWhtReceipt(' . $attachement_id . ', \'' . $receipt_id. '\', \'' . $fiscal_type . '\', \'' . $createRoutePath . '\');" title="Add Attachment"><span class="glyphicon glyphicon-upload"></span></button>';
                            }else{
                                $editButton .= '<button type="button" class="btn btn-xs btn-primary" title="Add Attachement" disabled><span class="glyphicon glyphicon-upload"></span></button>';
                            }

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

                            // $editButton = '';
                            // if ($canEdit) {
                            //     if($fetchDetail->id > 0 && $fetchDetail->is_posted == 0){
                            //         $editButton .= '<button type="button" class="btn btn-xs btn-info" onClick="editCustomerReceipt('.$fetchDetail->id.');" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>';
                            //     }else{
                            //         $editButton .= '<button type="button" class="btn btn-xs btn-info" title="Edit" disabled><span class="glyphicon glyphicon-edit"></span></button>';
                            //     }
                            // }

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
                                <td>
                                    @if (isset($getCustomerWhtAttachments->file_name))
                                        <small><a href="{{ url('public/'.$getCustomerWhtAttachments->file_name) }}" target="_blank" download>{{ $fetchDetail->reference }}</a></small>
                                    @else
                                        <small>{{ $fetchDetail->reference }}</small>
                                    @endif
                                </td>
                                <td>{{ $fetchDetail->date ?? '***' }}</td>
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
                                <td class="tbl_row_width2" align="center">{!! $editButton !!}</td>
                            </tr>

                @endforeach

                <tr>
                    <td><small></small></td>
                    <td><small></small></td>
                    <td><small><small></td>
                    <td><small></small></td>
                    <td align="right" ><small><strong>TOTAL</strong></small></td>
                    <td align="right" colspan="3"><small><strong>{{ $currencySymbol->symbol }} {{ number_format($totalPayment,2) }}</strong></small></td>
                    <td><small></small></td>
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
