@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Customer Receipts</h3>
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
            <a href="#">Customer Receipts</a>
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
                                     <h1 class="text-uppercase">Customer Receipts</h1>

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
                                            <span class="text-uppercase">Customers Receipts</span>
                                        </div>
                                        <div class="panel panel-default p-3">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                          <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <div class="input-group datepicker_field" id="datepicker2">
                                                                            <input type='text' class="form-control" id="s_date_from" name="s_date_from" placeholder="From Date" />
                                                                            <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <div class="input-group datepicker_field" id="datepicker3">
                                                                            <input type='text' class="form-control" id="s_date_to" name="s_date_to" placeholder="To Date" />
                                                                            <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" id="s_receipt_no" name="s_receipt_no" placeholder="Receipt No." />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <select class="form-control" name="s_pposted" id="s_pposted">
                                                                            <option value="">-Post Status-</option>
                                                                            <option value="1">Posted</option>
                                                                            <option value="0" selected>Non Posted</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <select class="form-control" name="s_pallocated" id="s_pallocated">
                                                                            <option value="">-Allocation Status-</option>
                                                                            <option value="1">Allocated</option>
                                                                            <option value="0">Non Allocated</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <select class="form-control" name="s_pmethod" id="s_pmethod">
                                                                            <option value="">- ALL METHODS -</option>
                                                                                @foreach (CONST_PAYMENT_METHODS_ALL as $key => $value)
                                                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                                                @endforeach

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <input type="hidden" id="s_customer_id" name="s_customer_id">
                                                                        <input type="text" class="form-control" id="s_customer_name" name="s_customer_name" placeholder="Search customer name" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <select class="form-control" id="s_bank_account_id" name="s_bank_account_id" required="required">
                                                                        <option value="">- Select Bank Account -</option>
                                                                        @foreach ($getAllBankAccounts as $bank_account)
                                                                            <option value="{{ $bank_account->id }}">{{ $bank_account->account_name }} - {{ $bank_account->account_code }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <div class="input-group datepicker_field" id="datepicker5">
                                                                            <input type='text' class="form-control" id="s_post_date_from" name="s_post_date_from" placeholder="POST From Date" />
                                                                            <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <div class="input-group datepicker_field" id="datepicker6">
                                                                            <input type='text' class="form-control" id="s_post_date_to" name="s_post_date_to" placeholder="POST To Date" />
                                                                            <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-primary form-control" title="Search" id="btn_search">Serach</button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-default form-control" id="btn_reset" title="Reset Search"><span class="glyphicon glyphicon-refresh"></span></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row"><div class="col-md-12"><span id="table_list">No customer Receipts !</span></div></div>
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

                    </div>


                </div>
            </div>
        </div>



    </div>
</div>




<!-- Confirm Modal -->
<div class="modal fade" id="ConfirmModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><span class="glyphicon glyphicon-exclamation-sign"></span> Confirm !</h4>
            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
      </div>

    </div>
  </div>

<div id="addReceiptModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> <span class="model-header-title">ADD RECEIPT</span> </h4>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> Close</button>
      </div>
      <div class="modal-body">
      	<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">ADD RECEIPTS |

						<form method="post" class="text-right pull-right">
							<button type="submit" class="btn btn-xs btn-danger" name="close_customer_receipts">Close</button>
						</form>
					</div>
					<div class="card-body">
						<div class="card">
						<div class="card-body">
							<form name="frm_add_payments" id="frm_add_payments" method="post">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="customer_name">Customer</label>
											<input type="text" class="form-control" name="customer_name" id="customer_name">
										</div>
										<input type="hidden" name="customer_id" id="customer_id" />
									</div>

								</div>
							<div class="row">
								<div class="col-md-6" style="background:#dfd;">
									<div class="row">
										<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="payment_date">Receipt Date</label>
                                                <div class="input-group datepicker_field" id="datepicker1">
                                                    <input type="text" class="form-control" id="payment_date" name="payment_date" value="{{ WORKING_DATE }}" required />
                                                    <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="payment_method">Payment Method</label>
												<select class="form-control" name="payment_method" id="payment_method" required>
													<option value="">- SELECT -</option>
                                                    @foreach (CONST_PAYMENT_METHODS_ALL as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
													{{-- <option value="cash">Cash</option>
													<option value="cheque">cheque</option>
													<option value="card">Card</option>
													<option value="bank">Bank Transfer</option>
													<option value="WHT">WHT</option> --}}
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="card_type">Card Type</label>
                                                <select class="form-control" id="card_type" name="card_type" disabled>
                                                    <option value="">- Credit Card Type -</option>
                                                    @foreach ($getAllCardTypes as $cardType)
                                                        <option value="{{ $cardType->id }}">{{ ucwords($cardType->name) }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="auth_number">Auth Number <span title="Auth number from credit card machine.">(?)</span></label>
												<input type="text" class="form-control" name="auth_number" id="auth_number" disabled="disabled">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="reference"><span id="reference_name">Reference</span></label>
												<input type="text" class="form-control" name="reference" id="reference">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Account Holder's Bank</label>
												<select name="account_holder_bank" id="account_holder_bank" class="form-control" disabled="disabled">
												<option value="">- Select Bank -</option>
                                                @foreach ($getAllBanks as $bank)
                                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                @endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6" style="background:#ddf;">
									<div class="row">
										<div class="col-md-6">
                                            <div class="form-group">
                                                <label>Currency</label>
                                                <select name="currency_id" id="currency_id" class="form-control" required="required">
                                                    @foreach ($getAllcurrencies as $currency)
                                                        <option value="{{ $currency->id }}">{{ $currency->code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
										</div>
                                        @if(isset($routepermissions['delete']) && $routepermissions['delete'] == 1)
                                            @php
                                                $exchange_addon = 'onclick="enable_exchange_value();"';
                                            @endphp
                                        @else
                                            @php
                                                $exchange_addon = '';
                                            @endphp
                                        @endif
										<div class="col-md-6">
											<div class="form-group">
												<label>Exchange Value</label>
												<div class="input-group datepicker_field">
													<input type="text" class="form-control" name="exchange_value" id="exchange_value" required="required" readonly="readonly" value="1" aria-describedby="exchange-addon">
													<span class="input-group-addon cursor-pointer"  id="exchange-addon" {!! $exchange_addon !!}><span class="glyphicon glyphicon-user"></span></span>
												</div>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="payment_amount">Receipt Amount</label>
												<input type="text" class="form-control" name="payment_amount" id="payment_amount" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Effected Amount ({{ $getCurrencySymbol[0]['symbol']??$getCurrencySymbol[0]['symbol'] }})</label>
												<input type="text" class="form-control" name="effected_payment" id="effected_payment">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label required">Bank Account</label>
												<select class="form-control" id="bank_account" name="bank_account" required="required">
													<option value="">- Select Bank Account -</option>
                                                    @foreach ($getAllBankAccounts as $bankAccount)
                                                        <option value="{{ $bankAccount->id }}">{{ $bankAccount->account_name.' - '.$bankAccount->account_code }}</option>
                                                    @endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6"></div>
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<button type="button" class="btn btn-default form-control" data-bs-dismiss="modal" onclick="clear_inputs();"> CANCEL</button>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<button type="submit" class="btn btn-primary form-control" id="btn_add_payment">ADD RECEIPT</button>
														<input type="hidden" name="edit_id" id="edit_id" />

													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							</form>
						</div>
						</div>
						<hr/>
						<div class="row">
							<div class="col-md-12">
								<div id="customer_payment_list"></div>
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


<div id="allocate_invoice_modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> Close</button>
        <h4 class="modal-title"><span class="glyphicon glyphicon-copy"></span> ALLOCATE INVOICES</h4>
      </div>
      <div class="modal-body">
      	<div>

			<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#allocate" aria-controls="allocate" role="tab" data-toggle="tab">
				<span class="glyphicon glyphicon-ok"></span> ALLOCATE</a></li>
			<li role="presentation"><a href="#unallocate" aria-controls="unallocate" role="tab" data-toggle="tab">
				<span class="glyphicon glyphicon-remove"></span> UNALLOCATE</a></li>
			</ul>


			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="allocate">
					<br/>
			      	<form method="post" id="frm_allocate_invoices" name="frm_allocate_invoices">
			      	<div class="row">
			      		<div class="col-md-6">
			      			<div class="form-group">
				      			<label>UNALLOCATED RECEIPT AMOUNT</label>
				      			<input name="unallocated_receipt_amount" id="unallocated_receipt_amount" class="form-control" value="0.00" readonly="readonly" />
				      		</div>
			      		</div>
			      		<div class="col-md-6">
			      			<div class="form-group">
				      			<label>TO BE ALLOCATED</label>
				      			<input name="amount_to_be_allocated" id="amount_to_be_allocated" class="form-control text-danger" value="0.00" readonly="readonly" />
				      		</div>
			      		</div>
			      		<div class="col-md-12">
			      			<div class="panel panel-default">
			      				<div class="panel-heading">INVOICES & DEBIT NOTES</div>
			      				<div class="panel-body">
			      					<div class="row">
			      						<div class="col-md-12" id="non_allocated_invoices_list"></div>
			      					</div>
			      				</div>
			      			</div>
			      		</div>
			      	</div>
			      	<div class="row">
			      		<div class="col-md-6">
			      		</div>
			      		<div class="col-md-6">
			      			<div class="row">
			      				<div class="col-md-6">
					      			<div class="form-group">
					      				<button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">CANCEL</button>
					      			</div>
					      		</div>
					      		<div class="col-md-6">
					      			<div class="form-group">
					      				<button type="submit" id="btn_allocate_invoices" class="btn btn-primary form-control">ALLOCATE</button>
					      				<input type="hidden" name="hidden_receipt_id" id="hidden_receipt_id">
					      			</div>
					      		</div>
					      	</div>
			      		</div>
			      	</div>
			      	</form>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="unallocate">
		    		<br/>
		    		<div class="panel panel-default">
		    			<div class="panel-heading">ALLOCATIONS FOR THE RECEIPT</div>
		    			<div class="panel-body">
		    				<div class="row">
	      						<div class="col-md-12" id="allocated_invoices_list"></div>
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

@endsection

@push('css')
    <style>

    </style>
@endpush

@push('scripts')
    <script>
    $(function () {
        $("#payment_date").datepicker({
            autoclose: true,
            orientation: "bottom"
        });
        $("#s_date_from").datepicker({
            autoclose: true,
            orientation: "bottom"
        });
        $("#s_date_to").datepicker({
            autoclose: true,
            orientation: "bottom"
        });
        $("#s_post_date_from").datepicker({
            autoclose: true,
            orientation: "bottom"
        });

        $("#s_post_date_to").datepicker({
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

//cuscustomerreceipts.fetchcustomerreceipts
//cuscustomerreceipts.editcustomerreceipt
//cuscustomerreceipts.addcustomerreceipt
//cuscustomerreceipts.updatecustomerreceipt
//cuscustomerreceipts.deletecustomerreceipt


    function deleteCustomerReceipt(id,route_path,type){
        $('#deleteModal').modal('show');

        $('#delete_record_id').val(id);
        $('#delete_record_form').val(route_path);
        $('#delete_record_type').val(type);

        //console.log(id+'-'+route_path+'-'+type);

        if(type == 'Delete'){
            $('.deleteModelTopic').text('Deactive Record');
            $('.deleteModelDesctiption').text('Are you sure to Delete this Record now...!!!');
            $('.deleteModelBtn').text('Delete');
            $('.deleteModelBtn').removeClass('btn-danger');
            $('.deleteModelBtn').addClass('btn-danger');
        }else{
            $('.deleteModelTopic').text('Active Record');
            $('.deleteModelDesctiption').text('Are you sure to active this Record now...!!!');
            $('.deleteModelBtn').text('Active');
            $('.deleteModelBtn').removeClass('btn-danger');
            $('.deleteModelBtn').addClass('btn-success');
        }
    }

    $('#deleteRecordForm').parsley();
        $('#deleteRecordForm').on('submit', function(event){
            event.preventDefault();
            $('#overlay').show();
            var delete_record_id = $('#delete_record_id').val();
            var form_type = $('#delete_record_form').val();

            let updateUrl = '{{ route("cuscustomerreceipts.deletecustomerreceipt", ":id") }}';
            updateUrl = updateUrl.replace(':id', delete_record_id);

            console.log('URL: '+updateUrl);
            $.ajax({
                url : updateUrl,
                cache: false,
                data: $(this).serialize() + '&_token={{ csrf_token() }}',
                type: 'POST',
                dataType: 'json',
                success : function(response) {
                    $('#deleteModal').modal('hide');
                    //console.log(response);
                    //var arr = data.split("|");
                    $('#deleteRecordForm').parsley().reset();
                    $('#deleteRecordForm')[0].reset();
                    Swal.fire({
                        position: "bottom-end",
                        icon: response.messageType === 'success' ? "success" : "error",
                        title: response.message,
                        showConfirmButton: false,
                        timer: response.messageType === 'success' ? 4000 : 2500
                    });
                    listTableDatas();
                    $('#overlay').hide();
                },
                error: function(xhr, status, error) {
                    //console.log("Error getting Categories ! \n", xhr, status, error);
                    $('#overlay').hide();
                }
            });
    });

$('#frm_add_payments').parsley();
    $('#frm_add_payments').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var edit_id = ($('#edit_id').val())?$('#edit_id').val():'';
        var form_type = '';

        if($('#form_type').val() == 'cuscustomerreceipts.editcustomerreceipt'){
            form_type = '{{ route("cuscustomerreceipts.updatecustomerreceipt", ":id") }}';
            form_type = form_type.replace(':id', edit_id);
        }else{
            form_type = '{{ route("cuscustomerreceipts.addcustomerreceipt") }}';
        }

        //console.log(form_type);
        $.ajax({
            url : form_type,
            cache: false,
            data: $(this).serialize() + '&_token={{ csrf_token() }}',
            type: 'POST',
            dataType: 'json',
            success : function(response) {
                $('#addReceiptModal').modal('hide');
                console.log(response);
                //var arr = data.split("|");
                $('#frm_add_payments').parsley().reset();
                $('#frm_add_payments')[0].reset();
                Swal.fire({
                    position: "bottom-end",
                    icon: response.messageType === 'success' ? "success" : "error",
                    title: response.message,
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

    function editCustomerReceipt(id){
        $('#overlay').show();

        $('#form_type').val('cuscustomerreceipts.editcustomerreceipt');
        $('#edit_id').val(id);

        let updateUrl = '{{ route("cuscustomerreceipts.editcustomerreceipt", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);

        $.ajax({
            url : updateUrl,
            cache: false,
            data: {' _token': '{{ csrf_token() }}','id':id},
            type: 'GET',
            dataType: 'json',
            success : function(response) {
                console.log(response);
                //console.log("Error getting Product !"+response);

                if(response.customer_receipts.id != ''){
                    // `branch_id`, `receipt_no`, `mcs_id`, `customer_id`, `bank_account_id`, `date`, `currency_id`, `currency_value`, `payment_amount`, `payment`, `method`, `bank_id`, `card_number`, `reference`, `card_type`, `auth_number`, `added_date`, `added_user`, `is_posted`, `posted_by`, `posted_date`, `preceipt_printed`, `allocated_amount`, `is_allocated`, `is_refund`, `refund_amount`, `created_at`, `updated_at`, `status`, `update_date`, `update_amount`, `recon_bank_account_id`, `statement_no`, `reconciled_by`, `reconciled_at`, `is_reconciled`, `is_exported`, `exported_by`, `exported_at`, `transaction_id`, `private_note`, `is_deposit`, `deposit_id`, `deposit_date`

                    // customer_name payment_date payment_method card_type auth_number reference  account_holder_bank
                    // currency_id exchange_value payment_amount effected_payment  bank_account
                    $('#addReceiptModal .model-header-title').text('ADD RECEIPT');
                    let cus_detail_company = (response.customer_details && response.customer_details.company != null)? response.customer_details.company: '';
                    $('#addReceiptModal #customer_name').val(cus_detail_company);
                    $('#addReceiptModal #payment_date').val(response.customer_receipts.date);
                    $('#addReceiptModal #payment_method').val(response.customer_receipts.method).change();
                    $('#addReceiptModal #card_type').val(response.customer_receipts.card_type).change();
                    $('#addReceiptModal #auth_number').val(response.customer_receipts.auth_number);
                    $('#addReceiptModal #reference').val(response.customer_receipts.reference);
                    $('#addReceiptModal #account_holder_bank').val(response.customer_receipts.bank_id).change();

                    $('#addReceiptModal #currency_id').val(response.customer_receipts.currency_id).change();
                    $('#addReceiptModal #exchange_value').val(response.customer_receipts.currency_value);
                    $('#addReceiptModal #payment_amount').val(response.customer_receipts.payment_amount);
                    $('#addReceiptModal #effected_payment').val('');
                    $('#addReceiptModal #bank_account').val(response.customer_receipts.bank_account_id).change();

                    $("#addReceiptModal #effected_payment").attr('readonly',true);
				    $("#addReceiptModal #payment_amount").attr('readonly',true);
                    $("#btn_add_payment").html("SAVE PAYMENT");

                    $('#addReceiptModal').modal('show');

                    $('html, div').animate({ scrollTop: 0 }, 'slow');
                }

                listTableDatas();
                $('#overlay').hide();
            },
            error: function(response) {
                //console.log("Error All ! \n"+response);
                $('#overlay').hide();
            }
        });
    }


    var selected_bank = "";

$('#card_type').change(function(){
	set_default_bank_selected();
});

var payment_method_handler = function(){
	$('#auth_number').val("");
	$('#reference').val("");
	$('#reference_name').html("Reference");
	$('#card_type').val("").change();
	$('#account_holder_bank').val("").change();

	$('#account_holder_bank').prop("disabled",true);
	$('#auth_number').prop("disabled",true);
	$('#card_type').prop("disabled",true);
	$('#reference').prop("required",true);

	var payment_method = $('#payment_method').val();
	if(payment_method=='cash'){
		$('#reference').prop("required",false);
	}
	else if(payment_method=='card'){
		$('#auth_number').prop("disabled",false);
		$('#card_type').prop("disabled",false);
		$('#reference_name').html("Card No. <small> ( Last 4 Digits )</smal>");
	}
	else if(payment_method=='cheque'){
		$('#account_holder_bank').prop("disabled",false);
		$('#reference_name').html("Cheque No.");
	}
	else if( payment_method=='bank'){
		$('#account_holder_bank').prop("disabled",false);
		$('#reference_name').html("Holder's Account No.");
	}
	else if( payment_method=='wht'){
		$('#reference_name').html("WHT Certificate No.");
	}
	else if( payment_method=='LPO'){
		$('#reference_name').html("LPO No.");
	}

	set_default_bank_selected();
}
$('#payment_method').bind("change",payment_method_handler);

//$('#currency_id').bind("change",currency_id_handler);


$('#exchange_value, #payment_amount').bind ("keyup input propertychange", function (e) {
	var exchange_value = $('#exchange_value').val();
	var payment_amount = $('#payment_amount').val();

	$('#effected_payment').val((parseFloat(0+exchange_value) * parseFloat(0+payment_amount)).toFixed(2));
});

$('#effected_payment').bind ("keyup input propertychange", function (e) {
	var exchange_value = $('#exchange_value').val();
	var effected_payment = $('#effected_payment').val();
	if(exchange_value>0) {} else exchange_value = 1;

	$('#payment_amount').val((parseFloat(0+effected_payment) / parseFloat(0+exchange_value)).toFixed(5));
});

function enable_exchange_value(){
	$('#exchange_value').prop("readonly",!$('#exchange_value').prop("readonly"));
}


$('#btn_search').click(function(e){
	var date_from = $('#s_date_from').val();
	var date_to = $('#s_date_to').val();
	var receipt_no = $('#s_receipt_no').val();
	var pmethod = $('#s_pmethod').val();
	var customer_id = $('#s_customer_id').val();
	var bank_account_id = $('#s_bank_account_id').val();
	var is_posted = $('#s_pposted').val();
	var is_allocated = $('#s_pallocated').val();
	var post_date_from = $('#s_post_date_from').val();
	var post_date_to = $('#s_post_date_to').val();

	listTableDatas(1, date_from, date_to, receipt_no, pmethod, customer_id, bank_account_id,is_posted,is_allocated, post_date_from, post_date_to);
});

$('#btn_reset').click(function(e){
	$('#s_date_from').val("");
	$('#s_date_to').val("");
	$('#s_receipt_no').val("");
	$('#s_pmethod').val("").change();
	$('#s_customer_id').val("").change();
	$('#s_bank_account_id').val("").change();
	$('#s_type').val("").change();

	listTableDatas();
});

$('#s_receipt_no').keyup(function(e){
	if(e.keyCode == 13){
		var date_from = $('#s_date_from').val();
		var date_to = $('#s_date_to').val();
		var receipt_no = $('#s_receipt_no').val();
		var pmethod = $('#s_pmethod').val();
		var customer_id = $('#s_customer_id').val();
		var bank_account_id = $('#s_bank_account_id').val();
		var is_posted = $('#s_pposted').val();
		var is_allocated = $('#s_pallocated').val();
		var post_date_from = $('#s_post_date_from').val();
		var post_date_to = $('#s_post_date_to').val();

		listTableDatas(1, date_from, date_to, receipt_no, pmethod, customer_id, bank_account_id,is_posted,is_allocated, post_date_from, post_date_to);
	}
});

function clear_inputs(){
	$("#btn_add_payment").html("ADD RECEIPT");
	$('#edit_id').val("");
	$('#payment_date').val("").change();
	$('#payment_method').val("").change();
	$('#reference').val("");
	$('#card_type').val("").change();
	$('#bank_account').val("").change();
	$('#account_holder_bank').val("").change();
	$('#auth_number').val("");
	$('#payment_amount').val("0.00");
	$('#effected_payment').val("0.00");
	$('#exchange_value').val("1");
	$('#currency_id').val($('#currency_id').find('option:first').val()).change();
}

$('#s_pmethod').on('change',function(){
//var currency_id_handler = function(){
    var currency_id = $('#currency_id').val();
    var payment_amount = parseFloat($('#payment_amount').val());

    // Handle NaN case for payment_amount
    payment_amount = isNaN(payment_amount) ? 0 : payment_amount;

    // Alert currency_id for debugging
    //alert(currency_id);
    console.log(currency_id+' - '+payment_amount);
	$.ajax({
		url : "{{ route('cuscustomerreceipts.getconvertedpaymentamount') }}",
		cache: false,
		data: {  _token: '{{ csrf_token() }}','currency_id':currency_id,'payment_amount':payment_amount },
		type: 'POST',
        dataType: 'json',
		success : function(data) {
            //
            console.log(data);

            var converted_value = 0;
            var currency_value = 1;
            var currency_symbol = "*";

            if (data.converted_value && data.converted_value > 0) {
                converted_value = data.converted_value;
            }
            if (data.currency_value && data.currency_value > 0) {
                currency_value = data.currency_value;
            }
            if (data.currency_symbol) {
                currency_symbol = data.currency_symbol;
            }

            if (currency_id == "{{ CURRENCY_ID ?? '' }}") {
                $('#payment_amount').val(converted_value.toFixed(2));
                $('#effected_payment').prop("readonly", true);
            } else {
                $('#payment_amount').val(converted_value.toFixed(5));
                $('#effected_payment').prop("readonly", false);
            }

            $('#exchange_value').val(currency_value);
            $('#effected_payment').val((currency_value * converted_value).toFixed(2));
            $('#payment_currency_symbol').html("( " + currency_symbol + " )");

		},
		error: function(data) {
			$('#errorMessage').html("Failed to get converted amount, Try again !");
			$('#errorModal').modal();
		}
	});

	set_default_bank_selected();
});

function set_default_bank_selected(){
	var payment_method = $('#payment_method').val();
	var currency_id = $('#currency_id').val();
	var card_type = $('#card_type').val();

    console.log(payment_method+' - '+currency_id+' - '+card_type);

	if(payment_method!="LPO" && payment_method!="lpo" && payment_method!="Lpo"){
		if(currency_id!='' && currency_id!=null && currency_id>0){
			$.ajax({
				url : "{{ route('cuscustomerreceipts.getdefaultbankpaymentmethod') }}",
				cache: false,
				data: {  _token: '{{ csrf_token() }}','payment_method':payment_method,'currency_id':currency_id,'card_type':card_type },
				type: 'POST',
                dataType: 'json',
				success : function(data) {
                    console.log(data);
                    // Assuming there's only one item in the result array
                    if (data.count > 0 && data.result.length > 0) {
                            var result = data.result[0]; // Get the first item from the result array

                            if (selected_bank && selected_bank > 0) {
                                $('#bank_account').val(selected_bank).change();
                                selected_bank = "";
                            } else {
                                if (result.bank_account_id && result.bank_account_id > 0) {
                                    $('#bank_account').val(result.bank_account_id).change();
                                } else {
                                    $('#bank_account').val("").change();
                                }
                            }

                            // Additional logging or actions
                            //console.log(result.bank_account_id);
                        } else {
                            // Handle case where no results are returned
                            $('#bank_account').val("").change();
                            console.log("No results found");
                        }
				},
				error: function(data) {
					$('#bank_account').val("").change();
					$('#errorMessage').html(JSON.stringify(data));
					$('#errorModal').modal();
				}
			});
		}
		else $('#bank_account').val("").change();
	}
	else $('#bank_account').val("").change();
}
    listTableDatas();

    function listTableDatas(page=1, date_from=null, date_to=null, receipt_no=null, pmethod=null,customer_id=null, bank_account_id=null, is_posted=null, is_allocated=null, post_date_from=null, post_date_to=null) {
        //alert();
        //console.log("THIS");
        $('#overlay').show();
        $.ajax({
                url : "{{ route('cuscustomerreceipts.fetchcustomerreceipts') }}",
                cache: false,
                data: { _token: '{{ csrf_token() }}','page':page, 'date_from':date_from, 'date_to':date_to, 'receipt_no':receipt_no,
		'method':pmethod, 'customer_id':customer_id, 'bank_account_id':bank_account_id,'is_posted':is_posted, 'is_allocated':is_allocated,'post_date_from':post_date_from,'post_date_to':post_date_to,'order':'ASC'},
                type: 'GET',
                success : function(response) {
                    //console.log('Success: '+data);
                    $('#overlay').hide();
                    $('#table_list').html(response.html);

                    bindPaginationLinks();
                },
                error: function(xhr, status, error) {
                    console.error("Error getting data!", xhr, status, error);
                    $('#overlay').hide();
                }
        });
    }

        // Function to handle pagination link clicks
    function bindPaginationLinks() {
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1]; // Get the page number
            //listTableDatas(page,null, null, 0, null, 0, 0, 1,null,null,null);
            listTableDatas(page);
        });
    }

    // Call the function initially
    bindPaginationLinks();

    </script>
@endpush

