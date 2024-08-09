@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Users</h3>
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
            <a href="#">Users</a>
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
                                     <h1 class="text-uppercase">SYSTEM USERS</h1>
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
                                    <!-- your page content -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <input type="hidden" name="permissions_users_List" id="permissions_users_List"/>
                                                    @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                        <a class="btn btn-default btn-xs pull-right addNewUser ml-1" data-bs-toggle="modal" data-bs-target="#addUserModal" role="button">
                                                            <span class="fa fa-plus"></span> ADD NEW USER
                                                        </a>
                                                    @endif
                                                    @if(isset($routepermissions['privilege']) && $routepermissions['privilege'] == 1)
                                                    <button type="button" id="remove_selected" class="btn btn-xs btn-danger pull-right ml-1" style="display: none;">
                                                        <span class="glyphicon glyphicon-plus"></span>
                                                        Remove Rights (Bulk)
                                                    </button>
                                                    <button type="button" id="apply_selected" class="btn btn-xs btn-info pull-right ml-1" style="display: none;">
                                                        <span class="glyphicon glyphicon-plus"></span>
                                                        Assign Rights (Bulk)
                                                    </button>
                                                    @endif
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Name</label>
                                                                <input type="text" class="form-control" id="s_name" placeholder="Name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="text" class="form-control" id="s_email" placeholder="Email">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Privilege</label>
                                                                <select class="form-control" id="s_privilege">
                                                                    <option value=""> - All Privileges - </option>
                                                                    @foreach ($userPrivileges as $userPrivilege)
                                                                        @if($userPrivilege->status == 1)
                                                                            <option value="{{ $userPrivilege->id }}"> {{ $userPrivilege->name }} </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Status</label>
                                                                <select class="form-control" id="s_status">
                                                                    <option value=""> - All Status - </option>
                                                                    <option value="0">Inactive</option>
                                                                    <option value="1">Active</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <button class="btn btn-primary form-control" id="btn_search">Search</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card card-default">
                                                @if(isset($routepermissions['print']) && $routepermissions['print'] == 1)
                                                    <div class="p-3">
                                                        <a href="#" target="_blank"><button type="button" style="margin:2px;" class="btn btn-success btn-xs pull-right get_excel_report">
                                                                <i class="bi bi-file-earmark-excel"></i> Excel
                                                        </button> </a>
                                                        <a href="#" target="_blank"><button type="button" style="margin:2px;" class="btn btn-danger btn-xs pull-right get_pdf_report">
                                                                <i class="bi bi-file-earmark-pdf"></i> Pdf
                                                        </button> </a>
                                                    </div>
                                                @endif
                                                <div class="" id="users_list"></div>
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


