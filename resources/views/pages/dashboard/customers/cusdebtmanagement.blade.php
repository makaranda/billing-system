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

                            @if (!session()->has('DCID'))

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <span class="text-uppercase">Debt Management - Debt Collectors List</span>
                                            @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                <button type="button" class="btn btn-xs btn-info pull-right ml-1 addBankAccountButton" data-bs-toggle="modal" data-bs-target="#addBankAccountModal" role="button">
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

@endsection

@push('css')
    <style>

    </style>
@endpush

@push('scripts')
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
        listTableDatas(from_date, to_date, user_id, min_precentage, max_precentage);
    });


    //listTableDatas();

    function listTableDatas(page=1, from_date=null, to_date=null, user_id=null, min_precentage=null, max_precentage=null ) {
        //alert();
        //console.log("THIS");
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

    // Call the function initially
    bindPaginationLinks();
    </script>
@endpush

