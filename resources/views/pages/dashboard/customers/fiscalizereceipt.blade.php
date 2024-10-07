@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">WHT Cetificates</h3>
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
            <a href="#">WHT Cetificates</a>
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
                                     <h1 class="text-uppercase">Fiscalize Receipt - Attachments</h1>

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
                                            <span class="text-uppercase">Fiscalize Receipt - Attachments</span>
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
                                                                        <div class="input-group datepicker_field" id="datepicker1">
                                                                            <input type="text" class="form-control" id="from_date" name="from_date" placeholder="Search From" />
                                                                            <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <div class="input-group datepicker_field" id="datepicker2">
                                                                            <input type="text" class="form-control" id="to_date" name="to_date" placeholder="Search To" />
                                                                            <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <select class="form-control" id="customer_id" name="customer_id" required="required">
                                                                        <option value="">- All Customers -</option>
                                                                        @foreach ($getAllCustomers as $customer)
                                                                            <option value="{{ $customer->id }}">{{ $customer->company }} - {{ $customer->code }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="receipt_no" id="receipt_no" placeholder="Receipt No." />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="wht_cert_no" id="wht_cert_no" placeholder="WHT Cert No." />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <select class="form-control" name="type" id="type">
                                                                            <option value="">- ALL TYPES -</option>
                                                                            <option value="attached">Attached Receipts</option>
                                                                            <option value="not_attached">Not Attached Payments</option>
                                                                        </select>
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
                                                            <div class="row"><div class="col-md-12"><span id="table_list">No Fiscalize Receipt - Attachments!</span></div></div>
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



<!-- Add Hotel Modal -->
<div class="modal fade" id="addAttachmentModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> ADD ATTACHMENTS</h4>
            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
		<form id="frm_add_attachments" method="post" enctype='multipart/form-data'>
	        <div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label required" for="file">File</label>
							<input type="file" class="form-control" id="file" name="file" required />
						</div>
					</div>
				</div>
	        </div>
	        <div class="modal-footer">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">Cancel</button>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<button type="submit" name="submit" class="btn btn-primary form-control">Save</button>
							<input type="hidden" name="attachment_id" id="attachment_id" />
							<input type="hidden" name="receipt_id" id="receipt_id" />
						</div>
					</div>
				</div>
	        </div>
		</form>
      </div>

    </div>
  </div>



<!-- Modal -->
<div id="closeWarningModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        <h4 class="modal-title">Warning</h4>
      </div>
	<form method="post" action="">
      <div class="modal-body">
        <p>Do you want to close this booking window ?</p>
      </div>
        <div class="modal-footer">
		<div class="col-md-6">
		<div class="form-group">
			<button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">No</button>
		</div>
		</div>
		<div class="col-md-6">
		<div class="form-group">
			<button type="submit" name="close_booking" class="btn btn-primary form-control">Yes</button>
		</div>
		</div>
        </div>
	</form>
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
    $('.searchable').select2();
    $(function () {
        $("#from_date").datepicker({
            autoclose: true,
            orientation: "bottom"
        });
        $("#to_date").datepicker({
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

    function listTableDatas(page=1, date_from=null, date_to=null, receipt_no=null, pmethod=null,customer_id=null, bank_account_id=null, is_posted=null, is_allocated=null, post_date_from=null, post_date_to=null) {
        //alert();
        //console.log("THIS");
        $('#overlay').show();
        $.ajax({
                url : "{{ route('fiscalreceiptupload.fetchfiscalreceipts') }}",
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

