@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header d-block">
        <div class="row">
            <div class="col-12 col-md-6">
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
            <div class="col-12 col-md-6 align-content-end text-right">
                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#importUserRightsModal"><i class="fas fa-file-import"></i> Import</button>
            </div>
        </div>


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
                            <div class="col-md-12">
                                <div class="alert alert-info bg-light">
                                    @php
                                        $countArr = explode(',',$bulkUsers);
                                        $bulkUsersNamesArrs = (count(explode(',',$bulkUsersNames)))?explode(',',$bulkUsersNames):$bulkUsersNames;
                                        //$bulkUsersNamesArrs = 'Amal,Kamal';
                                    @endphp
                                    <strong><u>{{ count($countArr) }} User(s) Selected</u></strong> <br>
                                    @if (count(explode(',',$bulkUsersNames)) > 1)
                                        @foreach ($bulkUsersNamesArrs as $index => $bulkUsersNamesArr)
                                            <i>{{ $bulkUsersNamesArr }}</i>@if($index < count($bulkUsersNamesArrs) - 1), @endif
                                        @endforeach
                                    @else
                                        <i>{{ $bulkUsersNamesArrs[0] }}</i>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12">
                                        <div class="panel text-right" style="padding-right:8px;">
                                            <input type="checkbox" onclick="checkAllMenuPrivileges(this);"> Select All
                                        </div>
                                        {{-- {{ var_dump($mainMenusPrivilage) }} --}}
                                        @php
                                            if($userPermissionLists){
                                                $userPermissionLists = rtrim($userPermissionLists, ",");
                                            }else{
                                                $userPermissionLists = '';
                                            }
                                        @endphp
                                        <input type="hidden" name="permissionsUsersList" id="permissionsUsersList" value="{{ ($bulkUsers != '')?$bulkUsers:$bulkUsers }}"/>
                                        <input type="hidden" name="permissionType" id="permissionType" value="{{ ($permissionType != '')?$permissionType:'' }}"/>
                                        <input type="hidden" name="permissions" id="permissions" value="{{ ($userPermissionLists != '')?$userPermissionLists:'' }}"/>
                                        <input type="hidden" name="permissionsRemove" id="permissionsRemove" value=""/>
                                        <div class="accordion accordion-flush" id="accordionFlushExample">

                                            {{-- {{ 'user Permission Lists : '.$userPermissionLists }} --}}
                                            @foreach ($mainMenusPrivilage as $key => $mainMenu)
                                                <div class="accordion-item mb-2 border">
                                                    <h2 class="accordion-header rounded">
                                                        <div class="row justify-content-center">
                                                            <div class="col-9 col-md-10 align-content-center">
                                                            <button class="accordion-button collapsed pl-4" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $key }}" aria-expanded="false" aria-controls="flush-collapse{{ $key }}">{{ $mainMenu->name }}</button>
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
                                                            <div class="col-12 col-md-12"></div>
                                                            @if($mainMenu->children->isNotEmpty())
                                                                @foreach($mainMenu->children as $key1 => $subMenu)
                                                                    <div class="col-6 col-md-3">
                                                                        <a class="sub-item text-uppercase" href="#"><span class="sub-item">{{ $subMenu->name }}</span></a>
                                                                        <ul class="permissions_types_list">
                                                                        @foreach ($permissionsTypesPrivilage as $key2 => $permissionsType)
                                                                            @php
                                                                                $checked = isChecked($subMenu->route, $permissionsType->permission_type, $routesPermissionsMap, $bulkUsersArray) ? 'checked' : '';
                                                                            @endphp
                                                                            @if ($subMenu->route == $permissionsType->route)
                                                                                <li>
                                                                                    <a>
                                                                                    <div class="checkbox">
                                                                                        <label class="text-uppercase">
                                                                                            <input type="checkbox" name="{{ $permissionsType->permission_type }}[]" value="{{ $mainMenu->id.'/'.$subMenu->id.'/'.$permissionsType->permission_type }}" id="{{ $subMenu->id }}_{{ $permissionsType->permission_type }}" class="chk_user sub_of_{{ $mainMenu->id }}" {{ $checked }}/>
                                                                                            {{ $permissionsType->permission_type }}
                                                                                        </label>
                                                                                    </div>
                                                                                    </a>
                                                                                </li>
                                                                            @endif
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
                                        <div class="col-md-12 text-center mt-4">
											<button type="button" class="btn btn-primary" id="{{ ($permissionType == 'remove')?'remove':'save' }}_permission">	{{ ($permissionType == 'remove')?'REMOVE':'SAVE' }} USER MENU PERMISSIONS</button>
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



