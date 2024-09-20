@if ($fetchTableDetails->count() > 0)
    <small class="p-2">
        <table class="table table-stripped table-hover" width="100%">
            <thead>
                <tr>
                    <tr>
                        <td align="left"><strong>#</strong></td>
                        <td align="left"><strong>Date</strong></td>
                        <td align="left"><strong>Description</strong></td>
                        <td align="left"><strong>Reference</strong></td>
                        <td align="left"><strong>Customer</strong></td>
                        <td align="left"><strong>Debit</strong></td>
                        <td align="left"><strong>Credit</strong></td>
                        <td align="left"><strong>Balance</strong></td>
                    </tr>
                </tr>
            </thead>
            <tbody>
                @php
                    $debit_total = 0;
                    $credit_total = 0;
                @endphp
                @foreach ($fetchTableDetails as $key => $fetchDetail)

                @php
                    // Ensure values exist to avoid errors and accumulate totals
                    $debits = $fetchDetail->debits ?? 0;
                    $credits = $fetchDetail->credits ?? 0;
                    //$amount = $fetchDetail->amount ?? 0;
                    //$amount_received = $fetchDetail->amount_received ?? 0;
                    $currency_value = $fetchDetail->currency_value ?? 1;

                    // Update totals
                    $debit_total += $debits;
                    $credit_total += $credits;
                @endphp

                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $fetchDetail->transaction_date }}</td>
                    <td>{{ $fetchDetail->transaction_type }}</td>
                    <td>{{ $fetchDetail->transaction_reference }}</td>
                    <td>{{ $fetchDetail->customer_code . ' - ' . $fetchDetail->customer_company }}</td>
                    <td>{{ number_format($debits * $currency_value, 2) }}</td>
                    <td>{{ number_format($credits * $currency_value, 2) }}</td>
                    <td>{{ number_format(($fetchDetail->balance ?? 0) * $currency_value, 2) }}</td>
                </tr>

                @endforeach


                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>TOTALS</strong></td>
                    <td align="left"><strong>{{ number_format($debit_total,2) }}</strong></td>
                    <td align="left"><strong>{{ number_format($credit_total,2) }}</strong></td>
                    <td align="left"><strong>{{ number_format($debit_total - $credit_total,2) }}</strong></td>
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
