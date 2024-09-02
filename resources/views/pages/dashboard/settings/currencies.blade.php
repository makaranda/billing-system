@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Currencies</h3>
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
            <a href="#">Currencies</a>
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
                                     <h1 class="text-uppercase">Currencies</h1>

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

                                    {{-- {{ '<pre>' }}
                                    {{ var_dump($routepermissions['read']) }}
                                    {{ '</pre>' }} --}}
                                     {{-- {{ var_dump(CONST_TITLES) }} --}}
                                    <!-- your page content -->

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <span class="text-uppercase">Currencies Information</span>
                                                    @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                        <button type="button" class="btn btn-xs btn-info pull-right ml-1 addCurrencyButton" data-bs-toggle="modal" data-bs-target="#addCurrencyModal" role="button">
                                                            <span class="glyphicon glyphicon-plus"></span>
                                                            Add New Currency
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

<!-- Add Currency -->
<div class="modal fade" id="addCurrencyModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><span class="fa fa-plus"></span> ADD/EDIT CURRENCY RATES</h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
        <form id="frm_add_currency" method="post" action="">
            <input type="hidden" name="form_type" id="form_type" value="currencies.addcurrency">
            <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="currency_code">Code</label>
                        <input type="text" class="form-control" id="currency_code" name="currency_code" placeholder="Enter Currency Code" required="required" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="currency_name">Name</label>
                        <input type="text" class="form-control" id="currency_name" name="currency_name" placeholder="Enter Currency Name" required="required" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="currency_symbol">Symbol</label>
                        <input type="text" class="form-control" id="currency_symbol" name="currency_symbol" placeholder="Enter Currency Symbol" required="required" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="currency_value">Value</label>
                        <input type="text" class="form-control" id="currency_value" name="currency_value" placeholder="Enter Currency Value" required="required" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="base_currency">Base Currency</label><br/>
                        <input type="checkbox" name="base_currency" id="base_currency" />
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer d-block">
            <div class="row">
                <div class="col-md-6 pl-0">
                <div class="form-group">
                    <button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">Cancel</button>
                    <input type="hidden" id="edit_id" name="edit_id" />
                </div>
                </div>
                <div class="col-md-6 pr-0">
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary form-control">Save</button>
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

    $('.addCurrencyButton').on('click',function(){
        $('#frm_add_currency').parsley().reset();
        $('#frm_add_currency')[0].reset();

        $('#edit_id').val('');
        $('#form_type').val('currencies.addcurrency');
    });


    $('#deleteRecordForm').parsley();
    $('#deleteRecordForm').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var delete_record_id = $('#delete_record_id').val();
        var form_type = $('#delete_record_form').val();

        let updateUrl = '{{ route("currencies.deletecurrency", ":id") }}';
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

    $('#frm_add_currency').parsley();
    $('#frm_add_currency').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var edit_id = ($('#edit_id').val())?$('#edit_id').val():'';
        var form_type = '';

        if($('#form_type').val() == 'currencies.editcurrency'){
            form_type = '{{ route("currencies.updatecurrency", ":id") }}';
            form_type = form_type.replace(':id', edit_id);
        }else{
            form_type = '{{ route("currencies.addcurrency") }}';
        }
        //var form_type = ($('#form_type').val() == 'products.addproduct')?'{{ route("products.addproduct") }}':'{{ route("products.updateproduct",'+expense_id+') }}';

        console.log(form_type);
        $.ajax({
            url : form_type,
            cache: false,
            data: $(this).serialize() + '&_token={{ csrf_token() }}',
            type: 'POST',
            dataType: 'json',
            success : function(response) {
                $('#addCurrencyModal').modal('hide');
                console.log(response);
                //var arr = data.split("|");
                $('#frm_add_currency').parsley().reset();
                $('#frm_add_currency')[0].reset();
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

        $('#form_type').val('currencies.editcurrency');
        $('#edit_id').val(id);

        let updateUrl = '{{ route("currencies.editcurrency", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);

        //alert(id);

        $.ajax({
            url : updateUrl,
            cache: false,
            data: {' _token': '{{ csrf_token() }}','id':id},
            type: 'GET',
            dataType: 'json',
            success : function(response) {
                //console.log("Error getting Product !"+response);
                $('#addCurrencyModal').modal('show');
                if(response.currencies.id != ''){
                    $('#addCurrencyModal #currency_code').val(response.currencies.code);
                    $('#addCurrencyModal #currency_name').val(response.currencies.name);
                    $('#addCurrencyModal #currency_symbol').val(response.currencies.symbol);
                    $('#addCurrencyModal #currency_value').val(response.currencies.rate);
                    if(response.currencies.is_base==1){
                        $('#addCurrencyModal #base_currency').prop("checked",true);
                    }
                    else {
                        $('#addCurrencyModal #base_currency').prop("checked",false);
                    }
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
                url : "{{ route('currencies.fetchcurrencies') }}",
                cache: false,
                data: { _token: '{{ csrf_token() }}','order':'ASC'},
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

