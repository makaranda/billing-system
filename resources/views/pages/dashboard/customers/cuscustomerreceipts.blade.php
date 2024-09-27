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
        <h4 class="modal-title"><span class="glyphicon glyphicon-copy"></span> ADD RECEIPT </h4>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> Close</button>
      </div>
      <div class="modal-body">
      	<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">ADD RECEIPTS |
						<?php if(isset($customer_code)) echo $customer_code." - ";?>
						<?php if(isset($customer_name)) echo $customer_name;?>

						<form method="post" class="text-right pull-right">
							<button type="submit" class="btn btn-xs btn-danger" name="close_customer_receipts">Close</button>
						</form>
					</div>
					<div class="panel-body">
						<div class="panel panel-default">
						<div class="panel-body">
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
											<label for="payment_date">Receipt Date</label>
											<div class="input-group" id="datepicker1">
											    <input type="text" class="form-control" id="payment_date" name="payment_date" value="{{ WORKING_DATE }}" required />
											    <span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
											    </span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="payment_method">Payment Method</label>
												<select class="form-control" name="payment_method" id="payment_method" required>
													<option value="">- SELECT -</option>
													<option value="cash">Cash</option>
													<option value="cheque">cheque</option>
													<option value="card">Card</option>
													<option value="bank">Bank Transfer</option>
													<option value="WHT">WHT</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label for="card_type">Card Type</label>
											<select class="form-control" id="card_type" name="card_type" disabled required>
											   	<option value="">- Credit Card Type -</option>
                                                @foreach ($getAllCardTypes as $cardType)
                                                    <option value="{{ $cardType->id }}">'.ucwords({{ $cardType->name }}).'</option>
                                                @endforeach

											</select>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="auth_number">Auth Number <span title="Auth number from credit card machine.">(?)</span></label>
												<input type="text" class="form-control" name="auth_number" id="auth_number" disabled="disabled" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="reference"><span id="reference_name">Reference</span></label>
												<input type="text" class="form-control" name="reference" id="reference" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Account Holder's Bank</label>
												<select name="account_holder_bank" id="account_holder_bank" class="form-control" required="required" disabled="disabled">
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
											<label>Currency</label>
											<select name="currency_id" id="currency_id" class="form-control" required="required">
                                                @foreach ($getAllcurrencies as $currency)
                                                    <option value="{{ $currency->id }}">{{ $currency->code }}</option>
                                                @endforeach
											</select>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Exchange Value</label>
												<div class="input-group">
													<input type="text" class="form-control" name="exchange_value" id="exchange_value" required="required" readonly="readonly" value="1" aria-describedby="exchange-addon">
													<span class="input-group-addon" id="exchange-addon" <?php //if($can_delete==1) echo 'onclick="enable_exchange_value();"';?>><span class="glyphicon glyphicon-user"></span></span>
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
												<label>Effected Amount ({{ $getCurrencySymbol }})</label>
												<input type="text" class="form-control" name="effected_payment" id="effected_payment" required>
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
														<button type="button" class="btn btn-default form-control" data-dismiss="modal" onclick="clear_inputs();"> CANCEL</button>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> Close</button>
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
					      				<button type="button" class="btn btn-default form-control" data-dismiss="modal">CANCEL</button>
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
    </script>
@endpush

