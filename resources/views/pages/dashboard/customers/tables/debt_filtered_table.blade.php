@if ($results->count() > 0)
    <small class="p-2">
        <table class="table table-stripped" width="100%" id="table2">
            <thead>
                <tr>
                    <td width="5%"><strong>#</strong></td>
                    <td width="10%"><strong><button type="button" class="btn btn-success" id="btn_bulk_assign">Bulk Assign</button></strong></td>
                    <td width="20%"><strong>Customer Name</strong></td>
                    <td width="10%" align="left"><strong>Balance</strong></td>
                    <td width="10%" align="right"><strong>Action</strong></td>
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

                @endphp
                @foreach ($results as $key => $fetchDetail)
                    @php

                    @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><input type="checkbox" name="bulk_customer_ids[]" id="bulk_customer_ids{{ $fetchDetail->customer_id }}" value="{{ $fetchDetail->customer_id }}" class="cls_bulk_customer_ids"></td>
                                <td align="left"><strong><a onclick="showCustomerProfile({{ $fetchDetail->customer_id }})" href="#" title="Click here to see customer profile">{{ $fetchDetail->code }}</a> - {{ $fetchDetail->company }}</strong></td>
                                <td align="left"><strong>{{ number_format($fetchDetail->customer_balance, 2, '.', ',') }}</strong></td>
                                <td align="left"><strong><button class="btn btn-xs btn-info single-btn-1030" id="single-btn-1030" onclick="assign_selected_debt({{ $fetchDetail->customer_id }});"><span class="glyphicon glyphicon-check"></span> Assign</button></strong></td>
                            </tr>
                @endforeach


            </tbody>
        </table>
    </small>

    <!-- Render Pagination Links -->
    <div class="pagination">
        {{ $results->links() }}
    </div>
@else
    <h4>No Data found in the system!</h4>
@endif


@push('scripts')
<script>

</script>
@endpush