<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><span class="fa fa-plus"></span> ADD/EDIT USERS</h4>
            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        	<div>
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="nav-item"><a href="#user_info" class="nav-link active" aria-bs-controls="user_info" role="tab" data-bs-toggle="tab">USER INFORMATION</a></li>
			    <li role="presentation" class="nav-item"><a href="#review" class="nav-link" aria-bs-controls="review" role="tab" data-bs-toggle="tab">REVIEW KPI</a></li>
			    <li role="presentation" class="nav-item"><a href="#notifications" class="nav-link" aria-bs-controls="notifications" role="tab" data-bs-toggle="tab">NOTIFICATIONS</a></li>
			  </ul>
			  <!-- Tab panes -->
			  <div class="tab-content">

			    <div role="tabpanel" class="tab-pane show active" id="user_info">
			    	<br/>
			    	<form name="frm_add_user" id="frm_add_user" method="post">
                    <input type="hidden" name="form_type" id="form_type" value="users.save">
                    <input type="hidden" name="form_user_id" id="form_user_id" value="">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required" for="full_name">Full Name</label>
								<input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter Full Name" required="required" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label" for="email">Email</label>
								<input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label" for="phone">Phone</label>
								<input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required" for="privilege">Privilege</label>
								<select class="form-control" id="privilege" name="privilege" required="required">
									<option value="">- SELECT PRIVILEGE -</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label required" for="login">Login Name (Username)</label>
								<input type="text" class="form-control" id="login" name="login" placeholder="Enter Login Name" required="required" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label required" for="password">Password</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required="required" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label required" for="repassword">Re-Type Password</label>
								<input type="password" class="form-control" id="repassword" name="repassword" placeholder="Enter Re-Type Password" required="required" autocomplete="off" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="employee_id">Bind Employee</label>
								<select name="employee_id" id="employee_id" class="searchable form-control" style="width:100%">
								<option value="">- SELECT EMPLOYEE -</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="group_id" class="control-label required">User Group</label>
								<select name="group_id" id="group_id" class="form-control" style="width:100%" required>
								<option value="">- SELECT GROUP -</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label" for="session_timeout">Session Timeout (Minutes)</label>
								<input type="text" class="form-control" id="session_timeout" name="session_timeout" value="3600" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="branch_id">Branch</label>
								<select name="branch_id" id="branch_id" class="searchable form-control" style="width:100%">
								<option value="">- SELECT Branch -</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="collection_bureau">Collection Bureau</label>
								<select name="collection_bureau" id="collection_bureau" class="searchable form-control" style="width:100%">
								<option value="">- No Collection Bureau -</option>
								</select>
							</div>
						</div>
						<div class="col-md-6 pl-4 pr-4">
							<div class="form-group form-control custom-checkbox ml-1 mr-4">
								<label for="debt_collector">Debt Collector</label>
								<input type="checkbox" id="debt_collector" value="1" name="debt_collector" class="">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
						<div class="form-group">
							<button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">Cancel</button>
							<input type="hidden" id="edit_id" name="edit_id" />
						</div>
						</div>
						<div class="col-md-6">
						<div class="form-group">
							<button type="submit" name="submit" class="btn btn-primary form-control form_submit_btn">Save</button>
						</div>
						</div>
					</div>
					</form>
			    </div>

			    <div role="tabpanel" class="tab-pane" id="review">
			    	<div class="row">
			    		<div class="col-md-12">
					    	<h5><span id="selected_user_name"></span> can review KPI's of below users.</h5>
					    	<form name="frm_review_users" id="frm_review_users" method="post">
					    	<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="control-label required" for="kpi_user_id">Select User</label>
										<select class="searchable form-control" id="kpi_user_id" name="kpi_user_id" required="required" style="width:100%;">
											<option value="">- Select User -</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label" for="submit_review">&nbsp;</label>
										<button type="submit_review" name="submit_review" class="btn btn-primary form-control">ADD TO LIST</button>
										<input type="hidden" id="user_id" name="user_id" />
									</div>
								</div>
							</div>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12" id="review_users_list"></div>
					</div>
			    </div>

			    <div role="tabpanel" class="tab-pane" id="notifications">
			    	<div class="row">
			    		<div class="col-md-12">
					    	<h5>Enabled Notifications for <span id="selected_notify_user_name"></span></h5>
					    	<form name="frm_user_notifications" id="frm_user_notifications" method="post">
					    	<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="control-label required" for="notification_id">Select Notification</label>
										<select class="searchable form-control" id="notification_id" name="notification_id" required="required" style="width:100%;">
											<option value="">- Select Notification -</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label" for="submit_review">&nbsp;</label>
										<button type="submit_review" name="submit_review" class="btn btn-primary form-control">ENABLE</button>
										<input type="hidden" id="notify_user_id" name="notify_user_id" />
									</div>
								</div>
							</div>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12" id="user_notifications_list"></div>
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

    $('#overlay').hide();
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

    $(document).on('click','.chk_user',function(){
        updateHiddenInput();
    });

    function updateHiddenInput() {
        const checkboxes = document.querySelectorAll('.chk_user');
        const checkedValues = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                checkedValues.push(checkbox.value);
            }
        });
        document.getElementById('permissions_users_List').value = checkedValues.join(',');
    }
    document.querySelectorAll('.chk_user').forEach(checkbox => {
        checkbox.addEventListener('change', updateHiddenInput);
    });

    //remove_selected  apply_selected
    $(document).on('click','#apply_selected',function(){
        $('#overlay').show();
        const permissionsUsersList = $('#permissions_users_List').val();
        //alert();
        if(permissionsUsersList == ''){
            Swal.fire({
                position: "bottom-end",
                icon: "error",
                title: "First You must select one or more users from this table..!!",
                showConfirmButton: false,
                timer: 3500
            });
        }else{
            $.redirect("{{ route('users.bulkprivilege') }}", {bulk_users: permissionsUsersList,'permission_type': 'apply', _token: '{{ csrf_token() }}'}, "POST", "_self");
        }
        $('#overlay').hide();
    });

    listUsers();

    function listUsers() {
		//console.log("THIS");
		var name= $('#s_name').val();
		var email= $('#s_email').val();
		var privilege= $('#s_privilege').val();
		var status= $('#s_status').val();

		$('#overlay').show();
        $.ajax({
                url : "{{ route('users.fetchusers') }}",
                cache: false,
                data: { _token: '{{ csrf_token() }}','name':name, 'email':email, 'privilege':privilege, 'status':status, 'order':'ASC'},
                type: 'GET',
                success : function(data) {
                    $('#overlay').hide();
                    $('#users_list').html(data);

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

    $('#btn_search').click(function(){
        listUsers();
    });

    $(document).on('click','.addNewUser',function(){
        $('#overlay').show();
        $('#form_type').val('users.save');
        $('#form_user_id').val('');
        $('.form_submit_btn').text('Save');

        $('#frm_add_user').parsley().reset();
        $('#frm_add_user')[0].reset();

        $('#password').attr('required', true);
        $('#repassword').attr('required', true);
        //alert();
        $.ajax({
            url: '{{ route('users.form') }}',
            cache: false,
            method: 'GET',
            dataType: 'json',
            data: {_token: '{{ csrf_token() }}','action':'formUser'},
            success: function(response){
                //alert(response);
                console.log(response);
                $('#overlay').hide();

                    var privilegeDropdown = $('#privilege');
                    privilegeDropdown.empty();
                    privilegeDropdown.append('<option value="">- SELECT PRIVILEGE -</option>');
                    $.each(response.userPrivileges, function(index, privilege) {
                        privilegeDropdown.append('<option value="'+privilege.id+'">'+privilege.name+'</option>');
                    });

                    var employeesDropdown = $('#employee_id');
                    employeesDropdown.empty();
                    employeesDropdown.append('<option value="">- SELECT EMPLOYEE -</option>');
                    $.each(response.userEmployees, function(index, employee) {
                        employeesDropdown.append('<option value="'+employee.emp_id+'">'+employee.emp_name+'</option>');
                    });

                    var branchesDropdown = $('#branch_id');
                    branchesDropdown.empty();
                    branchesDropdown.append('<option value="">- SELECT BRANCH -</option>');
                    $.each(response.branches, function(index, branche) {
                        branchesDropdown.append('<option value="'+branche.id+'">'+branche.name+'</option>');
                    });

                    var collectionBureauDropdown = $('#collection_bureau');
                    collectionBureauDropdown.empty();
                    collectionBureauDropdown.append('<option value="">- SELECT COLLECTION BUREAU -</option>');
                    $.each(response.collectionBureaus, function(index, collectionBureau) {
                        collectionBureauDropdown.append('<option value="'+collectionBureau.id+'">'+collectionBureau.name+'</option>');
                    });

                    var groupsDropdown = $('#group_id');
                    groupsDropdown.empty();
                    groupsDropdown.append('<option value="">- SELECT GROUP -</option>');
                    $.each(response.groups, function(index, group) {
                        groupsDropdown.append('<option value="'+group.id+'">'+group.group_id+'</option>');
                    });

            },
            error: function (errors) {
                console.log('Error:', errors);
            }
        });
    });

    $(document).on('click','.userEditBtn',function(){
        //alert();
        var user_id = $(this).attr('data-id');
        //alert(user_id);
        $('#overlay').show();
        $('#form_type').val('users.update');
        $('#form_user_id').val(user_id);
        $('.form_submit_btn').text('Update');
        $('#password').removeAttr('required');
        $('#repassword').removeAttr('required');

        $.ajax({
            url: '{{ route('users.edit','+user_id+') }}',
            cache: false,
            method: 'GET',
            dataType: 'json',
            data: {_token: '{{ csrf_token() }}','action':'editUser','user_id':user_id},
            success: function(response){
                $('#overlay').hide();
                //console.log('System User:', response.systemUsers.id);
                if(response.systemUsers != ''){

                    $('#full_name').val(response.systemUsers.full_name);
                    $('#email').val(response.systemUsers.email);
                    $('#phone').val(response.systemUsers.phone);
                    $('#login').val(response.systemUsers.username);
                    $('#session_timeout').val(response.systemUsers.session_timeout);
                    $('#debt_collector').val(response.systemUsers.debt_collector);

                    var privilegeDropdown = $('#privilege');
                    privilegeDropdown.empty();
                    privilegeDropdown.append('<option value="">- SELECT PRIVILEGE -</option>');
                    $.each(response.userPrivileges, function(index, privilege) {
                        privilegeDropdown.append('<option value="'+privilege.id+'">'+privilege.name+'</option>');
                    });

                    var employeesDropdown = $('#employee_id');
                    employeesDropdown.empty();
                    employeesDropdown.append('<option value="">- SELECT EMPLOYEE -</option>');
                    $.each(response.userEmployees, function(index, employee) {
                        employeesDropdown.append('<option value="'+employee.emp_id+'">'+employee.emp_name+'</option>');
                    });

                    var branchesDropdown = $('#branch_id');
                    branchesDropdown.empty();
                    branchesDropdown.append('<option value="">- SELECT BRANCH -</option>');
                    $.each(response.branches, function(index, branche) {
                        branchesDropdown.append('<option value="'+branche.id+'">'+branche.name+'</option>');
                    });

                    var collectionBureauDropdown = $('#collection_bureau');
                    collectionBureauDropdown.empty();
                    collectionBureauDropdown.append('<option value="">- SELECT COLLECTION BUREAU -</option>');
                    $.each(response.collectionBureaus, function(index, collectionBureau) {
                        collectionBureauDropdown.append('<option value="'+collectionBureau.id+'">'+collectionBureau.name+'</option>');
                    });

                    var groupsDropdown = $('#group_id');
                    groupsDropdown.empty();
                    groupsDropdown.append('<option value="">- SELECT GROUP -</option>');
                    $.each(response.usersGroups, function(index, usersGroup) {
                        groupsDropdown.append('<option value="'+usersGroup.id+'">'+usersGroup.group_id+'</option>');
                    });

                    if (response.systemUsers.privilege) {
                        privilegeDropdown.val(response.systemUsers.privilege);
                    }

                    if (response.systemUsers.employee_id) {
                        employeesDropdown.val(response.systemUsers.employee_id);
                    }

                    if (response.systemUsers.branch_id) {
                        branchesDropdown.val(response.systemUsers.branch_id);
                    }

                    if (response.systemUsers.collection_bureau_id) {
                        collectionBureauDropdown.val(response.systemUsers.collection_bureau_id);
                    }

                    if (response.systemUsers.group_id) {
                        groupsDropdown.val(response.systemUsers.group_id);
                    }

                }
            },
            error: function (errors) {
                console.log('Error:', errors);
            }
        });
    });
    $('#frm_add_user').parsley();
    $('#frm_add_user').on('submit', function(event){
        event.preventDefault();

        var user_id = $('#form_user_id').val();
        var form_type = ($('#form_type').val() == 'users.save')?'{{ route("users.save") }}':'{{ route("users.update",'+user_id+') }}';

        var form_name = (form_type == 'users.save')? 'Added': 'Updated';

        $('#overlay').show();
        $('#overlay').hide();

        $.ajax({
            url: ""+form_type+"",
            cache: false,
            method: 'POST',
            data: $(this).serialize() + '&_token={{ csrf_token() }}&action=addUpdateUser',
            success: function(response){
                console.log(response.message);
                listUsers();

                $('#addUserModal').modal('hide');
                $('#frm_add_user').parsley().reset();
                $('#frm_add_user')[0].reset();
                if(response.messageType == 'success'){
                    Swal.fire({
                        position: "bottom-end",
                        icon: "success",
                        title: ""+response.message+"",
                        showConfirmButton: false,
                        timer: 4000
                    });
                }else if(response.messageType == 'wrong'){
                    Swal.fire({
                        position: "bottom-end",
                        icon: "error",
                        title: ""+response.message+"",
                        showConfirmButton: false,
                        timer: 2500
                    });
                }

            },
            error: function (errors) {
                console.log('Error:', errors);
            }
        });
    });

    $(document).on('click','.get_excel_report',function(event){
        event.preventDefault();
        let s_privilege = $('#s_privilege').val();
        let s_status = $('#s_status').val();
        $.redirect("{{ route('system.users.excel') }}", {'privilege': s_privilege,'status': s_status, _token: '{{ csrf_token() }}'}, "GET", "_self");
    });

    $(document).on('click','.get_pdf_report',function(event){
        event.preventDefault();
        let s_privilege = $('#s_privilege').val();
        let s_status = $('#s_status').val();
        $.redirect("{{ route('system.users.pdf') }}", {'privilege': s_privilege,'status': s_status, _token: '{{ csrf_token() }}'}, "GET", "_self");
    });

    $(document).on('click','.userActivete',function(){
        var user_id = ($(this).attr('data-id'))?$(this).attr('data-id'):'';
        var user_status = ($(this).attr('data-status'))?$(this).attr('data-status'):'';
        var activation = (user_status == 1)? 'Inactivate':'Activate';
        $.ajax({
            url: '{{ route('users.userActive','+user_id+') }}',
            cache: false,
            method: 'POST',
            data: {_token: '{{ csrf_token() }}','action':'activeUser','user_status': user_status,'user_id':user_id},
            success: function(response){
                console.log(response);
                listUsers();
                if(response == 'success'){
                    Swal.fire({
                        position: "bottom-end",
                        icon: "success",
                        title: "User has been "+activation+" Successfully..!!",
                        showConfirmButton: false,
                        timer: 2500
                    });
                }
            },
            error: function (errors) {
                console.log('Error:', errors);
            }
        });
    });

    // Swal.fire({
    //     title: "Do you want to delete this user",
    //     showDenyButton: true,
    //     showCancelButton: true,
    //     confirmButtonText: "Save",
    //     denyButtonText: `Don't save`
    // }).then((result) => {
    //     if (result.isConfirmed) {
    //         Swal.fire("Saved!", "", "success");
    //     } else if (result.isDenied) {
    //         Swal.fire("Changes are not saved", "", "info");
    //     }
    //  });
    </script>
@endpush

