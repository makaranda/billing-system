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
                                        <div class="panel text-right" style="padding-right:8px;">
                                            <input type="checkbox" onclick="checkAllMenuPrivileges(this);"> Select All
                                        </div>
                                        {{-- {{ var_dump($mainMenus) }} --}}

                                        <input type="hidden" name="permissionsUsersList" id="permissionsUsersList" value="{{ ($bulkUsers != '')?$bulkUsers:$bulkUsers }}"/>
                                        <input type="hidden" name="permissionType" id="permissionType" value="{{ ($permissionType != '')?$permissionType:'' }}"/>
                                        <input type="hidden" name="permissions" id="permissions" value=""/>
                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            @foreach ($mainMenus as $key => $mainMenu)
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
                                                        @if($mainMenu->subMenus->isNotEmpty())
                                                            @foreach($mainMenu->subMenus as $key1 => $subMenu)
                                                                <div class="col-6 col-md-3">
                                                                    <a class="sub-item text-uppercase" href="#"><span class="sub-item">{{ $subMenu->name }}</span></a>
                                                                    <ul class="permissions_types_list">
                                                                        @php
                                                                            $menuCountor = 1;
                                                                        @endphp

                                                                        @foreach ($permissionsTypes as $key2 => $permissionsType)
                                                                            @foreach ($routesPermissions as $routesPermission)
                                                                                @php
                                                                                    $checkedNot = ($routesPermission->route == $subMenu->route)?'checked':'';
                                                                                @endphp
                                                                                @if ($checkedNot == 'checked')

                                                                                <li>
                                                                                    <a><div class="checkbox">
                                                                                            <label class="text-uppercase">
                                                                                                <input type="checkbox" name="{{ $permissionsType->permission_type }}[]" value="{{ $mainMenu->id.'/'.$subMenu->id.'/'.$permissionsType->permission_type }}" id="{{ $subMenu->id }}_{{ $permissionsType->permission_type }}" class="chk_user sub_of_{{ $mainMenu->id }}" {{ $checkedNot }}/>
                                                                                                 {{ $permissionsType->permission_type }}
                                                                                            </label>
                                                                                        </div>
                                                                                    </a>
                                                                                </li>
                                                                                @endif
                                                                                @endforeach

                                                                                <li>
                                                                                    <a><div class="checkbox">
                                                                                            <label class="text-uppercase">
                                                                                                <input type="checkbox" name="{{ $permissionsType->permission_type }}[]" value="{{ $mainMenu->id.'/'.$subMenu->id.'/'.$permissionsType->permission_type }}" id="{{ $subMenu->id }}_{{ $permissionsType->permission_type }}" class="chk_user sub_of_{{ $mainMenu->id }}"/>
                                                                                                 {{ $permissionsType->permission_type }}
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
                                        <div class="col-md-12 text-center mt-4">
											<button type="button" class="btn btn-primary" id="save_permission">	SAVE USER MENU PERMISSIONS</button>
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
        document.getElementById('permissions').value = checkedValues.join(',');
    }
    document.querySelectorAll('.chk_user').forEach(checkbox => {
        checkbox.addEventListener('change', updateHiddenInput);
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
            //dataType: 'json',
            data: {_token: '{{ csrf_token() }}','action':'formUser','permissionsUsersList':permissionsUsersList,'permissionType':permissionType,'permissions':permissions},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure you include the CSRF token
            },
            success: function(response){
                //alert(response);
                $('#overlay').hide();
                console.log(response);

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

