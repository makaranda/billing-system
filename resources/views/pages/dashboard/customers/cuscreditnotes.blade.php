@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Credit Notes</h3>
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
            <a href="#">Credit Notes</a>
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
                                     <h1 class="text-uppercase">Credit Notes</h1>

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

                            @if (!session()->has('CUS_CN_ID'))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <span class="text-uppercase">Add Customer Credit Notes</span>
                                            @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                {{-- <button type="button" class="btn btn-xs btn-info pull-right ml-1 addArchiveButton" data-bs-toggle="modal" data-bs-target="#addArchiveModal" role="button">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                    Add Value Added Services
                                                </button> --}}
                                            @endif
                                        </div>
                                        <div class="panel panel-default p-3">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                          <div class="panel-body">

                                                            <form method="post" class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="cn_date">Credit Note Date</label>
                                                                        <div class="input-group datepicker_field" id="datepicker1">
                                                                            <input type="text" class="form-control" id="cn_date" name="cn_date" value="{{  WORKING_DATE }}" required />
                                                                            <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                              </div>
                                                              <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Select Customer</label>
                                                                        <select class="form-control searchable" id="customer_id" name="customer_id" required="required">
                                                                            <option value="">- Select Customer -</option>
                                                                            @foreach ($getAllCustomers as $customer)
                                                                                <option value="{{ $customer->id }}">{{ $customer->company.' - '.$customer->code }}</option>
                                                                            @endforeach

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 align-self-end">
                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-primary" name="submit">
                                                                            GO TO CREDIT NOTES <span class="glyphicon glyphicon-chevron-right"></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>

                                                          </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <span class="text-uppercase">Recently Added Credit Notes</span>
                                            @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                {{-- <button type="button" class="btn btn-xs btn-info pull-right ml-1 addArchiveButton" data-bs-toggle="modal" data-bs-target="#addArchiveModal" role="button">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                    Add Value Added Services
                                                </button> --}}
                                            @endif
                                        </div>
                                        <div class="row"><div class="col-md-12"><span id="table_list">No Customer Credit Notes available !</span></div></div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="row session_ccn">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <span class="text-uppercase">Add Credit Notes</span>
                                                </div>
                                                <div class="col-12 col-md-6 text-right">
                                                    {{ var_dump(session('CUS_CN_ID')) }}
                                                    @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                        <button type="button" style="margin:2px;" class="btn btn-primary btn-xs">
                                                            <span class="glyphicon glyphicon-print"></span> Print
                                                        </button>


                                                        <button type="button" style="margin:2px;" class="btn btn-warning btn-xs" onclick="post_credit_note();">
                                                                <span class="glyphicon glyphicon-send"></span> Post
                                                        </button>

                                                        <button type="button" style="margin:2px;" class="btn btn-success btn-xs" onclick="allocate_invoices({{ session('CUS_CN_ID') ?? session('CUS_CN_ID') }});">
                                                            <span class="glyphicon glyphicon-send"></span> ALLOCATION
                                                        </button>


                                                        <button type="submit" class="btn btn-xs btn-danger" name="close_customer_credit_notes">Close</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default p-3">
                                            <div class="panel-body">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">ADD CREDIT NOTES
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <strong>CUSTOMER: </strong><?php if(isset($customer_code)) echo $customer_code." - ";?>
                                                                        <?php if(isset($customer_name)) echo $customer_name;?>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <strong>CREDIT NOTE NO.: </strong><?php if(isset($credit_note_no)) echo $credit_note_no;?>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <?php if(isset($is_posted) && $is_posted==1){ ?>
                                                                        <div class="alert alert-info">Credit note is already posted. You cannot do any changes now.</div>
                                                                        <?php } ?>
                                                                        <hr/>
                                                                    </div>
                                                                </div>
                                                                <div class="row justify-content-center">
                                                                    <div class="col-md-6 col-md-offset-3">
                                                                        <form name="frm_add_cn_items" id="frm_add_cn_items" method="post" autocomplete="off">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label for="description">Description</label>
                                                                                        <input type="text" class="form-control" name="description" id="description" required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <div class="row">
                                                                                            @foreach ($getTaxes as $tax)
                                                                                                <div class="col-md-3">
                                                                                                    <label>
                                                                                                        <input type="checkbox" class="taxcheck" id="taxcheck{{ $tax['id'] }}" name="tax" value="{{ $tax['id'] }}" data-rate="{{ $tax['rate'] }}" data-calc="{{ $tax['calc_method'] }}" data-category="{{ $tax['category'] }}">
                                                                                                        {{ $tax['name'] }} ({{ $tax['rate'] }}%)
                                                                                                    </label>
                                                                                                </div>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="reference">Reference</label>
                                                                                        <input type="text" class="form-control" name="reference" id="reference" placeholder="Reference">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="net_amount">Net Amount</label>
                                                                                        <input type="text" class="form-control number" name="net_amount" id="net_amount" placeholder="Net Amount" required="required">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="gross_amount">Gross Amount</label>
                                                                                        <input type="text" class="form-control number" name="gross_amount" id="gross_amount" placeholder="Gross Amount" required="required">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row justify-content-center">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label" for="sales_account_id">Sales Account</label>
                                                                                        <select class="form-control searchable" id="sales_account_id" name="sales_account_id" required="required" style="width:100%;">
                                                                                            <option value="">- Select Sales Account -</option>
                                                                                            @foreach ($getAllAccounts as $account)
                                                                                                <option value="{{ $account['id'] }}"
                                                                                                    @if(isset($account['control_type']) && $account['control_type'] == "sales_control") selected="selected" @endif>
                                                                                                    {{ $account['code'] }} - {{ ucwords($account['name']) }}
                                                                                                </option>
                                                                                            @endforeach

                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <button type="button" class="btn btn-default form-control" data-dismiss="modal" onclick="clear_inputs();"> CANCEL</button>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <?php if(isset($is_posted) && $is_posted==0){ ?>
                                                                                        <button type="submit" class="btn btn-primary form-control" id="btn_add">ADD</button>
                                                                                        <?php } else { ?>
                                                                                        <button type="submit" class="btn btn-primary form-control disabled" id="btn_add">ADD</button>
                                                                                        <?php } ?>
                                                                                        <input type="hidden" name="edit_id" id="edit_id" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <hr/>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div id="customer_credit_note_details_list"></div>
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
                            @endif

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





