@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Permissions</h3>
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
            <a href="{{ route('index.users') }}">Users</a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item text-capitalize">
            <a href="#">Permissions</a>
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
                                     <h1 class="text-uppercase">APPLY USER MENU PERMISSIONS</h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12">
                                    <br/>
                                        <div class="panel text-right" style="padding-right:8px;">
                                            <input type="checkbox" onclick="checkAllMenuPrivileges(this);"> Select All
                                        </div>
                                        {{-- {{ var_dump($mainMenus) }} --}}


                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            @foreach ($mainMenus as $key => $mainMenu)
                                              <div class="accordion-item mb-2">
                                                <h2 class="accordion-header rounded">
                                                  <div class="row justify-content-center">
                                                     <div class="col-9 col-md-10">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $key }}" aria-expanded="false" aria-controls="flush-collapse{{ $key }}">{{ $mainMenu->name }}</button>
                                                     </div>
                                                     <div class="col-3 col-md-2">
                                                        <div class="panel text-right" style="padding-right:8px;">
                                                            <label class="text-capitalize">
                                                               <input type="checkbox" id="{{ $mainMenu->id }}" onclick="checkAll(this);"/> Select All
                                                            </label>
                                                         </div>
                                                     </div>
                                                  </div>
                                                </h2>
                                                <div id="flush-collapse{{ $key }}" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                                  <div class="accordion-body">

                                                    <div class="row">
                                                        @if($mainMenu->subMenus->isNotEmpty())
                                                            @foreach($mainMenu->subMenus as $key1 => $subMenu)
                                                                <div class="col-6 col-md-3">
                                                                    <a class="sub-item text-uppercase" href="#"><span class="sub-item">{{ $subMenu->name }}</span></a>
                                                                    <ul class="permissions_types_list">
                                                                        @php
                                                                            $menuCountor = 1;
                                                                        @endphp
                                                                        @foreach ($permissionsTypes as $key2 => $permissionsType)
                                                                            <li>
                                                                                <a><div class="checkbox">
                                                                                        <label class="text-uppercase">
                                                                                            <input type="checkbox" name="{{ $permissionsType->permission_type }}[]" value="{{ $subMenu->id }}" id="{{ $subMenu->id }}_{{ $permissionsType->permission_type }}" class="sub_of_{{ $mainMenu->id }}"> {{ $permissionsType->permission_type }}
                                                                                        </label>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>


                                                  </div>
                                                </div>
                                              </div>
                                            @endforeach
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
    //$('.searchable').select2();

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
    function checkAllMenuPrivileges(element){
        $('input:checkbox').prop('checked',element.checked);
    }
    function checkAll(element){
        $('.sub_of_' + element.id).prop('checked',element.checked);
    }

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