<!-- Import User Rights Modal -->
<div class="modal fade" id="importUserRightsModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><span class="fa fa-plus"></span> IMPORT RIGHTS FROM ANOTHER USER</h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
            <form id="frm_rights_import" name="frm_rights_import" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            This will remove all permissions from the selected user(s) and insert all the persmissions from the copy/import user. <hr/>
                        </div>
                    </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="import_user_id" class="fw-bold">Copy / Import Rights From the User</label>
                              <select name="import_user_id" id="import_user_id" class="form-control searchable select2-list" style="width:100%;" required>
                                  <option value="">- Select User -</option>
                                  @foreach ($systemUserPrivilages as $systemUserPrivilage)
                                     <option value="{{ $systemUserPrivilage->id }}">{{ $systemUserPrivilage->username }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer d-block">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group p-0">
                              <button type="button" class="btn btn-default form-control w-100" data-bs-dismiss="modal">Cancel</button>
                              <input type="hidden" name="to_user_ids" id="to_user_ids" value="{{ ($bulkUsers != '')?$bulkUsers:$bulkUsers }}"/>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group p-0">
                              <button type="submit" name="submit_import" id="submit_import" class="btn btn-primary form-control w-100">Import</button>
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
    $(document).ready(function() {
        //NiceSelect.bind(document.getElementById("import_user_id"), {searchable: true, placeholder: 'select', searchtext: 'zoek', selectedtext: 'geselecteerd'});
        //$('.searchable').select2();
        $('.searchable').removeAttr('disabled').removeClass('disabled').select2({
            allowClear: true
        });

        $(document).on('click', '.select2-search__field', function() {
            $(this).trigger('focus'); // Set focus on the input field
        });
    });
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

    $(document).on('click','.chk_user',function(){
        updateHiddenInput();
        removeHiddenInput(this);
    });

    function removeHiddenInput(clickedCheckbox){
        const checkedValues2 = $('#permissionsRemove').val() ? $('#permissionsRemove').val().split(',') : [];
        const value = $(clickedCheckbox).val();

        if (!$(clickedCheckbox).is(':checked')) {
            checkedValues2.push(value);
        } else {
            const index = checkedValues2.indexOf(value);
            if (index > -1) {
                checkedValues2.splice(index, 1);
            }
        }

        $('#permissionsRemove').val(checkedValues2.join(','));
    }

    function updateHiddenInput() {
        const checkboxes = document.querySelectorAll('.chk_user');
        const checkedValues = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                checkedValues.push(checkbox.value);
            }
        });
        document.getElementById('permissions').value = checkedValues.join(',');
    }
    document.querySelectorAll('.chk_user').forEach(checkbox => {
        checkbox.addEventListener('change', updateHiddenInput);
    });

    $('#frm_rights_import').parsley();
    $('#frm_rights_import').on('submit',function(event){
        event.preventDefault();
        $('#overlay').show();
        var import_user_id = $('#import_user_id').val();
        var to_user_ids = $('#to_user_ids').val();
        $.ajax({
            url: "{{ route('privileges.import') }}",
            cache: false,
            method: 'POST',
            //dataType: 'json',
            data: {_token: '{{ csrf_token() }}','import_user_id':import_user_id,'to_user_ids':to_user_ids},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure you include the CSRF token
            },
            success: function(response){
                //console.log(response.message);
                 console.log(response);

                $('#importUserRightsModal').modal('hide');
                $('#frm_rights_import').parsley().reset();
                $('#frm_rights_import')[0].reset();
                $('#import_user_id').val(null).trigger('change');
                if(response.message == 'success'){
                    Swal.fire({
                        position: "bottom-end",
                        icon: "success",
                        title: "User Import Successfully..!!",
                        showConfirmButton: false,
                        timer: 4000
                    });
                }else if(response.message == 'error'){
                    Swal.fire({
                        position: "bottom-end",
                        icon: "error",
                        title: "There have errors..!!",
                        showConfirmButton: false,
                        timer: 2500
                    });
                }

            },
            error: function (errors) {
                console.log('Error:', errors);
            }
        });

        $('#overlay').hide();
    })

    $(document).on('click','#remove_permission',function(){
        $('#overlay').show();
        const permissionsUsersList = $('#permissionsUsersList').val();
        const permissionType = $('#permissionType').val();
        const permissions = $('#permissions').val();
        const permissionsRemove = $('#permissionsRemove').val();

        $.ajax({
            url: '{{ route('privileges.remove') }}',
            cache: false,
            method: 'POST',
            dataType: 'json',
            data: {_token: '{{ csrf_token() }}','action':'formUser','permissionsUsersList':permissionsUsersList,'permissionType':permissionType,'permissions':permissions,'permissionsRemove':permissionsRemove},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure you include the CSRF token
            },
            success: function(response){
                //alert(response);
                $('#overlay').hide();
                console.log(response.message);
                if(response.message == 'success'){
                    Swal.fire({
                        position: "bottom-end",
                        icon: "success",
                        title: "You Have Removed User Permissions Successfully ",
                        showConfirmButton: false,
                        timer: 4000
                    });
                };

            },
            error: function (errors) {
                console.log('Error:', errors);
            }
        });
    });

    $(document).on('click','#save_permission',function(){
        $('#overlay').show();
        const permissionsUsersList = $('#permissionsUsersList').val();
        const permissionType = $('#permissionType').val();
        const permissions = $('#permissions').val();
        //alert();
        $.ajax({
            url: '{{ route('privileges.save') }}',
            cache: false,
            method: 'POST',
            dataType: 'json',
            data: {_token: '{{ csrf_token() }}','action':'formUser','permissionsUsersList':permissionsUsersList,'permissionType':permissionType,'permissions':permissions},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure you include the CSRF token
            },
            success: function(response){
                //alert(response);
                $('#overlay').hide();
                console.log(response.message);
                if(response.message == 'success'){
                    Swal.fire({
                        position: "bottom-end",
                        icon: "success",
                        title: "You Have Updated User Permissions Successfully ",
                        showConfirmButton: false,
                        timer: 4000
                    });
                };

            },
            error: function (errors) {
                console.log('Error:', errors);
            }
        });
    });

    function checkAllMenuPrivileges(element){
        $('input:checkbox').prop('checked',element.checked);
        updateHiddenInput();
    }
    function checkAll(element){
        $('.sub_of_' + element.id).prop('checked',element.checked);
        updateHiddenInput();
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

