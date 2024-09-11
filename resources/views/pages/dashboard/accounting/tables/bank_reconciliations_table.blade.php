@if ($fetchTableDetails->count() > 0)
    <small class="p-2">
        <table class="table table-stripped table-hover" width="100%">
            <thead>
                <tr>
                    <td><strong>#</strong></td>
                    <td><strong>Code</strong></td>
                    <td><strong>Account Name</strong></td>
                    <td><strong>Category</strong></td>
                    <td><strong>Is Control</strong></td>
                    <td><strong>Is Floating</strong></td>
                    <td><strong>Status</strong></td>
                    <td><strong>Debit</strong></td>
                    <td><strong>Credit</strong></td>
                    <td><strong>Balance</strong></td>
                    <td><strong>Action</strong></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($fetchTableDetails as $key => $fetchDetail)
                    @php
                        $getAccountSubCategories = \App\Models\AcAccountSubCategories::where('id', $fetchDetail->sub_category_id)->first();
                        $getCustomerTransactions = \App\Models\CustomerTransactions::where('status', 1)
                                                ->where('nominal_account_id', $fetchDetail->id)
                                                ->selectRaw('
                                                    SUM(debits * currency_value) AS total_debits,
                                                    SUM(credits * currency_value) AS total_credits,
                                                    (SUM(debits * currency_value) - SUM(credits * currency_value)) AS balance
                                                ')
                                                ->first();

                        $debit_total += $getCustomerTransactions->total_debits;
                        $credit_total += $getCustomerTransactions->total_credits;

                        $is_total_debits = $getCustomerTransactions->total_debits ? number_format($getCustomerTransactions->total_debits, 2) : '0.00';
                        $is_total_credits = $getCustomerTransactions->total_credits ? number_format($getCustomerTransactions->total_credits, 2) : '0.00';
                        $is_balance = $getCustomerTransactions->balance ? number_format($getCustomerTransactions->balance, 2) : '0.00';
                    @endphp
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $fetchDetail->code }}</td>
                        <td>{{ $fetchDetail->name }}</td>
                        <td>{{ $getAccountSubCategories->name ?? '' }}</td>
                        <td>{{ $fetchDetail->is_control == 1 ? 'Yes' : 'No' }}</td>
                        <td>{{ $fetchDetail->is_floating == 1 ? 'Yes' : 'No' }}</td>
                        <td>{{ $fetchDetail->status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>{{ $is_total_debits }}</td>
                        <td>{{ $is_total_credits }}</td>
                        <td>{{ $is_balance }}</td>
                        <td><!-- Action Buttons (edit, delete, etc.) --></td>
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
