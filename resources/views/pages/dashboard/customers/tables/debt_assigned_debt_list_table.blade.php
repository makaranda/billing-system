@if ($fetchTableDetails->count() > 0)
    <small class="p-2">
        <table class="table table-stripped" id="table1" style="margin-bottom:0px;">
            <thead>
                <tr>
                    <td ><strong>#</strong></td>
                    <td ><strong>Customer Name</strong></td>
                    <td ><strong>Report Date</strong></td>
                    <td ><strong>Collection Date</strong></td>
                    <td align="left"><strong>Assigned</strong></td>
                    <td align="left"><strong>Collected</strong></td>
                    <td align="left"><strong>To Be Collected</strong></td>
                    <td align="left"><strong>Action</strong></td>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_customer_balance = 0;
                    $total_collected = 0;
                    $total_to_be_collected = 0;
                    $total_inactive_balance = 0;
                    $total_inactive_collected = 0;
                    $total_inactive_to_be_collected = 0;

                    // Fetch the first AcAccounts record with 'debtors_control' in the control_type
                    $getAcAccounts = \App\Models\AcAccounts::where('control_type', 'LIKE', '%debtors_control%')->first();

                    // Fetch all active system users
                    $system_users = \App\Models\SystemUsers::where('status', 1)->get();
                    $getAllRoutePermisssions = \App\Models\RoutesPermissions::where('user_id', Auth::user()->id)->get();

                    $currentRoute = request()->route()->getName();
                    $parentRoute = 'index.'.explode('.', $currentRoute)[0].'';

                    $canPost = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                        return $permission->permission_type == 'post' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                    });

                    $html = '';
                    $default_assigned_date = '';
                @endphp
                @php
                $html = '';
                $current_assigned_date = null;  // To track the current group by assigned_date
                $group_total_assigned = 0;
                $group_total_collected = 0;
                $group_total_to_be_collected = 0;
                $group_total_performance = 0;

                $keyCount = 0;
            @endphp

            @foreach ($fetchTableDetails as $key => $fetchDetail)
                @php
                    // Initialize variables for each row
                    if($fetchDetail->active == 1){
                        $row_color = '#ccc';
                        $active = "";
                    }else{
                        $row_color = '';
                        $active = ' <strong class="text text-danger">Inactive</strong>';
                        $total_inactive_balance += $fetchDetail->customer_balance;
                        $total_inactive_collected += $fetchDetail->collected;
                        $total_inactive_to_be_collected += $fetchDetail->to_be_collected;
                    }

                    $collected = 0;

                    $postButton = '';
                    if ($canPost) {
                            $postButton .= '
                            <button type="button" class="btn btn-xs btn-success" onclick="add_remarks('.$fetchDetail->assignment_id.');" title="Post Receipt"><span class="glyphicon glyphicon-star"></span> Remarks</button>';
                    }

                    $view_route =  route('cusdebtmanagement.viewdebtmanagements', ['debt_id' => $fetchDetail->assignment_id,'assign_date' => $fetchDetail->assigned_upto]);


                    $query = DB::table('customer_transactions')
                        ->select(DB::raw('SUM(credits) as credits'))
                        ->where('status', 1)
                        ->whereIn('transaction_type', ['receipt_transfer', 'customer_receipt']);
                    // Apply conditional filters based on the `$data` object
                    if (isset($fetchDetail->customer_id) && $fetchDetail->customer_id > 0) {
                        $query->where('customer_id', $fetchDetail->customer_id);
                    }

                    if (isset($get_assigned_upto) && !empty($get_assigned_upto)) {
                        $query->where('effective_date', '>=', $get_assigned_upto);
                    }

                    if (isset($fetchDetail->collection_date) && !empty($fetchDetail->collection_date)) {
                        $query->where('effective_date', '<=', $fetchDetail->collection_date);
                    }

                    // Execute the query and get the result
                    $result = $query->first();
                    $collected = $result->credits;
                    $to_be_collected = $fetchDetail->customer_balance - $collected;

                    $total_customer_balance += $fetchDetail->customer_balance;
                    $total_collected += $collected;
                    $total_to_be_collected += $to_be_collected;
                    ///$systemUsers = \App\Models\SystemUsers::where('status', 1)->where('id','=',$fetchDetail->user_id)->first();

                    $html .= '
                            <tr style="background-color:'.$row_color.';">
                                <td>' . ($key + 1) . '</td>
                                <td>' . $fetchDetail->code . " - " . $fetchDetail->company.''. $fetchDetail->active .'</td>
                                <td>' . $fetchDetail->assigned_upto . '</td>
                                <td>' . $fetchDetail->collection_date . '</td>
                                <td>' . number_format($fetchDetail->customer_balance, 2) . '</td>
                                <td>' . number_format($collected, 2) . '</td>
                                <td>' . number_format($to_be_collected, 2) . '</td>
                                <td>' . $postButton . ' </td>
                            </tr>';

                    $keyCount += $key + 1;
                @endphp
            @endforeach

            {!! $html !!}
            <!-- Output the remaining group totals after the last group -->

            </tbody>
            <tfoot>
            @if ($fetchTableDetails->count())
                <tr>
                    <td colspan="4"><strong>Total</strong></td>
                    <td align="right"><strong>{{ number_format($total_customer_balance, 2) }}</strong></td>
                    <td align="right"><strong>{{ number_format($total_collected, 2) }}</strong></td>
                    <td align="right"><strong>{{ number_format($total_to_be_collected, 2) }}</strong></td>
                    <td align="right"><strong></strong></td>
                </tr>
                <tr>
                    <td colspan="4"><strong>Inactive</strong></td>
                    <td align="right"><strong>{{ number_format($total_inactive_balance, 2) }}</strong></td>
                    <td align="right"><strong>{{ number_format($total_inactive_collected, 2) }}</strong></td>
                    <td align="right"><strong>{{ number_format($total_inactive_to_be_collected, 2) }}</strong></td>
                    <td align="right"><strong></strong></td>
                </tr>
            @endif
            </tfoot>
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
