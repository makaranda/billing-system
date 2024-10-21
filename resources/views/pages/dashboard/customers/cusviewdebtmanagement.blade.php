@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Debt Management</h3>
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
            <a href="#">Debt Management</a>
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
                                     <h1 class="text-uppercase">Debt Management</h1>

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
                                            <span class="text-uppercase">Assigned Debts List For <strong id="assigned_debt_collector_name"></strong></span>
                                            <button type="button" class="btn btn-xs btn-danger pull-right ml-1">
                                                <span class="glyphicon glyphicon-plus"></span>
                                                Close
                                            </button>
                                        </div>
                                        <div class="panel panel-default p-3">
                                            <div class="panel-body">

                                            </div>
                                        </div>
                                        <div class="row"><div class="col-md-12"><span id="assigned_debt_list"></span></div></div>
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


<!-- Modal -->
<div id="remarks_modal" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">ADD REMARKS</h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
          <form method="post" id="frm_remarks">
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="control-label required">Remarks</label>
                              <textarea class="form-control" id="remarks" name="remarks"></textarea>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">Cancel</button>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <button type="submit" name="save" class="btn btn-primary form-control">Save</button>
                              <input type="hidden" id="assignment_id" name="assignment_id">
                          </div>
                      </div>
                  </div>
                </div>
              <div class="modal-footer" id="remarks_list"></div>
          </form>
      </div>
    </div>
  </div>