<div id="allocate_invoice_modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span class="glyphicon glyphicon-copy"></span> ALLOCATE INVOICES</h4>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> Close</button>
      </div>
      <div class="modal-body">

      	<div>
      		<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#allocate" aria-controls="allocate" role="tab" data-toggle="tab">
				<span class="glyphicon glyphicon-ok"></span> ALLOCATE</a></li>
			<li role="presentation"><a href="#unallocate" aria-controls="unallocate" role="tab" data-toggle="tab">
				<span class="glyphicon glyphicon-remove"></span> UNALLOCATE</a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="allocate">
					<br/>
			      	<form method="post" id="frm_allocate_invoices" name="frm_allocate_invoices">
			      	<div class="row">
			      		<div class="col-md-6">
			      			<div class="form-group">
				      			<label>UNALLOCATED CREDIT NOTE AMOUNT</label>
				      			<input name="unallocated_cn_amount" id="unallocated_cn_amount" class="form-control" value="0.00" readonly="readonly" />
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
					      				<input type="hidden" name="hidden_cn_id" id="hidden_cn_id">
					      			</div>
					      		</div>
					      	</div>
			      		</div>
			      	</div>
			      	</form>
			    </div><!-- /. tab-pane -->
			    <div role="tabpanel" class="tab-pane" id="unallocate">
		    		<br/>
		    		<div class="panel panel-default">
		    			<div class="panel-heading">ALLOCATIONS FOR THE CREDIT NOTE</div>
		    			<div class="panel-body">
		    				<div class="row">
	      						<div class="col-md-12" id="allocated_invoices_list"></div>
	      					</div>
		    			</div>
		    		</div>
			    </div><!-- /. tab-pane -->
			</div><!-- /. tab-content -->
		</div><!-- /. tab -->
      </div><!-- /.modal-body -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@push('css')
    <style>

    </style>
@endpush

@push('scripts')
    <script>
    $(function () {
        $("#cn_date").datepicker({
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


    listTableDatas();

    function listTableDatas(page=1, from_date=null, to_date=null, reference=null) {
        //alert();
        //console.log("THIS");
        $('#overlay').show();
        var cn_id = {{ session('CUS_CN_ID', 0) }};
        $.ajax({
                url : "{{ route('cuscreditnotes.fetchcuscreditnote') }}",
                cache: false,
                data: { _token: '{{ csrf_token() }}','page':page,'from_date':from_date,'to_date':to_date,'reference':reference,'cn_id':cn_id,'order':'DESC'},
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

