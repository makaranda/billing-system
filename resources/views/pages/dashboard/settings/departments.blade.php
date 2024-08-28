@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Departments</h3>
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
            <a href="#">Departments</a>
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
                                     <h1 class="text-uppercase">DEPARTMENTS</h1>
                                     {{-- {{ Auth::user()->id }} --}}
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
                                                    DEPARTMENT INFORMATION
                                                    @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                        <button type="button" class="btn btn-xs btn-danger pull-right ml-1 addDepartmentModal" data-bs-toggle="modal" data-bs-target="#addDepartmentModal" role="button">
                                                            <span class="glyphicon glyphicon-plus"></span>
                                                            Add New HOD
                                                        </button>
                                                        <button type="button" class="btn btn-xs btn-info pull-right ml-1 addHODModal" data-bs-toggle="modal" data-bs-target="#addHODModal" role="button">
                                                            <span class="glyphicon glyphicon-plus"></span>
                                                            Add New Department
                                                        </button>
                                                    @endif
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="p-3" id="department_information_list"></div>
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
<div class="modal fade" id="addDepartmentModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><span class="fa fa-plus"></span> ADD/EDIT DEPARTMENT</h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
            <form id="frmDepartment" name="frmDepartment" method="post" action="">
                <input type="hidden" name="dep_id" id="dep_id" value="">
                <input type="hidden" name="form_type" id="form_type" value="department.addhodinformation">
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Parent Department</label>
                            <select class="form-control" id="department_group" name="department_group">
                                <option value="0">- SELECT -</option>
                                @foreach ($allDepartments as $allDepartment)
                                    <option value="{{ $allDepartment->id }}">{{ $allDepartment->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="heading">Department Code</label>
                            <input type="text" name="department_code" id="department_code" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="customer_name">Department Name</label>
                            <input type="text" name="department_name" id="department_name" class="form-control" required>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer d-block">
                <div class="row">
                    <div class="col-md-6 p-0">
                        <div class="form-group">
                            <button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">Cancel</button>
                            <input type="hidden" id="department_id" name="department_id" />
                        </div>
                    </div>
                    <div class="col-md-6 p-0">
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

<!-- Add HOD Modal -->
<div class="modal fade" id="addHODModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><span class="fa fa-plus"></span> ADD/EDIT HOD</h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
            <form id="frmHOD" name="frmHOD" method="post" action="">
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="hod_title">Title</label>
                            <select name="hod_title" id="hod_title" class="form-control" required>
                                @foreach (CONST_TITLES as $key => $value)
                                    <option value='{{ $key }}'>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hod_full_name">Full Name</label>
                            <input type="text" name="hod_full_name" id="hod_full_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="hod_email">Email</label>
                            <input type="text" name="hod_email" id="hod_email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="hod_phone">Phone</label>
                            <input type="text" name="hod_phone" id="hod_phone" class="form-control" >
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer d-block">
                <div class="row">
                    <div class="col-md-6 p-0">
                        <div class="form-group">
                            <button type="button" class="btn btn-default form-control w-100" data-bs-dismiss="modal">Cancel</button>
                            <input type="hidden" id="hod_id" name="hod_id" />
                        </div>
                    </div>
                    <div class="col-md-6 p-0">
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-primary form-control w-100">Save</button>
                        </div>
                    </div>
                </div>
                </div>
            </form>
      </div>

    </div>
  </div>

<!-- Add HOD Modal -->
  <div class="modal fade" id="assignHODModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><span class="fa fa-plus"></span> ADD/EDIT HOD</h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
            <form id="frmAssignHOD" name="frmAssignHOD" method="post" action="">
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="assign_hod">Department Head</label>

                            <select name="assign_hod" id="assign_hod" class="form-control">
                                <option value="">-Select HOD-</option>
                                @foreach ($allDepartmentHeads as $allDepartmentHead)
                                    <option value="{{ $allDepartmentHead->id }}">{{ $allDepartmentHead->full_name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
                </div>
                <div class="modal-footer d-block">
                <div class="row">
                    <div class="col-md-6 p-0">
                        <div class="form-group">
                            <button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">Cancel</button>
                            <input type="hidden" id="hod_department_id" name="hod_department_id" />
                        </div>
                    </div>
                    <div class="col-md-6 p-0">
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

    $('.addDepartmentModal').on('click',function(){
        //console.log('addDepartmentModal');
        $('#frmDepartment').parsley().reset();
        $('#frmDepartment')[0].reset();
        $('#dep_id').val('');
        $('#form_type').val('department.addnewdepartment');
    });

    $('.addHODModal').on('click',function(){
        //console.log('addHODModal');
        $('#frmHOD').parsley().reset();
        $('#frmHOD')[0].reset();
    });

    $('#frmDepartment').parsley();
    $('#frmDepartment').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var dep_id = ($('#dep_id').val())?$('#dep_id').val():'';
        var form_type = ($('#form_type').val() == 'department.addnewdepartment')?'{{ route("department.addnewdepartment") }}':'{{ route("department.updatedepartment",'+dep_id+') }}';

        console.log(form_type);
        $.ajax({
            url : ""+form_type+"",
            cache: false,
            data: $(this).serialize() + '&_token={{ csrf_token() }}',
            type: 'POST',
            dataType: 'json',
            success : function(response) {
                $('#addDepartmentModal').modal('hide');
                console.log(response);
                //var arr = data.split("|");
                $('#frmDepartment').parsley().reset();
                $('#frmDepartment')[0].reset();
                Swal.fire({
                    position: "bottom-end",
                    icon: response.messageType === 'success' ? "success" : "error",
                    title: response.message,
                    showConfirmButton: false,
                    timer: response.messageType === 'success' ? 4000 : 2500
                });
                listDepartments();
                $('#overlay').hide();
            },
            error: function(data) {
                console.log("Error getting departments ! \n");
                $('#overlay').hide();
            }
        });

    });

    $('#frmHOD').parsley();
    $('#frmHOD').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        $.ajax({
            url : "{{ route('department.addhodinformation') }}",
            cache: false,
            data: $(this).serialize() + '&_token={{ csrf_token() }}',
            type: 'POST',
            success : function(response) {
                $('#addHODModal').modal('hide');
                console.log(response);
                //var arr = data.split("|");
                $('#frmHOD').parsley().reset();
                $('#frmHOD')[0].reset();
                Swal.fire({
                    position: "bottom-end",
                    icon: response.messageType === 'success' ? "success" : "error",
                    title: response.message,
                    showConfirmButton: false,
                    timer: response.messageType === 'success' ? 4000 : 2500
                });
                listDepartments();
                $('#overlay').hide();
            },
            error: function(data) {
                console.log("Error getting departments ! \n");
                $('#overlay').hide();
            }
        });

    });

    function assignDepartmentHead(id){
        $('#hod_department_id').val(id);
        $('#assignHODModal').modal('show');
    }

    function editDepartment(id){
        $('#overlay').show();
        $('#addDepartmentModal').modal('show');

        $('#form_type').val('department.updatehodinformation');
        $('#dep_id').val(id);
        $.ajax({
            url : "{{ route('department.getdepartment') }}",
            cache: false,
            data: {' _token': '{{ csrf_token() }}','id':id},
            type: 'GET',
            dataType: 'json',
            success : function(response) {
                $('#addDepartmentModal').modal('show');
                //var arr = data.split("|");
                if(response.departments.id != ''){
                    $('#addDepartmentModal #department_id').val(response.departments.id);
                    $('#addDepartmentModal #department_group').val(response.departments.department).change();
                    $('#addDepartmentModal #department_code').val(response.departments.code);
                    $('#addDepartmentModal #department_name').val(response.departments.name);
                }
                listDepartments();
                $('#overlay').hide();
            },
            error: function(data) {
                console.log("Error getting departments ! \n");
                $('#overlay').hide();
            }
        });
    }


    listDepartments();

    function listDepartments() {
		//console.log("THIS");
		$('#overlay').show();
        $.ajax({
                url : "{{ route('department.fetchdepartment') }}",
                cache: false,
                data: { _token: '{{ csrf_token() }}','order':'ASC'},
                type: 'GET',
                success : function(data) {
                    $('#overlay').hide();
                    $('#department_information_list').html(data);

                    $('#check_all').change(function(){
                        if(this.checked) $('.chk_user').prop("checked",true).trigger('change');
                        else $('.chk_user').prop("checked",false).trigger('change');
                    });

                    $('.chk_user').change(function(){
                        $('#apply_selected').css("display", "none");
                        if($('input[class="chk_user"]').is(':checked')) {
                            $('#apply_selected').css("display","block");
                        }

                    $('#remove_selected').css("display", "none");
                        if($('input[class="chk_user"]').is(':checked')) {
                            $('#remove_selected').css("display","block");
                        }
                    });
                },
                error: function(data) {
                    //$('#overlay').hide();
                    $('#errorMessage').html(JSON.stringify(data));
                    $('#errorModal').modal();
                }
        });
    }
    </script>
@endpush

