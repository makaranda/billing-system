@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">VAS</h3>
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
            <a href="#">VAS</a>
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
                                     <h1 class="text-uppercase">VAS</h1>

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
                                            <span class="text-uppercase">Customers Information</span>
                                            @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                <button type="button" class="btn btn-xs btn-info pull-right ml-1 addArchiveButton" data-bs-toggle="modal" data-bs-target="#addArchiveModal" role="button">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                    Add Value Added Services
                                                </button>
                                            @endif
                                        </div>
                                        <div class="panel panel-default p-3">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                          <div class="panel-body">

                                                            <form id="frmSearch" method="post">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                        <select name="search_category" id="search_category" class="form-control">
                                                                            <option value="">- SELECT CATEGORY -</option>
                                                                            @foreach ($getProductCategories as $getProductCategory)
                                                                                <option value="{{ $getProductCategory->id }}">{{ $getProductCategory->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <input type='text' class="form-control" id="search_customer_name" name="search_customer_name" placeholder="Customer Name" />
                                                                            <input type='hidden' id="search_customer_id" name="search_customer_id" placeholder="Customer Name" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <input type='text' class="form-control" id="search_description" name="search_description" placeholder="Description" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <div class="input-group datepicker_field" id="datepicker3">
                                                                                <input type='text' class="form-control" id="search_from_date" name="search_from_date"/>
                                                                                <span class="input-group-addon">
                                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <div class="input-group datepicker_field" id="datepicker4">
                                                                                <input type='text' class="form-control" id="search_to_date" name="search_to_date"/>
                                                                                <span class="input-group-addon">
                                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                        <select name="search_user" id="search_user" class="form-control">
                                                                            <option value="">- AUTHORIZED UPLOADED BY -</option>
                                                                            @foreach ($systemUsersDetails as $systemUser)
                                                                                <option value="{{ $systemUser->id }}">{{ $systemUser->full_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <button type="button" name="search" id="search" class="btn btn-primary form-control">Search</button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <div class="form-group">
                                                                            <button type="button" name="reset" id="reset" class="btn btn-default form-control">
                                                                            <span class="glyphicon glyphicon-refresh"></span>
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                            </div>
                                                        </form>
                                                          </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"><div class="col-md-12"><span id="table_list">No Value Added Services  available !</span></div></div>
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
<div class="modal fade" id="addArchiveModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> ADD/EDIT VALUE ADDED SERVICES (VAS)</h4>
            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
        <form id="frm_add_archives" method="post" action="" enctype='multipart/form-data'>
            <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="start_date">Service Start Date</label>
                        <div class="input-group datepicker_field" id="datepicker1">
                            <input type='text' class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-d',strtotime(WORKING_DATE)) }}" required />
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label" for="customer_name">Customer Name</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Search Customer" required />
                        <input type="hidden" name="customer_id" id="customer_id">
                        <input type="hidden" name="archive_name" id="archive_name" value="Customer doc Attachment">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="category">Connection Type</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="">- SELECT -</option>
                            @foreach ($getProductCategories as $getProductCategory)
                                <option value="{{ $getProductCategory->id }}">{{ $getProductCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label" for="product">Product</label>
                        <select name="product" id="product" class="form-control" required>
                            <option value="">- SELECT CATEGORY -</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="qty">Qty</label>
                        <input type="number" class="form-control" id="qty" name="qty" placeholder="Qty" min="1" value="1"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="description">Service Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="contract_date">Contract end Date</label>
                        <input type="text" class="form-control" id="contract_date" name="contract_date" placeholder="Select service expiry date (optionl)" />
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label" for="authorized_by">Authorized By</label>
                        <select class="form-control" name="authorized_by" id="authorized_by">
                            <option value="">Select a User</option>
                            @foreach ($systemUsersDetails as $systemUser)
                                <option value="{{ $systemUser->id }}">{{ $systemUser->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="attach">Attach to Invoice</label>
                        <select class="form-control" name="attach" id="attach">
                            <option value="all">All Invoice</option>
                            <option value="recurring">Recurring Invoice</option>
                            <!--<option value="generated">Generated Invoice</option>-->
                            <option value="no">Do not show</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group invoices">
                        <label class="control-label" for="invoices">Invoice Ids</label>
                        <!--<input type="text" name="invoices" class="form-control" id="invoices">-->
                        <select name="invoices" class="form-control" id="invoices">
                            <option value="">-Select a Invoice-</option>
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
    $('.searchable').select2();

    $(function () {
        $("#start_date_0000").datepicker({
            autoclose: true,
            orientation: "bottom"
        });
        $("#search_from_date").datepicker({
            autoclose: true,
            orientation: "bottom"
        });
        $("#search_to_date").datepicker({
            autoclose: true,
            orientation: "bottom"
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

    $('#search').click(function(){
        var category = $('#search_category').val();
        var customer_id = $('#search_customer_id').val();
        var description = $('#search_description').val();
        var reference = $('#search_reference').val();
        var from_date = $('#search_from_date').val();
        var to_date = $('#search_to_date').val();
        var user = $('#search_user').val();

        listTableDatas(from_date,to_date,customer_id,category,description,reference,user);
    });

    $('#reset').click(function(){
        listTableDatas();
    });

    $('#category').on('change',function(){
        //cusvas.getproductcategory
        let category = $(this).val();
        $.ajax({
            url : "{{ route('cusvas.getproductcategory') }}",
            cache: false,
            data: 'category='+category+'&_token={{ csrf_token() }}',
            type: 'POST',
            dataType: 'json',
            success : function(response) {
                console.log(response);
                $('#product').html(response.select);
				// if(edit_product_id>0){
				// 	$('#product').val(edit_product_id).change();
				// }
				// else {
				// 	$('#product').val("").change();
				// }
            },
            error: function(xhr, status, error) {
                console.log("Error getting Categories ! \n", xhr, status, error);

            }
        });
    });

    $('#deleteRecordForm').parsley();
    $('#deleteRecordForm').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var delete_record_id = $('#delete_record_id').val();
        var form_type = $('#delete_record_form').val();

        let updateUrl = '{{ route("cusvas.deletevas", ":id") }}';
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

    $('#frm_add_archives').parsley();
    $('#frm_add_archives').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var receipt_id = ($('#receipt_id').val()) ? $('#receipt_id').val() : '';
        var form_type = '';

        if($('#form_type').val() == 'cusvas.editvas'){
            form_type = '{{ route("cusvas.updatevas", ":id") }}';
            form_type = form_type.replace(':id', receipt_id);
        }else{
            form_type = '{{ route("cusvas.addvas") }}';
        }

        // Use FormData to include file
        var formData = new FormData(this);

        // Append the CSRF token manually
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url : form_type,
            cache: false,
            data: formData,
            type: 'POST',
            dataType: 'json',
            contentType: false, // Important for file upload
            processData: false, // Important for file upload
            success : function(response) {
                $('#addAttachmentModal').modal('hide');
                console.log(response);
                $('#frm_add_attachments').parsley().reset();
                $('#frm_add_attachments')[0].reset();
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
                console.log("Error getting Fiscal Receipt! \n", xhr, status, error);
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

    listTableDatas();

    function listTableDatas(page=1,from_date=null,to_date=null,customer_id=null,category=null,description=null,approved_by=null) {
        //alert();
        //console.log("THIS");
        $('#overlay').show();
        $.ajax({
                url : "{{ route('cusvas.fetchvas') }}",
                cache: false,
                data: { _token: '{{ csrf_token() }}','page':page,'from_date':from_date,'to_date':to_date,'customer_id':customer_id,'category':category,
		'description':description,'approved_by':approved_by,'order':'ASC'},
                type: 'GET',
                success : function(response) {
                    //console.log('Success: '+data);
                    $('#overlay').hide();
                    $('#table_list').html(response.html);

                    bindPaginationLinks();
                },
                error: function(xhr, status, error) {
                    console.error("Error getting data!", xhr, status, error);
                    $('#overlay').hide();
                }
        });
    }

        // Function to handle pagination link clicks
    function bindPaginationLinks() {
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1]; // Get the page number
            //listTableDatas(page,null, null, 0, null, 0, 0, 1,null,null,null);
            listTableDatas(page);
        });
    }

    // Call the function initially
    bindPaginationLinks();
    </script>
@endpush

