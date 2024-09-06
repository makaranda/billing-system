@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Nominal Categories</h3>
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
            <a href="#">Nominal Categories</a>
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
                                     <h1 class="text-uppercase">Nominal Categories</h1>

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
                                                    <span class="text-uppercase">Account Categories Information</span>
                                                    @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                        <button type="button" class="btn btn-xs btn-info pull-right ml-1 addCategoryButton" data-bs-toggle="modal" data-bs-target="#addCategoryModal" role="button">
                                                            <span class="glyphicon glyphicon-plus"></span>
                                                            Add New Account Category
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


<!-- Add Hotel Modal -->
<div class="modal fade" id="addCategoryModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><span class="fa fa-plus"></span> ADD/EDIT CATEGORIES</h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
            <form name="frm_add_account" id="frm_add_account" method="post">
                <input type="hidden" name="form_type" id="form_type" value="creditcardtypes.addcreditcardtypes">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="category_code">Category Code</label>
                                <input type="text" class="form-control" id="category_code" name="category_code" placeholder="Caegory Code" />
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label" for="category_name">Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Caegory Name" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label" for="pl_bl">Category Type</label>
                                <br/>
                                <input type="radio" name="pl_bl" id="pl_bl_p" value="P"> Profit & Loss (P)
                                &nbsp;
                                <input type="radio" name="pl_bl" id="pl_bl_b" value="B"> Balance Sheet (B)
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

    $('.addCategoryButton').on('click',function(){
        $('#frm_add_account').parsley().reset();
        $('#frm_add_account')[0].reset();

        $('#edit_id').val('');
        $('#form_type').val('nominalcategories.addnominalcategory');
    });


    $('#deleteRecordForm').parsley();
        $('#deleteRecordForm').on('submit', function(event){
            event.preventDefault();
            $('#overlay').show();
            var delete_record_id = $('#delete_record_id').val();
            var form_type = $('#delete_record_form').val();

            let updateUrl = '{{ route("nominalcategories.deletenominalcategory", ":id") }}';
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

    $('#frm_add_account').parsley();
    $('#frm_add_account').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var edit_id = ($('#edit_id').val())?$('#edit_id').val():'';
        var form_type = '';

        if($('#form_type').val() == 'nominalcategories.editnominalcategory'){
            form_type = '{{ route("nominalcategories.updatenominalcategory", ":id") }}';
            form_type = form_type.replace(':id', edit_id);
        }else{
            form_type = '{{ route("nominalcategories.addnominalcategory") }}';
        }

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
                $('#frm_add_account').parsley().reset();
                $('#frm_add_account')[0].reset();
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

        $('#form_type').val('nominalcategories.editnominalcategory');
        $('#edit_id').val(id);

        let updateUrl = '{{ route("nominalcategories.editnominalcategory", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);

        $.ajax({
            url : updateUrl,
            cache: false,
            data: {' _token': '{{ csrf_token() }}','id':id},
            type: 'GET',
            dataType: 'json',
            success : function(response) {
                //console.log("Error getting Product !"+response);
                $('#addCategoryModal').modal('show');
                if(response.accountcategories.id != ''){
                    $('#addCategoryModal #category_code').val(response.accountcategories.code);
                    $('#addCategoryModal #category_name').val(response.accountcategories.name);
                    $("#addCategoryModal input[name=pl_bl][value=" + response.accountcategories.pl_bl + "]").prop('checked', true);

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
                url : "{{ route('nominalcategories.fetchnominalcategories') }}",
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

