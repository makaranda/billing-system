@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Product Categories</h3>
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
            <a href="#">Product Categories</a>
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
                                     <h1 class="text-uppercase">Product Categories</h1>

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
                                                    <span class="text-uppercase">Product Categories</span>
                                                    @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                        <button type="button" class="btn btn-xs btn-info pull-right ml-1 addCategoryModal" data-bs-toggle="modal" data-bs-target="#addCategoryModal" role="button">
                                                            <span class="glyphicon glyphicon-plus"></span>
                                                            Add New Expense Category
                                                        </button>
                                                    @endif
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="p-3" id="pro_categories_list"></div>
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
<div class="modal fade" id="addCategoryModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
           <h4 class="modal-title"><span class="fa fa-plus"></span> ADD/EDIT EXPENSE CATEGORY</h4>
           <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
            <form id="frmCategory" name="frmCategory" method="post">
                <input type="hidden" name="form_type" id="form_type" value="categories.addproductcategory"/>
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Category Department</label>
                            <select class="form-control" id="category_department" name="category_department">
                                <option value="">- SELECT -</option>
                                @foreach ($departmentsDetails as $departmentsDetail)
                                    <option value="{{ $departmentsDetail->id }}">{{ $departmentsDetail->code.' '.$departmentsDetail->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="category_name">Category Name</label>
                            <input type="text" name="category_name" id="category_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="sales_account_id">Sales Account</label>
                            <select name="sales_account_id" id="sales_account_id" class="form-control">
                                @foreach ($acAccountsDetails as $acAccountsDetail)
                                    <option value="{{ $acAccountsDetail->id }}">{{ $acAccountsDetail->code.' '.ucwords($acAccountsDetail->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer d-block">
                <div class="row">
                    <div class="col-md-6 pl-0">
                        <div class="form-group">
                            <button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">Cancel</button>
                            <input type="hidden" id="category_id" name="category_id" />
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

    $('.addCategoryModal').on('click',function(){
        $('#frmCategory').parsley().reset();
        $('#frmCategory')[0].reset();

        $('#category_id').val('');
        $('#form_type').val('categories.addproductcategory');
    });


    $('#frmCategory').parsley();
    $('#frmCategory').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var category_id = ($('#category_id').val())?$('#category_id').val():'';
        var form_type = '';

        if($('#form_type').val() == 'categories.updateproductcategory'){
            form_type = '{{ route("categories.updateproductcategory", ":id") }}';
            form_type = form_type.replace(':id', category_id);
        }else{
            form_type = '{{ route("categories.addproductcategory") }}';
        }
        //var form_type = ($('#form_type').val() == 'categories.addproductcategory')?'{{ route("categories.addproductcategory") }}':'{{ route("categories.updateproductcategory",'+category_id+') }}';

        console.log(form_type);
        $.ajax({
            url : form_type,
            cache: false,
            data: $(this).serialize() + '&_token={{ csrf_token() }}',
            type: 'POST',
            dataType: 'json',
            success : function(response) {
                $('#addCategoryModal').modal('hide');
                console.log(response);
                //var arr = data.split("|");
                $('#frmCategory').parsley().reset();
                $('#frmCategory')[0].reset();
                Swal.fire({
                    position: "bottom-end",
                    icon: response.messageType === 'success' ? "success" : "error",
                    title: response.message,
                    showConfirmButton: false,
                    timer: response.messageType === 'success' ? 4000 : 2500
                });
                listProCategories();
                $('#overlay').hide();
            },
            error: function(xhr, status, error) {
                console.log("Error getting Categories ! \n", xhr, status, error);
                $('#overlay').hide();
            }
        });

    });

    function deleteRecord(id,route_path){
        $('#deleteModal').modal('show');
        $('#delete_record_id').val(id);
        $('#delete_record_form').val(route_path);
    }


    $('#deleteRecordForm').parsley();
    $('#deleteRecordForm').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var delete_record_id = $('#delete_record_id').val();
        var form_type = $('#delete_record_form').val();

        let updateUrl = '{{ route("categories.deleteproductcategory", ":id") }}';
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
                console.log(response);
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
                listProCategories();
                $('#overlay').hide();
            },
            error: function(xhr, status, error) {
                console.log("Error getting Categories ! \n", xhr, status, error);
                $('#overlay').hide();
            }
        });

    });

    function editCategory(id){
        $('#overlay').show();

        $('#form_type').val('categories.updateproductcategory');
        $('#category_id').val(id);

        let updateUrl = '{{ route("categories.editproductcategory", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);

        $.ajax({
            url : updateUrl,
            cache: false,
            data: {' _token': '{{ csrf_token() }}','id':id},
            type: 'GET',
            dataType: 'json',
            success : function(response) {
                //console.log("Error getting Categories !"+response);
                $('#addCategoryModal').modal('show');
                //var arr = data.split("|");
                if(response.product_categories.id != ''){
                    $('#addCategoryModal #category_name').val(response.product_categories.name);
                    $('#addCategoryModal #category_department').val(response.product_categories.department_id).change();
                    $('#addCategoryModal #sales_account_id').val(response.product_categories.sales_account_id).change();
                }
                listProCategories();
                $('#overlay').hide();
            },
            error: function(response) {
                //console.log("Error All ! \n"+response);
                $('#overlay').hide();
            }
        });
    }

    listProCategories();

    function listProCategories() {
		//console.log("THIS");
		$('#overlay').show();
        $.ajax({
                url : "{{ route('productcategories.fetchprocategories') }}",
                cache: false,
                data: { _token: '{{ csrf_token() }}','order':'ASC'},
                type: 'GET',
                success : function(data) {
                    //console.log('Success: '+data);
                    $('#overlay').hide();
                    $('#pro_categories_list').html(data);

                },
                error: function(data) {
                    $('#overlay').hide();
                    //console.log('Error: '+data);
                    Swal.fire({
                        position: "bottom-end",
                        icon: "error",
                        title: data,
                        showConfirmButton: false,
                        timer: 2500
                    });
                }
        });
    }
    </script>
@endpush

