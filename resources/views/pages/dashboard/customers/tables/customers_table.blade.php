@if ($fetchTableDetails->count() > 0)
    <small class="p-2">
        <table class="table table-stripped table-hover" width="100%">
            <thead>
                <tr>
                    <tr>
                        <td align="left"><strong>#</strong></td>
                        <td align="left"><strong>Code</strong></td>
                        <td align="left"><strong>Name</strong></td>
                        <td align="left"><strong>Group</strong></td>
                        <td align="left"><strong>Collection B</strong></td>
                        <td align="left"><strong>Territory</strong></td>
                        <td align="left"><strong>Status</strong></td>
                        <td align="left"><strong>Credit Limit</strong></td>
                        <td align="left"><strong>Balance</strong></td>
                        <td align="center" colspan="4"><strong>Action</strong></td>
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

                            $canView = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'read' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });

                            $deleteRoutePath = 'cuscustomers.deletecustomer';
                            $updateRoutePath = 'cuscustomers.updatecustomer';

                            $deletebtn = '';
                            $activebtn = '';
                            if ($canDelete) {

                                $acInType = $fetchDetail->active == 1 ? 'Disable' : 'Enable';
                                $acInColor = $fetchDetail->active == 1 ? 'warning' : 'success';
                                $acInIcon = $fetchDetail->active == 0 ? 'refresh' : 'remove';
                                $deleteType = $fetchDetail->status == 1 ? 'Delete' : '';

                                if($fetchDetail->id > 0){
                                    $activebtn .= '<button type="button" class="btn btn-xs btn-'.$acInColor.'" onclick="enable_disable_delete_customer(' . $fetchDetail->id . ', \'' . $deleteRoutePath . '\', \'' . $acInType . '\');" data-id="' . $fetchDetail->id . '" title="'.$acInType.'"><span class="glyphicon glyphicon-'.$acInIcon.'"></span> </button>';


                                    $deletebtn .= '<button type="button" class="btn btn-xs btn-danger" onClick="enable_disable_delete_customer(' . $fetchDetail->id . ', \'' . $deleteRoutePath . '\', \'' . $deleteType . '\');" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>';
                                }
                            }

                            $viewButton = '';
                            if ($canView) {
                                if($fetchDetail->id > 0){
                                    $viewButton .= '<button type="button" class="btn btn-xs btn-info mt-2" onClick="viewCustomerStatement('.$fetchDetail->id.',\''.$fetchDetail->email.'\');" title="View Statement"><span class="glyphicon glyphicon-time"></span> Statment
                                                    </button>
                                                    <button type="button" class="btn btn-xs btn-success mt-2" onClick="viewActivity('.$fetchDetail->id.');" title="View activity"><span class="glyphicon glyphicon-time"></span> Activity
                                                    </button>';
                                }
                            }

                            $editButton = '';
                            if ($canEdit) {
                                if($fetchDetail->id > 0){
                                    $editButton .= '<button type="button" class="btn btn-xs btn-info" onClick="editCustomer('.$fetchDetail->id.');" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>';
                                }
                            }

                            $amount_total += $fetchDetail->amount;
                            $reconciled_total += $fetchDetail->amount_received;

                            $tblbgcolor = ($fetchDetail->active == 0) ? 'tbl-bg-color1':''
                    @endphp

                    <tr class="{{ $tblbgcolor }}">
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <a class="btn btn-link" onclick="showCustomerProfile('{{ $fetchDetail->id }}')">
                                {{ $fetchDetail->code }}
                            </a>
                        </td>
                        <td>{{ $fetchDetail->company ?? '' }}</td>
                        <td>{{ $getProductCategories->name ?? '' }}</td>
                        <td>{{ $getCollectionBureaus->name ?? '' }}</td>
                        <td>{{ $getTerritories->name ?? '' }}</td>
                        <td>{{ $fetchDetail->active == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>{{ number_format($getTerritories->credit_limit,2) ?? '' }}</td>
                        <td>{{ number_format($getCustomerTransactions->balance,2)}}</td>
                        <td class="tb-w-100">{!! $viewButton !!}</td>
                        <td>{!! $editButton !!}</td>
                        <td>{!! $activebtn !!}</td>
                        <td>{!! $deletebtn !!}</td>
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
