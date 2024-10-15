@if ($fetchTableDetails->count() > 0)
    <small class="p-2">
        <table class="table" width="100%">
            <thead>
            <tr>
            <td width="5%"><strong>#</strong></td>
            <td width="10%"><strong>C.Note No.</strong></td>
            <td width="10%"><strong>Date</strong></td>
            <td width="20%"><strong>Customer</strong></td>
            <td width="15%" align="right"><strong>Unallocated</strong></td>
            <td width="15%" align="right"><strong>Amount</strong></td>
            <td width="10%" align="right"><strong>Status</strong></td>
            <td width="15%" align="right"><strong>Action</strong></td>
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


                            $canRead = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'read' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });

                            $deleteRoutePath = 'cuscreditnotes.deletecuscreditnote';


                            $readButton = '';
                            if ($canRead) {
                                $readButton = '<button type="button" class="btn btn-xs btn-info" onclick="editRecord('.$fetchDetail->id.');">
                                                            <span class="glyphicon glyphicon-open"></span>
                                                        </button>';
                            }

                            $createRoutePath = 'fiscalreceiptupload.addfiscalreceipt';
                            $deleteRoutePath = 'fiscalreceiptupload.deletefiscalreceipt';
                            $updateRoutePath = 'fiscalreceiptupload.updatefiscalreceipt';

                            $attachement_id = isset($getCustomerWhtAttachments->id)? $getCustomerWhtAttachments->id:0;
                            $receipt_id = ($fetchDetail->id)? $fetchDetail->id:0;
                            $fiscal_type = ($fetchDetail->type)? $fetchDetail->type:'';

                            $editButton = '';
                            if ($canEdit) {
                                $Type = $fetchDetail->status == 1 ? 'Add' : '';
                                $editButton .= '<button type="button" class="btn btn-xs btn-primary" onClick="uploadFiscalReceipt(' . $attachement_id . ', \'' . $receipt_id. '\', \'' . $fiscal_type . '\', \'' . $createRoutePath . '\');" title="Add Attachment"><span class="glyphicon glyphicon-upload"></span></button>';
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

                            $customer_code = "***";
                            $customer_name = "***";
                            $getAllCustomers = \App\Models\Customers::where('id', $fetchDetail->customer_id)->get();
                            if(isset($getAllCustomers->id)){
                                $customer_code = $getAllCustomers->code;
                                $customer_name = $getAllCustomers->company;
                            }
                            $is_posted = $fetchDetail->is_posted;
                            $is_allocated = $fetchDetail->is_allocated;
                            $p_status = [1 => "Posted", 0 => "Draft"];
                            $unallocated_amount = ($fetchDetail->amount-$fetchDetail->allocated_amount);
                    @endphp

                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td style="vertical-align: middle;">{{ $fetchDetail->cdn_no }}</td>
                                <td style="vertical-align: middle;">{{ $fetchDetail->date }}</td>
                                <td style="vertical-align: middle;">{{ $customer_code." ".$customer_name }}</td>
                                <td style="vertical-align: middle;">{{ number_format($unallocated_amount,2) }}</td>
                                <td style="vertical-align: middle;">{{ number_format($fetchDetail->amount,2) }}</td>
                                <td style="vertical-align: right;">{{ $p_status[$is_posted] }}</td>

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