@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <style>

    </style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script>
    $(function () {
        $("#search_from_date").datepicker({
            autoclose: true,
            orientation: "bottom"
        });
        $("#search_to_date").datepicker({
            autoclose: true,
            orientation: "bottom"
        });
        $("#collection_date").datepicker({
            autoclose: true,
            orientation: "bottom"
        });
        $("#report_date").datepicker({
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


    $('#s_search').click(function(){
        var from_date = $("#search_from_date").val();
        var to_date = $("#search_to_date").val();
        var user_id = ($("#search_user_id").val())?$("#search_user_id").val():'';
        var min_precentage = ($("#search_performance_min").val())?$("#search_performance_min").val():'';
        var max_precentage = ($("#search_performance_max").val())?$("#search_performance_max").val():'';
        console.log(from_date+' - '+to_date+' - '+user_id);
        var page = 1;
        listTableDatas(page,from_date, to_date, user_id, min_precentage, max_precentage);
    });

    $('#btn_search').click(function(){
        var customer_id = $('#customer_id').val();
        var territory = $('#search_territory').val();
        var customer_group_id = $('#customer_group_id').val();
        var min_value = $('#min_value').val();
        var report_date = $('#report_date').val();
        var collection_bureau_id = $('#search_collection_bureau').val();
        var customer_active = $("#search_customer_active").val();
        var collection_date = $('#collection_date').val();

        get_filtered_debt_list(1,customer_id,min_value,report_date,territory,customer_group_id, collection_bureau_id, customer_active, collection_date);
    });

    function assign_selected_debt(customer_id){
        $('#selected_customer_id').val(customer_id);
        $('#assign_debt_modal').modal('show');
    }
    function showCustomerProfile(id){
        $('#customerProfileModal').modal('show');
    }

    $('#frm_assign_selected').parsley();
    $('#frm_assign_selected').on('submit', function(event) {
        event.preventDefault();
        var selectedCustomerId = $('#selected_customer_id').val();
        var selectedCustomerIds = $('#selected_customer_ids').val();
        if(selectedCustomerId !== "" || selectedCustomerIds !== ""){
            $('#overlay').show();
            var report_date = $('#report_date').val();
		    var selected_customer_id = $('#selected_customer_id').val();
		    var selected_customer_ids = $('#selected_customer_ids').val();
		    var collection_date = $('#collection_date').val();
		    var user_id = $('#user_id').val();
            $.ajax({
                url : "{{ route('cusdebtmanagement.assigndebtcollector') }}",
                cache: false,
                data: { '_token': '{{ csrf_token() }}', 'dcid': user_id, 'customer_id': selected_customer_id, 'customer_ids': selected_customer_ids, 'report_date': report_date, 'collection_date': collection_date },
                type: 'POST',
                dataType: 'json',
                success : function(response) {
                    $('#assign_debt_modal').modal('hide');
                    console.log(response);
                    //var arr = data.split("|");
                    $('#frm_assign_selected').parsley().reset();
                    $('#frm_assign_selected')[0].reset();
                    Swal.fire({
                        position: "bottom-end",
                        icon: response.messageType === 'success' ? "success" : "error",
                        title: response.message,
                        showConfirmButton: false,
                        timer: response.messageType === 'success' ? 4000 : 2500
                    });
                    get_filtered_debt_list(page=1, customer_id=0, min_value=0,report_date);
                    $('#overlay').hide();
                },
                error: function(xhr, status, error) {
                    console.log("Error getting Categories ! \n", xhr, status, error);
                    $('#overlay').hide();
                }
            });

        }else{
            Swal.fire({
                position: "bottom-end",
                icon: "error",
                title: "Select one or More Items before submit this form..!!",
                showConfirmButton: false,
                timer: 6000
            });
        }
    });

    function email_debts(user_id){
        var msg = '<p>Are you sure, You want to email this debt collector ?';
        var btns = '<button type="button" class="btn btn-default" data-bs-dismiss="modal">No</button>';
        btns += '<button type="button" class="btn btn-primary" data-bs-dismiss="modal" onClick="email_debts_confirmed('+ user_id +')">Yes</button>';

        $('#ConfirmModal .modal-body').html(msg);
        $('#ConfirmModal .modal-footer').html(btns);
        $('#ConfirmModal').modal('show');
    }

    function view_details(user_id,assigned_upto){
        console.log(user_id,assigned_upto);
    }

    function get_filtered_debt_list(page=1, customer_id=0, min_value=0,report_date, territory=0, customer_group_id=0, collection_bureau_id=0, customer_active='', collection_date=''){
        $('#overlay').show();
        console.log(page,customer_id,min_value,report_date,territory,customer_group_id,collection_bureau_id,customer_active,collection_date);
        if(report_date!='' && report_date!=null && report_date.length>0){
            $.ajax({
                url : "{{ route('cusdebtmanagement.fetchdebtfiltered') }}",
                cache: false,
                data: { _token: '{{ csrf_token() }}','page':page, 'customer_id':customer_id, 'min_value':min_value,'report_date':report_date,
                'territory':territory,'customer_group_id':customer_group_id,'collection_bureau_id':collection_bureau_id,'customer_active':customer_active,'collection_date':collection_date,'order':'a.customer_id ASC, a.transaction_date DESC' },
                type: 'GET',
                success : function(data) {
                    $("#overlay").hide();
                    $('#filtered_debt_list').html(data.html);
					$("#table2").DataTable({
						dom: 'Bfrtip',
				        buttons: [
				            'copyHtml5',
				            'excelHtml5',
				            'csvHtml5',
				            'pdfHtml5'
				        ],
				        paging: false,
				        "ordering": false
					});

					$('#btn_bulk_assign').click(function(){
						$("#assign_debt_modal").modal('show');
						var customer_ids = $("input:checkbox:checked").map(function(){
					      return $(this).val();
					    }).get();
						$("#selected_customer_id").val('');
						$("#selected_customer_ids").val(customer_ids);
					});
					$(".bulk_customer_ids").click(function(){
						alert();
					});

                    bindPaginationLinks2();
                },
                error: function(xhr, status, error) {
                    console.error("Error getting data!", xhr, status, error);
                    $('#overlay').hide();
                    Swal.fire({
                        position: "bottom-end",
                        icon: "error",
                        title: error,
                        showConfirmButton: false,
                        timer: 6000
                    });
                }
            });
        }else{
            $('#overlay').hide();
            Swal.fire({
                position: "bottom-end",
                icon: "error",
                title: "Report date required, Please try again..!!",
                showConfirmButton: false,
                timer: 6000
            });
        }
    }
    //listTableDatas();

    function listTableDatas(page=1, from_date=null, to_date=null, user_id=null, min_precentage=null, max_precentage=null ) {
        //alert();
        console.log("THIS",from_date);
        $('#overlay').show();
        //var cn_id = {{ session('CUS_CN_ID', 0) }};
        $.ajax({
                url : "{{ route('cusdebtmanagement.fetchdebtmanagements') }}",
                cache: false,
		        async: true,
                data: { _token: '{{ csrf_token() }}','page':page,'from_date':from_date, 'to_date':to_date, 'user_id':user_id, 'min_precentage':min_precentage, 'max_precentage':max_precentage,'order':'DESC'},
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
                    Swal.fire({
                        position: "bottom-end",
                        icon: "error",
                        title: error,
                        showConfirmButton: false,
                        timer: 6000
                    });
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
    function bindPaginationLinks2() {
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1]; // Get the page number
            //listTableDatas(page,null, null, 0, null, 0, 0, 1,null,null,null);
            get_filtered_debt_list(page);
        });
    }
    // Call the function initially
    bindPaginationLinks();
    bindPaginationLinks2();
    </script>
@endpush

