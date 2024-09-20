@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Add Customer Group</h3>
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
            <a href="#">Add Customer Group</a>
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
                                     <h1 class="text-uppercase">Add Customer Group</h1>

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
                                            <span class="text-uppercase">Customer Group Information</span>
                                            @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                <button type="button" class="btn btn-xs btn-info pull-right ml-1 addGroupButton" data-bs-toggle="modal" data-bs-target="#addGroupModal" role="button">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                    Add New Customer Group
                                                </button>
                                            @endif
                                        </div>
                                        <div class="panel panel-default p-3">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" id="search_group_name" class="form-control" placeholder="Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <button type="button" id="s_search" class="btn btn-primary form-control">
                                                                <span class="glyphicon glyphicon-serach"></span> Search</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <button type="button" id="s_reset" class="btn btn-default form-control">
                                                                <span class="glyphicon glyphicon-refresh"></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            @if(isset($routepermissions['print']) && $routepermissions['print'] == 1)
                                                                <div class="col-12 col-md-12">
                                                                    <a href="#" target="_blank"><button type="button" style="margin:2px;" class="btn btn-success btn-xs pull-right get_excel_report">
                                                                            <i class="bi bi-file-earmark-excel"></i> Excel
                                                                    </button> </a>
                                                                    <a href="#" target="_blank"><button type="button" style="margin:2px;" class="btn btn-danger btn-xs pull-right get_pdf_report">
                                                                            <i class="bi bi-file-earmark-pdf"></i> Pdf
                                                                    </button> </a>
                                                                </div>
                                                            @endif
                                                            <div class="col-md-12"><span id="table_list"></span></div>
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

<div id="addGroupModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<div class="modal-header">
            <h4 class="modal-title">ADD/EDIT CUSTOMER GROUP</h4>
		    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<form id="frm_add_customer_group" name="frm_add_customer_group" method="post">
            <input type="hidden" name="form_type" id="form_type" value="creditcardtypes.addcreditcardtypes">
      	<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label required" for="group_name">Group Name</label>
						<input type="text" class="form-control" name="group_name" id="group_name" required="required">
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer d-block">
			<div class="row">
				<div class="col-md-6 pl-0">
					<button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">
					CANCEL
					</button>
				</div>
				<div class="col-md-6 pr-0">
					<button type="submit" class="btn btn-primary form-control" id="c_submit" name="c_submit">
					<span class="glyphicon glyphicon-plus"></span> SAVE CUSTOMER GROUP
					</button>
					<input type="hidden" id="edit_id" name="edit_id" />
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

    $('.addGroupButton').on('click',function(){
        $('#frm_add_customer_group').parsley().reset();
        $('#frm_add_customer_group')[0].reset();

        $('#edit_id').val('');
        $('#form_type').val('cusaddcustomergroups.addcustomergroup');
    });
//frm_add_customer_group
    $('#s_reset').click(function(){
        $('#search_group_name').val("");
        listTableDatas();
    });

    $('#s_search').click(function(){
        var name = $('#search_group_name').val();
        console.log(name);
        listTableDatas(name);
    });

/* add Edit record */
$('#frm_add_customer_group').parsley();
    $('#frm_add_customer_group').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var edit_id = ($('#edit_id').val())?$('#edit_id').val():'';
        var form_type = '';

        if($('#form_type').val() == 'cusaddcustomergroups.editcustomergroup'){
            form_type = '{{ route("cusaddcustomergroups.updatecustomergroup", ":id") }}';
            form_type = form_type.replace(':id', edit_id);
        }else{
            form_type = '{{ route("cusaddcustomergroups.addcustomergroup") }}';
        }

        console.log(form_type);
        $.ajax({
            url : form_type,
            cache: false,
            data: $(this).serialize() + '&_token={{ csrf_token() }}',
            type: 'POST',
            dataType: 'json',
            success : function(response) {
                $('#addGroupModal').modal('hide');
                console.log(response);
                //var arr = data.split("|");
                $('#frm_add_customer_group').parsley().reset();
                $('#frm_add_customer_group')[0].reset();
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

        $('.deleteModelTopic').text('Delete Record');
        $('.deleteModelDesctiption').text('Are you sure to Delete this Record now...!!!');
        $('.deleteModelBtn').text('Delete');
        $('.deleteModelBtn').removeClass('btn-danger');
        $('.deleteModelBtn').addClass('btn-danger');
    }


    function editRecord(id){
        $('#overlay').show();

        $('#form_type').val('cusaddcustomergroups.editcustomergroup');
        $('#edit_id').val(id);

        let updateUrl = '{{ route("cusaddcustomergroups.editcustomergroup", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);

        $.ajax({
            url : updateUrl,
            cache: false,
            data: {' _token': '{{ csrf_token() }}','id':id},
            type: 'GET',
            dataType: 'json',
            success : function(response) {
                console.log("Error getting Accounts !"+response.main_category);
                $('#addGroupModal').modal('show');
                if(response.customergroups.id != ''){
                    $('#addGroupModal #group_name').val(response.customergroups.name);
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



    $('#deleteRecordForm').parsley();
    $('#deleteRecordForm').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var delete_record_id = $('#delete_record_id').val();
        var form_type = $('#delete_record_form').val();

        let updateUrl = '{{ route("cusaddcustomergroups.deletecustomergroup", ":id") }}';
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

    listTableDatas();

    function listTableDatas(name=null) {
        //alert();
        //console.log("THIS");
        $('#overlay').show();
        $.ajax({
                url : "{{ route('cusaddcustomergroups.fetchaddcustomergroups') }}",
                cache: false,
                data: { _token: '{{ csrf_token() }}','name':name,'order':'ASC'},
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

