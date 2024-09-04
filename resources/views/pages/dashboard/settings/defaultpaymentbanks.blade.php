@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Default Payment Banks</h3>
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
            <a href="#">Default Payment Banks</a>
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
                                     <h1 class="text-uppercase">Default Payment Banks</h1>

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
                                <div class="col-sm-12 col-lg-12">
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <span class="text-uppercase">Default Payment Banks Information</span>
                                                    @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                        <button type="button" class="btn btn-xs btn-info pull-right ml-1 addDefaultPaymentBankButton" data-bs-toggle="modal" data-bs-target="#addDefaultPaymentBankModal" role="button">
                                                            <span class="glyphicon glyphicon-plus"></span>
                                                            Add New Default Payment Bank
                                                        </button>
                                                    @endif
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="p-3" id="table_list"></div>
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

<div class="modal fade" id="addDefaultPaymentBankModal" role="dialog">
    <div class="modal-dialog">

      	<!-- Modal content-->
      	<div class="modal-content">
	        <div class="modal-header">
                <h4 class="modal-title"><span class="fa fa-plus"></span> ADD/EDIT DEFAULT PAYMENT BANK</h4>
	            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
	        </div>
	        <div class="modal-body">
				<form id="frm_add_payment_bank" method="post">
                    <input type="hidden" name="form_type" id="form_type" value="defaultpaymentbanks.adddefaultpaymentbank">
				   	<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label class="control-label required" for="payment_method">Payment Method</label>
								<select class="form-control" name="payment_method" id="payment_method" required="required">
									<option value="">- SELECT -</option>
									<option value="Cash">Cash</option>
									<option value="Cheque">Cheque</option>
									<option value="Card">Card</option>
									<option value="Bank">Bank Transfer</option>
									<option value="WHT">WHT</option>
									<option value="AirtelMoney">Airtel Money</option>
									<option value="TNMMpamba">TNM Mpamba</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label required" for="currency_id">Currency</label>
								<select name="currency_id" id="currency_id" class="form-control" required="required">
                                    @foreach ($currenciesDetails as $currenciesDetail)
                                        <option value="{{ $currenciesDetail->id }}">{{ $currenciesDetail->code }}</option>
                                    @endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label class="control-label" for="card_type_id">Card Type</label>
								<select class="form-control" id="card_type_id" name="card_type_id" disabled>
								   	<option value="">- All Card Types -</option>
                                    @foreach ($cardTypesDetails as $cardTypesDetail)
                                        <option value="{{ $cardTypesDetail->id }}">{{ $cardTypesDetail->name }}</option>
                                    @endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label required" for="bank_account_id">Bank Account</label>
								<select class="form-control" id="bank_account_id" name="bank_account_id" required="required">
									<option value="">- Select Bank Account -</option>
                                    @foreach ($bankAccountsDetails as $bankAccountsDetail)
                                        <option value="{{ $bankAccountsDetail->id }}">{{ $bankAccountsDetail->account_name.' - '.$bankAccountsDetail->account_code }}</option>
                                    @endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col-md-6">
							<button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">
							CANCEL
							</button>
						</div>
						<div class="col-md-6">
							<button type="submit" class="btn btn-primary form-control" id="submit" name="submit">
							<span class="glyphicon glyphicon-plus"></span> SAVE DEFAULT BANK
							</button>
							<input type="hidden" id="edit_id" name="edit_id" />
						</div>
					</div>
				</form>
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

    $('.addDefaultPaymentBankButton').on('click',function(){
        $('#frm_add_payment_bank').parsley().reset();
        $('#frm_add_payment_bank')[0].reset();

        $('#edit_id').val('');
        $('#form_type').val('defaultpaymentbanks.adddefaultpaymentbank');
    });

    $('#deleteRecordForm').parsley();
        $('#deleteRecordForm').on('submit', function(event){
            event.preventDefault();
            $('#overlay').show();
            var delete_record_id = $('#delete_record_id').val();
            var form_type = $('#delete_record_form').val();

            let updateUrl = '{{ route("defaultpaymentbanks.deletedefaultpaymentbank", ":id") }}';
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

    $('#frm_add_payment_bank').parsley();
    $('#frm_add_payment_bank').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var edit_id = ($('#edit_id').val())?$('#edit_id').val():'';
        var form_type = '';

        if($('#form_type').val() == 'defaultpaymentbanks.editdefaultpaymentbank'){
            form_type = '{{ route("defaultpaymentbanks.updatedefaultpaymentbank", ":id") }}';
            form_type = form_type.replace(':id', edit_id);
        }else{
            form_type = '{{ route("defaultpaymentbanks.adddefaultpaymentbank") }}';
        }

        console.log(form_type);
        $.ajax({
            url : form_type,
            cache: false,
            data: $(this).serialize() + '&_token={{ csrf_token() }}',
            type: 'POST',
            dataType: 'json',
            success : function(response) {
                $('#addDefaultPaymentBankModal').modal('hide');
                console.log(response);
                //var arr = data.split("|");
                $('#frm_add_payment_bank').parsley().reset();
                $('#frm_add_payment_bank')[0].reset();
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

    function deleteRecord(id,route_path,type){
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


    function editRecord(id){
        $('#overlay').show();

        $('#form_type').val('defaultpaymentbanks.editdefaultpaymentbank');
        $('#edit_id').val(id);

        let updateUrl = '{{ route("defaultpaymentbanks.editdefaultpaymentbank", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);

        $.ajax({
            url : updateUrl,
            cache: false,
            data: {' _token': '{{ csrf_token() }}','id':id},
            type: 'GET',
            dataType: 'json',
            success : function(response) {
                console.log("Error getting Product !"+response.defaultpaymentbanks);
                $('#addDefaultPaymentBankModal').modal('show');
                if(response.defaultpaymentbanks.id != ''){
                    $('#addDefaultPaymentBankModal #payment_method').val(response.defaultpaymentbanks.payment_method).change();
                    $('#addDefaultPaymentBankModal #currency_id').val(response.defaultpaymentbanks.currency_id).change();
                    $('#addDefaultPaymentBankModal #bank_account_id').val(response.defaultpaymentbanks.bank_account_id).change();
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

    function listTableDatas() {
        //alert();
        //console.log("THIS");
        $('#overlay').show();
        $.ajax({
                url : "{{ route('defaultpaymentbanks.fetchdefaultpaymentbanks') }}",
                cache: false,
                data: { _token: '{{ csrf_token() }}','order':'ASC'},
                type: 'GET',
                success : function(data) {
                    //console.log('Success: '+data);
                    $('#overlay').hide();
                    $('#table_list').html(data);
                },
                error: function(xhr, status, error) {
                    console.log("Error getting Categories ! \n", xhr, status, error);
                    $('#overlay').hide();
                }
        });
    }

    </script>
@endpush

