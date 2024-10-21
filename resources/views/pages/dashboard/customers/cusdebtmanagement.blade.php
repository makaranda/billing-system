@extends('layouts.app')

@section('content')

@if(request()->has('debt_collector_id'))
    @php
        $debt_collector_id = request()->input('debt_collector_id');
        $assigned_upto_date = request()->input('assigned_upto_date');

        if($debt_collector_id > 0) {
            session(['DCID' => $debt_collector_id]);
            session(['REPORT_DATE' => $assigned_upto_date]);
        } else {
            $error_msg = "Invalid debt collector id, Please try again!";
        }
    @endphp
@endif

@if (session()->has('DCID'))
    @php
        $systemUsers = \App\Models\SystemUsers::where('status', 1)->where('id','=',session('DCID'))->first();
        $debt_collector_name = "***";
        if($systemUsers){
            $debt_collector_name = $systemUsers->full_name;
        }
    @endphp
@endif

@if(request()->has('close-window'))
    @php
        session()->forget('DCID');
    @endphp
@endif
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

                            @if (!session()->has('DCID'))

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <span class="text-uppercase">Debt Management - Debt Collectors List</span>
                                            @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                <button type="button" class="btn btn-xs btn-warning pull-right ml-1 addBankAccountButton" data-bs-toggle="modal" data-bs-target="#search_debt_modal" role="button">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                    Assign Debts
                                                </button>
                                            @endif
                                        </div>
                                        <div class="panel panel-default p-3">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="cn_date">From Date</label>
                                                            <div class="input-group datepicker_field" id="datepicker1">
                                                                <input type="text" class="form-control" id="search_from_date" name="search_from_date" value="{{  constant('WORKING_DATE') }}"/>
                                                                <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="cn_date">To Date</label>
                                                            <div class="input-group datepicker_field" id="datepicker1">
                                                                <input type="text" class="form-control" id="search_to_date" name="search_to_date" value="{{ session('report_to_date', '') }}"/>
                                                                <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="cn_date">Users</label>
                                                            <select class="form-control" id="s_status" name="s_status">
                                                                <option value="">- Any User -</option>
                                                                @foreach ($getAllSystemUsers as $system_users)
                                                                    <option value="{{ $system_users->id }}"
                                                                        {{ session('report_user_id') == $system_users->id ? 'selected' : '' }}>
                                                                        {{ $system_users->full_name }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 hide">
                                                        <div class="form-group">
                                                            <input type="text" min="0" max="100" id="search_performance_min" class="form-control" placeholder="Minimum precentage">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 hide">
                                                        <div class="form-group">
                                                            <input type="num" min="0" max="100" id="search_performance_max" class="form-control" placeholder="Maximum precentage">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 align-self-end">
                                                        <div class="form-group">
											                <input type="hidden" name="edit_page_no" id="edit_page_no" value="1">
                                                            <button type="button" id="s_search" class="btn btn-primary form-control">
                                                                <span class="glyphicon glyphicon-serach"></span> Search</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"><div class="col-md-12"><span id="table_list"></span></div></div>
                                    </div>
                                </div>
                            </div>

                            @else

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                      <div class="panel-heading">
                                          ASSIGNED DEBTS LIST	FOR <strong>{{ strtoupper($debt_collector_name) }}</strong>
                                          <button type="button" class="btn btn-xs btn-danger pull-right" style="margin:0px 2px;" onclick="close_window();">Close</button>
                                      </div>
                                      <div class="panel-body" id="assigned_debt_list"></div>
                                    </div>
                                </div>
                            </div>

                            @endif

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


<!-- Modal -->
<div id="closeWarningModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Warning</h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
      <form method="post">
        <div class="modal-body">
          <p>Do you want to close this window ?</p>
        </div>
          <div class="modal-footer">
          <div class="col-md-6">
          <div class="form-group">
              <button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">No</button>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
              <button type="submit" name="close_window" class="btn btn-primary form-control">Yes</button>
          </div>
          </div>
          </div>
      </form>
      </div>

    </div>
  </div>

   <!-- Confirm Modal -->
    <div class="modal fade" id="ConfirmModal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><span class="glyphicon glyphicon-remove"></span> Confirm !</h4>
            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body"></div>
          <div class="modal-footer"></div>
        </div>

      </div>
    </div>

<!-- Modal -->
<div id="assign_debt_modal" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">ASSIGN DEBTS TO A COLLECTOR</h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
      <form method="post" id="frm_assign_selected">
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label required">Debt Collector</label>
                          <select class="form-control searchable" id="user_id" name="user_id" style="width:100%;" required="">
                              <option value="">- SELECT DEBT COLLECTOR -</option>
                              @foreach ($getAllSystemUsers as $system_user)
                                  <option value="{{ $system_user->id }}">{{ $system_user->full_name }}</option>
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
                    </div>
                </div>
                <div class="col-md-6 pr-0">
                    <div class="form-group">
                        <button type="submit" name="save" class="btn btn-primary form-control">Save</button>
                        <input type="hidden" id="selected_customer_id" name="selected_customer_id">
                        <input type="hidden" id="selected_customer_ids" name="selected_customer_ids">
                    </div>
                </div>
            </div>
          </div>
      </form>
      </div>
    </div>
  </div>



<div id="search_debt_modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> SEARCH DEBTS TO ASSIGN</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> Close</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-3">
                  <label>Report Date (Debtors As At)</label>
                  <div class="form-group">
                      <div class="input-group datepicker_field" id="datepicker2">
                          <input type='text' class="form-control" id="report_date" name="report_date" value="{{ WORKING_DATE }}" />
                          <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Debts Greater Than </label>
                      <input type="text" name="min_value" id="min_value" class="form-control" value="1000">
                  </div>
              </div>
              <div class="col-md-3">
                    <div class="form-group">
                      <label for="search_collection_bureau">Collection Bureau (CUSTOMER)</label>
                      <select class="form-control" name="search_collection_bureau" id="search_collection_bureau">
                          <option value="">- ANY -</option>
                          @foreach ($getAllCollectionBureaus as $collectionBureau)
                              <option value="{{ $collectionBureau->id }}">{{ $collectionBureau->name }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-md-3">
                    <div class="form-group">
                      <label for="search_territory">TERRITORY</label>
                      <select class="form-control" name="search_territory" id="search_territory">
                          <option value="">- ANY -</option>
                          @foreach ($getAllterritories as $territory)
                              <option value="{{ $territory->id }}">{{ $territory->name }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-md-3">
                    <div class="form-group">
                      <label><small>PRODUCT GROUP</small></label>
                      <select id="customer_group_id" class="form-control">
                          <option value="">- For All Groups -</option>
                          @foreach ($getAllProductCategories as $productCategory)
                              <option value="{{ $productCategory->id }}">{{ $productCategory->name }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
            <div class="col-md-3">
                      <div class="form-group">
                          <label>Customer / Company</label>
                          <input type="text" class="form-control" name="customer_name" id="customer_name">
                          <input type="hidden" name="customer_id" id="customer_id">
                      </div>
                  </div>
              <div class="col-md-3">
                    <div class="form-group">
                      <label for="search_customer_active">Customer Status</label>
                      <select class="form-control" name="search_customer_active" id="search_customer_active">
                          <option value="">- ANY -</option>
                          <option value="1" selected>Active</option>
                          <option value="0">InActive</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label class="control-label required">Collection Date</label>
                      <div class="input-group datepicker_field" id="datepicker1">
                          <input type='text' class="form-control" id="collection_date" name="collection_date" required="required" value="{{ date("Y-m-t") }}" />
                          <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                  </div>
              </div>
              <div class="col-md-2">
                  <label>&nbsp;</label>
                  <div class="form-group">
                      <button class="btn btn-primary form-control" id="btn_search">Search</button>
                  </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12" id="filtered_debt_list"></div>
            </div>
        </div>
        <div class="modal-footer"></div>
        </div><!-- /.modal-body -->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

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

    // function view_details(user_id, assigned_upto) {
    //     console.log(user_id, assigned_upto);

    //     // Construct the URL dynamically with the user_id in JavaScript
    //     var redirectUrl = "{{ route('cusdebtmanagement.viewdebtmanagements', ':user_id') }}";
    //     redirectUrl = redirectUrl.replace(':user_id', user_id);

    //     // Use the redirect method with the constructed URL
    //     $.redirect(redirectUrl, {action: "viewdebtmanagements"}, "POST", "_self");
    // }

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

