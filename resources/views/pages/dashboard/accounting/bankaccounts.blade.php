@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Bank Accounts</h3>
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
            <a href="#">Bank Accounts</a>
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
                                     <h1 class="text-uppercase">Bank Accounts</h1>

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
                                            <span class="text-uppercase">Bank Accounts Information</span>
                                            @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                <button type="button" class="btn btn-xs btn-info pull-right ml-1 addBankAccountButton" data-bs-toggle="modal" data-bs-target="#addBankAccountModal" role="button">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                    Add New Bank Account
                                                </button>
                                            @endif
                                        </div>
                                        <div class="panel panel-default p-3">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <select class="form-control" id="s_status" name="s_status">
                                                                <option value="">- All Banks -</option>
                                                                @foreach ($banksDetails as $banksDetail)
                                                                    <option value="{{ $banksDetail->id }}">{{ $banksDetail->code. ' - ' .$banksDetail->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="s_code" name="s_code" placeholder="Code" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="s_name" name="s_name" placeholder="Name" />
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




<div class="modal fade" id="addBankAccountModal" role="dialog">
    <div class="modal-dialog">

      	<!-- Modal content-->
      	<div class="modal-content">
	        <div class="modal-header">
                <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> ADD/EDIT BANK ACCOUNT</h4>
	          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
	        </div>
	        <div class="modal-body">
				<form id="frm_add_bank_account" method="post">
                    <input type="hidden" name="form_type" id="form_type" value="bankaccounts.addbankaccount">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
							   <label for="bank" class="control-label required">Select Bank</label>
							   <select class="form-control" id="bank" name="bank" required="required">
								   	<option value="">- Select Bank -</option>
                                       @foreach ($banksDetails as $banksDetail)
                                           <option value="{{ $banksDetail->id }}">{{ $banksDetail->code.' - '.ucwords($banksDetail->name) }}</option>
                                       @endforeach
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="account_code" class="control-label required">Account Code</label>
						   		<input type="text" class="form-control" id="account_code" name="account_code" required >
							</div>
						</div>
					</div>
				   	<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label for="account_name" class="control-label required">Account Name</label>
								<input type="text" class="form-control" name="account_name" id="account_name" required >
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="account_type" class="control-label required">Account Type</label>
						   		<select class="form-control" name="account_type" id="account_type" required="required">
						   			<option value="">- Select Type -</option>
						   			<option value="current">Current</option>
						   			<option value="savings">Savings</option>
						   			<option value="virtual">Virtual</option>
						   		</select>
							</div>
						</div>
					</div>
				   	<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="currency_id" class="control-label required">Currency</label>
								<select id="currency_id" name="currency_id" class="form-control" required="">
									<option value="">- Select Currency -</option>
                                    @foreach ($currenciesDetails as $currenciesDetail)
                                        <option value="{{ $currenciesDetail->id }}">{{ $currenciesDetail->name }}</option>
                                    @endforeach
								</select>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
							   <label for="nominal_account" class="control-label required">Nominal Account</label>
							   <select class="searchable form-control" id="nominal_account" name="nominal_account" required="required" style="width:100%;">
								   	<option value="">- Select Nominal Account -</option>
                                    @foreach ($acAccountsDetails as $acAccountsDetail)
                                        <option value="{{ $acAccountsDetail->id }}">{{ $acAccountsDetail->code.' - '.ucwords($acAccountsDetail->name) }}</option>
                                    @endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="account_no">Account Number</label>
						   		<input type="text" class="form-control" id="account_no" name="account_no" >
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="last_cheque_no">Last CHQ No.</label>
						   		<input type="text" class="form-control" id="last_cheque_no" name="last_cheque_no" >
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="payment_method">Default Pay Method</label>
						   		<select class="form-control" name="payment_method" id="payment_method">
									<option value="">- SELECT -</option>
									<option value="Cash">Cash</option>
									<option value="Cheque">Cheque</option>
									<option value="Card">Card</option>
									<option value="Bank">Bank Transfer</option>
									<option value="LPO">LPO</option>
									<option value="WHT">WHT</option>
									<option value="AirtelMoney">Airtel Money</option>
									<option value="TNMMpamba">TNM Mpamba</option>
								</select>
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
							<span class="glyphicon glyphicon-plus"></span> SAVE BANK ACCOUNT
							</button>
							<input type="hidden" id="edit_id" name="edit_id" />
						</div>
					</div>
				</form>
			</div>
		</div>
    </div>
</div>



<!-- Account Activity Modal -->
  <div class="modal fade" id="account_activity_modal" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times; Close</button>
          <h4 class="modal-title">
          	<span class="glyphicon glyphicon-th-list"></span>
          	ACCOUNT ACTIVITY <span id="account_activity_title"></span>
          </h4>
        </div>
        <div class="modal-body">
        	<div class="row">
        		<div class="col-md-3">
	        		<div class="form-group">
	        			<div class="input-group" id="datepicker1">
						    <input type='text' class="form-control" id="s_from_date" name="s_from_date" placeholder="From Date" />
						    <span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						    </span>
						</div>
	        		</div>
	        	</div>
        		<div class="col-md-3">
	        		<div class="form-group">
	        			<div class="input-group" id="datepicker2">
						    <input type='text' class="form-control" id="s_to_date" name="s_to_date" placeholder="To Date" />
						    <span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						    </span>
						</div>
	        		</div>
	        	</div>
        		<div class="col-md-3">
	        		<div class="form-group">
	        			<input type="text" class="form-control" name="s_reference" id="s_reference" placeholder="Reference" />
	        		</div>
	        	</div>
        		<div class="col-md-2">
	        		<div class="form-group">
	        			<button class="btn btn-primary form-control" id="btn_search"><span class="glyphicon glyphicon-search"></span></button>
	        			<input type="hidden" name="hidden_account_id" id="hidden_account_id">
	        			<input type="hidden" name="hidden_currency" id="hidden_currency">
	        		</div>
	        	</div>
        		<div class="col-md-1">
	        		<div class="form-group">
	        			<button class="btn btn-default form-control" id="btn_refresh"><span class="glyphicon glyphicon-refresh"></span></button>
	        		</div>
	        	</div>
        	</div>
        	<div class="row">
        		<div class="col-md-12" id="account_activity_information"></div>
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
        $("#datepicker").datepicker({
            autoclose: true
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



    $('.addBankAccountButton').on('click',function(){
        $('#frm_add_bank_account').parsley().reset();
        $('#frm_add_bank_account')[0].reset();

        $('#edit_id').val('');
        $('#form_type').val('bankaccounts.addbankaccount');
    });

    $('#s_reset').click(function(){
        $('#s_code').val("");
        $('#s_name').val("");
        $('#s_status').val("").change();

        listTableDatas();
    });

    $('#s_search').click(function(){
        var code = $('#s_code').val();
        var name = $('#s_name').val();
        var status = $('#s_status').val();

        listTableDatas(code, name, status);
    });


    function get_account_activities(page=1,account_id,from_date='',to_date='', reference=''){

    }


    $('#deleteRecordForm').parsley();
        $('#deleteRecordForm').on('submit', function(event){
            event.preventDefault();
            $('#overlay').show();
            var delete_record_id = $('#delete_record_id').val();
            var form_type = $('#delete_record_form').val();

            let updateUrl = ($('#delete_record_form').val() == 'nominalaccounts.deletenominalaccount')?'{{ route("nominalaccounts.deletenominalaccount", ":id") }}':'{{ route("nominalaccounts.disablenominalaccount", ":id") }}';
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

    /* add Edit record */
    $('#frm_add_bank_account').parsley();
    $('#frm_add_bank_account').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var edit_id = ($('#edit_id').val())?$('#edit_id').val():'';
        var form_type = '';

        if($('#form_type').val() == 'bankaccounts.editbankaccount'){
            form_type = '{{ route("bankaccounts.updatebankaccount", ":id") }}';
            form_type = form_type.replace(':id', edit_id);
        }else{
            form_type = '{{ route("bankaccounts.addbankaccount") }}';
        }

        console.log(form_type);
        $.ajax({
            url : form_type,
            cache: false,
            data: $(this).serialize() + '&_token={{ csrf_token() }}',
            type: 'POST',
            dataType: 'json',
            success : function(response) {
                $('#addBankAccountModal').modal('hide');
                console.log(response);
                //var arr = data.split("|");
                $('#frm_add_bank_account').parsley().reset();
                $('#frm_add_bank_account')[0].reset();
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

    /* disable record */
    function disableRecord(id,route_path,type){
        $('#deleteModal').modal('show');

        $('#delete_record_id').val(id);
        $('#delete_record_form').val(route_path);
        $('#delete_record_type').val(type);

        //console.log(id+'-'+route_path+'-'+type);

        if(type == 'inactive'){
            $('.deleteModelTopic').text('Deactive Record');
            $('.deleteModelDesctiption').text('Are you sure to Delete this Record now...!!!');
            $('.deleteModelBtn').text('Deactive');
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

    function deleteRecord(id,route_path,type){
        $('#deleteModal').modal('show');

        $('#delete_record_id').val(id);
        $('#delete_record_form').val(route_path);
        $('#delete_record_type').val(type);

        //console.log(id+'-'+route_path+'-'+type);

        $('.deleteModelTopic').text('Delete Record');
        $('.deleteModelDesctiption').text('Are you sure to Delete this Record now...!!!');
        $('.deleteModelBtn').text('Delete');
        $('.deleteModelBtn').removeClass('btn-danger');
        $('.deleteModelBtn').addClass('btn-danger');
    }


    function editRecord(id){
        $('#overlay').show();

        $('#form_type').val('bankaccounts.editbankaccount');
        $('#edit_id').val(id);

        let updateUrl = '{{ route("bankaccounts.editbankaccount", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);

        $.ajax({
            url : updateUrl,
            cache: false,
            data: {' _token': '{{ csrf_token() }}','id':id},
            type: 'GET',
            dataType: 'json',
            success : function(response) {
                console.log("Error getting Accounts !"+response.main_category);
                $('#addBankAccountModal').modal('show');
                if(response.bank_account.id != ''){

                    $('#addBankAccountModal #bank').val(response.bank_account.bank_id);
                    $('#addBankAccountModal #account_code').val(response.bank_account.account_code);
                    $('#addBankAccountModal #account_name').val(response.bank_account.account_name);
                    $('#addBankAccountModal #account_no').val(response.bank_account.account_no);
                    $('#addBankAccountModal #last_cheque_no').val(response.bank_account.last_cheque_no);
                    $('#addBankAccountModal #account_type').val(response.bank_account.account_type).change();
                    $('#addBankAccountModal #nominal_account').val(response.nominal_account).change();
                    $('#addBankAccountModal #currency_id').val(response.currenncy_id).change();
                    $('#addBankAccountModal #payment_method').val(response.bank_account.payment_method).change();

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


    listTableDatas();

    function listTableDatas(code=null, name=null, status=null) {
        //alert();
        //console.log("THIS");
        $('#overlay').show();
        $.ajax({
                url : "{{ route('bankaccounts.fetchbankaccounts') }}",
                cache: false,
                data: { _token: '{{ csrf_token() }}','code':code,'name':name,'status':status,'order':'ASC'},
                type: 'GET',
                success : function(data) {
                    //console.log('Success: '+data);
                    $('#overlay').hide();
                    $('#table_list').html(data);
                },
                error: function(xhr, status, error) {
                    //console.log("Error getting Categories ! \n", xhr, status, error);
                    $('#overlay').hide();
                }
        });
    }

    </script>
@endpush

