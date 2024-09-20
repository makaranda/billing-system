@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Bank Reconcilliations</h3>
        <ul class="breadcrumbs mb-3">
          <li class="nav-home">
            <a href="{{ route('index.prepaid') }}">
              <i class="icon-home"></i>
            </a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item text-capitalize">
            <a href="#">Bank Reconcilliations</a>
          </li>
        </ul>
      </div>
        @php
            // $segments = explode('/', request()->path());
            // $lastSegment = end($segments);
            // $mainSegment = $segments[1];
            // $currentRouteName = Route::currentRouteName();
            // echo $remindersRoute;
        @endphp
        <div class="row">
            <div class="col-12 col-md-12">
                @if (Session::has('error'))
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div><i class="fa fa-ban mr-2"></i>Error</div>
                            </div>
                            <div class="col-12 col-md-12">
                                <p>{{ Session::get('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="d-md-12">
                            <div class="row">
                                <div class="col-12">
                                     <h1 class="text-uppercase">Bank Reconcilliations</h1>

                                     @if (count($routesPermissions) == 1)
                                            @if ($routesPermissions[0]->route == request()->route()->getName() && Auth::user()->privilege === $routesPermissions[0]->userType)
                                                @if($routesPermissions[0]->show == 1)
                                                    <div class="input-group date" id="datepicker">
                                                        <input type="text" class="form-control" id="date" placeholder="Date Of Birth" />
                                                        <span class="input-group-append">
                                                        <span class="input-group-text bg-light d-block">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        </span>
                                                    </div>
                                                @endif
                                            @endif
                                      @endif
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <span class="text-uppercase">Bank Reconcilliations Information</span>
                                        </div>
                                        <div class="panel panel-default p-3">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="input-group datepicker_field" id="datepicker1">
                                                                <input type='text' class="form-control" id="from_date" name="from_date" placeholder="Transactions From" />
                                                                <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="input-group datepicker_field" id="datepicker2">
                                                                <input type='text' class="form-control" id="to_date" name="to_date" placeholder="Transactions To" />
                                                                <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="receipt_no" id="receipt_no" placeholder="Receipt No." />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="reference" id="reference" placeholder="Reference" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select class="form-control" id="payment_method" name="payment_method">
                                                                <option value="">- Select Method -</option>
                                                                <option value="Cash">Cash</option>
                                                                <option value="Card">Card</option>
                                                                <option value="Cheque">Cheque</option>
                                                                <option value="Bank">Bank Transfer</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <select class="searchable form-control" id="bank_account_id" name="bank_account_id">
                                                                <option value="">- Select Bank Account -</option>
                                                                @foreach ($bankAccountsDetails as $bankAccountsDetail)
                                                                    <option value="{{ $bankAccountsDetail->id }}">{{ $bankAccountsDetail->account_name.' - '.$bankAccountsDetail->account_code }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select class="form-control" id="reconcile_status" name="reconcile_status">
                                                                <option value="">- Status -</option>
                                                                <option value="1">Reconciled</option>
                                                                <option value="0">To be Reconciled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <select class="searchable form-control" id="reconciled_by" name="reconciled_by">
                                                                <option value="">- Reconciled By -</option>
                                                                @foreach ($systemUsersDetails as $systemUsersDetail)
                                                                    <option value="{{ $systemUsersDetail->id }}">{{ $systemUsersDetail->full_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <button type="button" id="s_search" class="btn btn-primary form-control">
                                                                <span class="glyphicon glyphicon-serach"></span> Search</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <button type="button" id="s_reset" class="btn btn-default form-control">
                                                                <span class="glyphicon glyphicon-refresh"></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"><div class="col-md-12"><span id="table_list"></span></div></div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>


                </div>
            </div>
        </div>



    </div>
</div>




<div class="modal fade" id="addReconciliationModal" role="dialog">
    <div class="modal-dialog">
      	<!-- Modal content-->
      	<div class="modal-content">
	        <div class="modal-header">
                <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> ADD RECONCILIATION DETAILS</h4>
	            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
	        </div>
	        <div class="modal-body">
				<form id="frm_reconciliation_details" method="post">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group datepicker_field">
								<label for="update_date">Update Date</label>
						   		<div class="input-group" id="datepicker3">
								    <input type='text' class="form-control" id="update_date" name="update_date" value="{{ date("Y-m-d") }}" required />
								    <span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								    </span>
								</div>
							</div>
						</div>
					</div>
				   	<div class="row">
				   		<div class="col-md-6">
							<div class="form-group">
								<label for="statement_no">Statement No.</label>
						   		<input type="text" class="form-control" id="statement_no" name="statement_no" required >
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="update_amount">Amount Received</label>
						   		<input type="text" class="form-control" id="update_amount" name="update_amount" required >
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">
							CANCEL
							</button>
						</div>
						<div class="col-md-6">
							<button type="submit" class="btn btn-primary form-control" id="submit" name="submit">
							<span class="glyphicon glyphicon-floppy-saved"></span> CONFIRM & SAVE
							</button>
							<input type="hidden" id="transaction_id" name="transaction_id" />
						</div>
					</div>
				</form>
			</div>
		</div>
    </div>
</div>


  <!-- Cancel Bank Transaction Modal -->
  <div class="modal fade" id="cancel_bank_transaction_modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><span class="glyphicon glyphicon-list"></span> CANCEL BANK TRANSACTION</h4>
            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
        <form id="frm_cancel_bank_transaction" name="frm_cancel_bank_transaction" method="post">
        <div class="modal-body">
        	<div class="row">
        		<div class="col-md-8"><span id="cancel_customer"></span></div>
        		<div class="col-md-4"><span id="cancel_receipt_no"></span></div>
        	</div>
        	<div class="row">
        		<div class="col-md-8"><span id="cancel_amount"></span></div>
        		<div class="col-md-4"><span id="cancel_payment_method"></span></div>
        	</div>
        	<div class="row">
        		<div class="col-md-8"><span id="cancel_bank"></span></div>
        		<div class="col-md-4"><span id="cancel_reference"></span></div>
        	</div>
        	<hr/>
        	<div class="row">
        		<div class="col-md-6">
        			<div class="form-group datepicker_field">
						<label class="control-label required">Cancellation Date</label>
						<div class="input-group" id="datepicker3">
						    <input type='text' class="form-control" id="cancel_date" name="cancel_date" value="" />
						    <span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						    </span>
						</div>
					</div>
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-12">
        			<div class="form-group">
        				<label class="control-label required">Cancellation Notes</label>
        				<input type="text" class="form-control" name="cancel_notes" id="cancel_notes" required="required" />
        			</div>
        		</div>
        	</div>
        </div>
        <div class="modal-footer d-block">
        	<div class="row">
        		<div class="col-md-6 pl-0">
        			<div class="form-group">
        				<button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">CLOSE</button>
        			</div>
        		</div>
        		<div class="col-md-6 pr-0">
        			<div class="form-group">
        				<button type="submit" class="btn btn-primary form-control">SAVE</button>
        				<input type="hidden" name="cancel_transaction_id" id="cancel_transaction_id">
        			</div>
        		</div>
        	</div>
        </div>
    	</form>
      </div>

    </div>
  </div>


@endsection

@push('css')
    <link rel="stylesheet" href="{{ url('public/assets/css/paging.css') }}">
    <style>

    </style>
@endpush

@push('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/alfrcr/paginathing/dist/paginathing.min.js"
></script>
<script>
    $(function () {
        $("#from_date").datepicker({
            autoclose: true,
            orientation: "bottom"
        });
        $("#to_date").datepicker({
            autoclose: true,
            orientation: "bottom"
        });
        $("#cancel_date").datepicker({
            autoclose: true,
            orientation: "bottom"
        });

        $("#update_date").datepicker({
            autoclose: true,
            orientation: "bottom"
        });
    });

    $.fn.datepicker.dates["en"] = {
        days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
        months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        today: "Today",
        clear: "Clear",
        format: "yyyy-mm-dd",
        titleFormat: "MM yyyy" /* Leverages same syntax as 'format' */,
        weekStart: 0,
    };

    $('.addAccountButton').on('click',function(){
        $('#frm_add_account').parsley().reset();
        $('#frm_add_account')[0].reset();

        $('#edit_id').val('');
        $('#form_type').val('nominalaccounts.addnominalaccount');
    });

    $('#s_reset').click(function(){
        $('#from_date').val("");
        $('#to_date').val("");
        $('#receipt_no').val("");
        $('#reference').val("");
        $('#payment_method').val("").change();
        $('#bank_account_id').val("").change();
        $('#reconcile_status').val("").change();
        $('#reconciled_by').val("").change();

        listTableDatas();
    });

    $('#s_search').click(function(){
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var bank_account_id = $('#bank_account_id').val();
        var reconcile_status = $('#reconcile_status').val();
        var payment_method = $('#payment_method').val();
        var receipt_no = $('#receipt_no').val();
        var reference = $('#reference').val();
        var reconciled_by = $('#reconciled_by').val();

        listTableDatas(1,from_date, to_date, bank_account_id, reconcile_status, receipt_no,
        payment_method, reference, reconciled_by);
    });

    function cancel_bank_transaction(id, customer, receipt_no, amount, payment_method, bank, reference){
        // CLEAR OLD VALUES
        $('#cancel_transaction_id').val("");
        $('#cancel_customer').html("");
        $('#cancel_receipt_no').html("");
        $('#cancel_amount').html("");
        $('#cancel_payment_method').html("");
        $('#cancel_reference').html("");

        // SET NEW VALUES
        $('#cancel_transaction_id').val(id);
        $('#cancel_customer').html("<strong>CUSTOMER: </strong>" + customer);
        $('#cancel_receipt_no').html("<strong>RECEIPT NO: </strong>" + receipt_no);
        $('#cancel_amount').html("<strong>AMOUNT: </strong>" + amount);
        $('#cancel_payment_method').html("<strong>METHOD: </strong>" + payment_method);
        $('#cancel_bank').html("<strong>BANK: </strong>" + bank);
        $('#cancel_reference').html("<strong>REFERENCE: </strong>" + reference);
        $('#cancel_bank_transaction_modal').modal('show');
    }

    function addReconciliation(id){
        $('#addReconciliationModal #transaction_id').val(id);
        $('#addReconciliationModal').modal('show');
    }
    $('#frm_reconciliation_details').parsley();
    $('#frm_reconciliation_details').on('submit',function(event){
        event.preventDefault();

        var id = $('#addReconciliationModal #transaction_id').val();
        var update_date = $('#addReconciliationModal #update_date').val();
        var statement_no = $('#addReconciliationModal #statement_no').val();
        var update_amount = $('#addReconciliationModal #update_amount').val();

        form_type = '{{ route("bankreconciliations.updatebankreconciliation", ":id") }}';
        form_type = form_type.replace(':id', id);

        $.ajax({
            url : form_type,
            cache: false,
            data: {_token: '{{ csrf_token() }}','id':id,'update_date':update_date,'statement_no':statement_no,
			'update_amount':update_amount},
            type: 'POST',
            dataType: 'json',
            success : function(response) {
                $('#addReconciliationModal').modal('hide');
                //console.log(response);
                $('#frm_cancel_bank_transaction').parsley().reset();
                $('#frm_cancel_bank_transaction')[0].reset();

                Swal.fire({
                    position: "bottom-end",
                    icon: response.messageType === 'success' ? "success" : "error",
                    title: response.message != '' ? response.message : "",
                    showConfirmButton: false,
                    timer: response.messageType === 'success' ? 4000 : 2500
                });

                listTableDatas();
                $('#overlay').hide();
            },
            error: function(xhr, status, error) {
                console.log("Error getting Categories ! \n", xhr, status, error);
                $('#overlay').hide();
            }
        });
    });

    $('#frm_cancel_bank_transaction').parsley();
    $('#frm_cancel_bank_transaction').on('submit',function(event){
        event.preventDefault();
        $('#overlay').show();
        var id = $('#cancel_transaction_id').val();
        var date = $('#cancel_date').val();
        var notes = $('#cancel_notes').val();
        var form_type = '';
        form_type = '{{ route("bankreconciliations.disablebankreconciliation", ":id") }}';
        form_type = form_type.replace(':id', id);
        $.ajax({
            url : form_type,
            cache: false,
            data: {_token: '{{ csrf_token() }}','id':id,'date':date,'notes':notes},
            type: 'POST',
            dataType: 'json',
            success : function(response) {
                $('#cancel_bank_transaction_modal').modal('hide');
                console.log(response);
                $('#frm_cancel_bank_transaction').parsley().reset();
                $('#frm_cancel_bank_transaction')[0].reset();
                Swal.fire({
                    position: "bottom-end",
                    icon: response.messageType === 'success' ? "success" : "error",
                    title: response.message != '' ? response.message : "",
                    showConfirmButton: false,
                    timer: response.messageType === 'success' ? 4000 : 2500
                });
                listTableDatas();
                $('#overlay').hide();
            },
            error: function(xhr, status, error) {
                console.log("Error getting Categories ! \n", xhr, status, error);
                $('#overlay').hide();
            }
        });
    });
    //cuscustomers.fetchcustomers
    listTableDatas();

    // Existing function with the `page` parameter for pagination
    function listTableDatas(page=1, from_date=null, to_date=null, bank_account_id=0, status=null,receipt_no=null, payment_method=null, reference=null, reconciled_by=0) {
        $('#overlay').show();
        $.ajax({
            url: "{{ route('bankreconciliations.fetchbankreconciliations') }}",
            cache: false,
            data: {
                _token: '{{ csrf_token() }}', 'page':page, 'from_date':from_date,'to_date':to_date,'bank_account_id':bank_account_id,
    'status':status, 'receipt_no':receipt_no, 'payment_method':payment_method, 'reference':reference,
    'reconciled_by':reconciled_by,'order':'is_reconciled ASC'
            },
            type: 'GET',
            success: function (response) {
                $('#overlay').hide();
                $('#table_list').html(response.html);
                // Re-bind the click event for pagination links after new content is loaded
                bindPaginationLinks();
            },
            error: function (xhr, status, error) {
                console.log("Error fetching data!", xhr, status, error);
                $('#overlay').hide();
            }
        });
    }

    // Function to handle pagination link clicks
    function bindPaginationLinks() {
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1]; // Get the page number
            listTableDatas(page,null, null, 0, null, null, null, null,0); // Call the function with the page number
        });
    }

    // Call the function initially
    bindPaginationLinks();
</script>
@endpush

