@if ($fetchTableDetails->count() > 0)
    <small class="p-2">
        <table class="table table-stripped table-hover" width="100%">
            <thead>
                <tr>
                    <tr>
                        <td align="left"><strong>No.</strong></td>
                        <td align="left"><strong>Date</strong></td>
                        <td align="left"><strong>Customer Name</strong></td>
                        <td align="left"><strong>VAS</strong></td>
                        <td align="left"><strong>Product</strong></td>
                        <td align="left"><strong>Qty</strong></td>
                        <td align="left"><strong>Contract End</strong></td>
                        <td align="left"><strong>Authorized By</strong></td>
                        <td align="left"><strong>Attach to</strong></td>
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

                        $getProducts = \App\Models\Products::where('id', $fetchDetail->product_id)
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

                        //$getAllBankAccount = \App\Models\BankAccounts::where('id', $fetchDetail->bank_account_id)->first();
                        $getAllSystemUsersApproved = \App\Models\SystemUsers::where('id', $fetchDetail->approved_by)->first();
                        $getAllCurrencySymbol = \App\Models\Currencies::where('is_base', 1)->where('status', 1)->first();
                        $getCustomerWhtAttachments = \App\Models\CustomerWhtAttachments::where('receipt_id','=', $fetchDetail->id)->where('status', 1)->first();
                        $getAllRoutePermisssions = \App\Models\RoutesPermissions::where('user_id', Auth::user()->id)->get();

                        $currentRoute = request()->route()->getName();
                        $parentRoute = 'index.'.explode('.', $currentRoute)[0].'';

                        //$subcategoryName = ($getAccountSubCategories && $getAccountSubCategories->name) ? $getAccountSubCategories->name : '';
                        //$isControll = ($fetchDetail && $fetchDetail->is_control == 1) ? 'Yes' : 'No';
                        //$isFloating = ($fetchDetail && $fetchDetail->is_floating == 1) ? 'Yes' : 'No';
                        //$isStatus = ($fetchDetail && $fetchDetail->status == 1) ? 'Active' : 'Inactive';

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

                            $createRoutePath = 'cusvas.addvas';
                            $deleteRoutePath = 'cusvas.deletevas';
                            $updateRoutePath = 'cusvas.updatevas';

                            $attachement_id = isset($getCustomerWhtAttachments->id)? $getCustomerWhtAttachments->id:0;
                            $receipt_id = ($fetchDetail->id)? $fetchDetail->id:0;
                            //$fiscal_type = ($fetchDetail->type)? $fetchDetail->type:'';

                            $editButton = '';
                            if ($canEdit) {
                                $Type = $fetchDetail->status == 1 ? 'Add' : '';
                                $editButton .= '<button type="button" class="btn btn-xs btn-primary" onClick="uploadFiscalReceipt(' . $attachement_id . ', \'' . $receipt_id. '\', \'' . $createRoutePath . '\');" title="Add Attachment"><span class="glyphicon glyphicon-upload"></span></button>';
                            }else{
                                $editButton .= '<button type="button" class="btn btn-xs btn-primary" title="Add Attachement" disabled><span class="glyphicon glyphicon-upload"></span></button>';
                            }

                            $deletebtn = '';
                            $activebtn = '';
                            if ($canDelete) {

                                //$acInType = $fetchDetail->active == 1 ? 'Disable' : 'Enable';
                               // $acInColor = $fetchDetail->active == 1 ? 'warning' : 'success';
                               // $acInIcon = $fetchDetail->active == 0 ? 'refresh' : 'remove';
                                $deleteType = $fetchDetail->status == 1 ? 'Delete' : '';

                                if($fetchDetail->id > 0 && $fetchDetail->status == 1){
                                    $deletebtn .= '<button type="button" class="btn btn-xs btn-danger" onClick="deleteRecord(' . $fetchDetail->id . ', \'' . $deleteRoutePath . '\', \'' . $deleteType . '\');" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>';
                                }else{
                                    $deletebtn .= '<button type="button" class="btn btn-xs btn-danger" title="Delete" disabled><span class="glyphicon glyphicon-trash"></span></button>';
                                }
                            }

                            $postButton = '';
                            if ($canPost) {
                                if($fetchDetail->id > 0 && $fetchDetail->status == 1){
                                    $postButton .= '
                                    <button type="button" class="btn btn-xs btn-warning" onclick="post_receipt('.$fetchDetail->id.');" title="Post Receipt" id="cr_post171834"><span class="glyphicon glyphicon-send"></span> Post</button>';
                                }
                            }

                            //$amount_total += $fetchDetail->payment;
                            //$reconciled_total += $fetchDetail->payment;
                    @endphp

                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $fetchDetail->start_date  ?? '***'}}</td>
                                <td>

                                    @if (isset($getAllCustomers,$getAllCustomers->code))
                                        {{ $getAllCustomers->code . ' - ' . $getAllCustomers->company }}
                                    @else
                                        {{ '**** ****' }}
                                    @endif

                                </td>
                                <td>{{ $fetchDetail->product_description ?? '***' }}</td>
                                <td>{{ $fetchDetail->product_description ?? '***' }}</td>
                                <td>{{ $fetchDetail->qty ?? '***' }}</td>
                                <td>{{ $fetchDetail->end_date ?? '0000-00-00' }}</td>
                                <td>
                                    {{ ($getAllSystemUsersApproved->full_name) ? $getAllSystemUsersApproved->full_name : '' }}
                                </td>
                                <td>
                                    {{ ($fetchDetail->attach) ? $fetchDetail->attach. ' ' .$fetchDetail->invoice_id : '' }}
                                </td>
                                <td class="tbl_row_width2" align="center">{!! $deletebtn !!}</td>
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
