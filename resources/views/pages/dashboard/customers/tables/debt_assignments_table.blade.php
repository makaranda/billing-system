@if ($fetchTableDetails->count() > 0)
    <small class="p-2">
        <table class="table" width="100%">
            <thead>
                <tr>
                    <td width="5%"><strong>#</strong></td>
                    <td width="20%"><strong>Debt Collector (User) Name</strong></td>
                    <td width="10%"><strong>Meeting Date</strong></td>
                    <td width="10%"><strong>Report Date</strong></td>
                    <td width="10%" align="left"><strong>Debt Assigned</strong></td>
                    <td width="10%" align="left"><strong>Debt Collected</strong></td>
                    <td width="10%" align="left"><strong>To Be Collected</strong></td>
                    <td width="5%" align="left"><strong>Performance</strong></td>
                    <td width="20%" align="left"><strong>Action</strong></td>
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
                    $getAllRoutePermisssions = \App\Models\RoutesPermissions::where('user_id', Auth::user()->id)->get();

                    $currentRoute = request()->route()->getName();
                    $parentRoute = 'index.'.explode('.', $currentRoute)[0].'';

                    $canRead = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                        return $permission->permission_type == 'read' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                    });

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
                    $assigned = 0;
                    $collected = 0;



                    $postButton = '';
                    if ($canPost) {
                            $postButton .= '
                            <button type="button" class="btn btn-xs btn-success" onclick="email_debts('.$fetchDetail->user_id.');" title="Post Receipt"><span class="glyphicon glyphicon-envelope"></span> Email</button>';
                    }

                    $view_route = route('cusdebtmanagement.viewdebtmanagements', [
                        'user_id' => $fetchDetail->user_id,
                        'assigned_upto' => $fetchDetail->assigned_upto
                    ]);

                    $readButton = '';
                    if ($canRead) {
                        $readButton .= '
                            <a href="' . $view_route . '" class="btn btn-xs btn-info" title="Post Receipt">
                                <span class="glyphicon glyphicon-chevron-right"></span> View Debts
                            </a>';
                    }

                    // Properly assign debtors control account, fallback to 0 if not found
                    $debtors_control_account = ($getAcAccounts->id) ? $getAcAccounts->id : 0;

                    // Initialize an array to store system users
                    $system_users_array = [];

                    // Populate system_users_array if there are system users
                    if ($system_users->isNotEmpty()) {
                        foreach ($system_users as $user) {
                            $system_users_array[$user->id] = $user;
                        }
                    }

                    // Check if we are still in the same assigned_date group
                    if ($current_assigned_date !== null && $current_assigned_date !== $fetchDetail->assigned_date) {
                        // Output the totals for the previous group
                        $html .= '
                        <tr>
                            <td colspan="4"><strong>TOTALS</strong></td>
                            <td align="right"><strong>' . number_format($group_total_assigned, 2) . '</strong></td>
                            <td align="right"><strong>' . number_format($group_total_collected, 2) . '</strong></td>
                            <td align="right"><strong>' . number_format($group_total_to_be_collected, 2) . '</strong></td>
                            <td align="right"><strong>' . number_format($group_total_performance, 2) . '%</strong></td>
                            <td align="right"><strong></strong></td>
                        </tr>';

                        // Reset group totals for the new group
                        $group_total_assigned = 0;
                        $group_total_collected = 0;
                        $group_total_to_be_collected = 0;
                        $group_total_performance = 0;
                    }

                    // Update current group assigned_date
                    $current_assigned_date = $fetchDetail->assigned_date;

                    // Calculate assigned debts total
                    $get_assigned_debts_totals = DB::table('customer_transactions as a')
                        ->select(DB::raw('SUM(a.customer_balance) AS customer_balance'))
                        ->whereIn('a.id', function ($query) use ($debtors_control_account, $fetchDetail) {
                            $query->select(DB::raw('MAX(customer_transactions.id)'))
                                ->from('customer_transactions')
                                ->join('debt_assignments', 'debt_assignments.customer_id', '=', 'customer_transactions.customer_id')
                                ->where('customer_transactions.transaction_date', '<=', DB::raw('debt_assignments.assigned_upto'))
                                ->where('customer_transactions.nominal_account_id', $debtors_control_account)
                                ->where('debt_assignments.user_id', $fetchDetail->user_id)
                                ->where('debt_assignments.assigned_upto', $fetchDetail->assigned_upto)
                                ->groupBy('customer_transactions.customer_id');
                        })
                        ->first();

                    // Calculate assigned and collected values
                    $assigned = ($get_assigned_debts_totals->customer_balance) ? $get_assigned_debts_totals->customer_balance : 0;

                    // Now fetch the collected debts
                    $get_assigned_debts = DB::table('customer_transactions as a')
                        ->select(
                            'a.customer_balance',
                            'a.customer_id',
                            'b.assigned_date',
                            'b.assigned_upto',
                            'b.collection_date',
                            'b.assignment_id'
                        )
                        ->join(DB::raw('(SELECT MAX(customer_transactions.id) AS id,
                                                debt_assignments.id AS assignment_id,
                                                debt_assignments.assigned_date,
                                                debt_assignments.assigned_upto,
                                                debt_assignments.collection_date
                                        FROM customer_transactions
                                        JOIN debt_assignments ON debt_assignments.customer_id = customer_transactions.customer_id
                                        WHERE customer_transactions.transaction_date <= debt_assignments.assigned_upto
                                        AND customer_transactions.nominal_account_id = ' . intval($debtors_control_account) . '
                                        AND debt_assignments.user_id = ' . intval($fetchDetail->user_id) . '
                                        AND debt_assignments.assigned_upto = \'' . $fetchDetail->assigned_upto . '\'
                                        GROUP BY customer_transactions.customer_id) as b'), 'a.id', '=', 'b.id')
                        ->get();

                    $collected = 0;
                    foreach ($get_assigned_debts as $getassigneddebtvalue) {
                        $collection_date = $getassigneddebtvalue->collection_date;
                        $assignedupto = $fetchDetail->assigned_upto;
                        $customerid = $fetchDetail->customer_id;

                        $query = DB::table('customer_transactions')
                            ->select(DB::raw('SUM(credits) as credits'))
                            ->where('status', 1)
                            ->whereIn('transaction_type', ['receipt_transfer', 'customer_receipt']);

                        if (isset($customerid) && $customerid > 0) {
                            $query->where('customer_id', $customerid);
                        }

                        if (isset($assignedupto) && !empty($assignedupto)) {
                            $query->where('effective_date', '>=', $assignedupto);
                        }

                        if (isset($collection_date) && !empty($collection_date)) {
                            $query->where('effective_date', '<=', $collection_date);
                        }

                        $result = $query->first();
                        $collected_line = isset($result->credits) ? $result->credits : 0;
                        $collected += $collected_line;
                    }

                    $to_be_collected = $assigned - $collected;
                    $performance = ($assigned > 0) ? ($collected / $assigned) * 100 : 0;

                    // Add to group totals
                    $group_total_assigned += $assigned;
                    $group_total_collected += $collected;
                    $group_total_to_be_collected += $to_be_collected;
                    $group_total_performance += ($assigned > 0) ? $performance : 0;
                    $systemUsers = \App\Models\SystemUsers::where('status', 1)->where('id','=',$fetchDetail->user_id)->first();
                    // Generate the HTML for this row
                    $html .= '
                    <tr>
                        <td>' . ($key + 1) . '</td>
                        <td>' . $systemUsers->full_name. '</td>
                        <td>' . $fetchDetail->assigned_date . '</td>
                        <td>' . $fetchDetail->assigned_upto . '</td>
                        <td>' . number_format($assigned, 2) . '</td>
                        <td>' . number_format($collected, 2) . '</td>
                        <td>' . number_format($to_be_collected, 2) . '</td>
                        <td>' . number_format($performance, 2) . '%</td>
                        <td>'.$postButton.' '.$readButton.' </td>
                    </tr>';

                    $keyCount += $key + 1;
                @endphp
            @endforeach

            {!! $html !!}
            <!-- Output the remaining group totals after the last group -->
            @if ($fetchTableDetails->count())
                <tr>
                    <td colspan="4"><strong>TOTALS</strong></td>
                    <td align="right"><strong>{{ number_format($group_total_assigned, 2) }}</strong></td>
                    <td align="right"><strong>{{ number_format($group_total_collected, 2) }}</strong></td>
                    <td align="right"><strong>{{ number_format($group_total_to_be_collected, 2) }}</strong></td>
                    <td align="right"><strong>{{ number_format($group_total_performance, 2) }}%</strong></td>
                    <td align="right"><strong></strong></td>
                </tr>
            @endif

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
