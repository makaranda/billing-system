@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Message Formats</h3>
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
            <a href="#">Message Formats</a>
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
                                     <h1 class="text-uppercase">Message Formats</h1>

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
                                                    <span class="text-uppercase">Message Formats Information</span>
                                                    @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                        <button type="button" class="btn btn-xs btn-info pull-right ml-1 addTaxModal" data-bs-toggle="modal" data-bs-target="#addTaxModal" role="button">
                                                            <span class="glyphicon glyphicon-plus"></span>
                                                            Add New Tax
                                                        </button>
                                                    @endif
                                                </div>

                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <form id="frm_add_format" method="post">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Message Format Name</label>
                                                                            <input type="text" name="name" id="name" class="form-control"></input>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Format Type</label>
                                                                        <select name="format_type" id="format_type" class="form-control">
                                                                            <option value="">- Select Type -</option>
                                                                            <option value="emails">Emails</option>
                                                                            <option value="invoice_terms_n_conditions">Invoice Terms & Conditions</option>
                                                                            <option value="new_invoice" data-tags="[invoice_period],[invoice_no],[invoice_date],[invoice_duedate],[customer_code],[customer_name],[invoice_link],[invoice_amount],[balance]">New Invoice</option>
                                                                            <option value="first_reminder" data-tags="[invoice_no],[invoice_date],[invoice_duedate],[customer_code],[customer_name],[invoice_link],[invoice_no],[invoice_amount],[balance]">First Reminder</option>
                                                                            <option value="second_reminder" data-tags="[invoice_no],[invoice_date],[invoice_duedate],[customer_code],[customer_name],[invoice_link],[invoice_no],[invoice_amount],[balance]">Second Reminder</option>
                                                                            <option value="final_reminder" data-tags="[customer_name],[statement_link], [invoice_amount] , [balance]">Final Reminder</option>
                                                                            <option value="letter">Letter</option>
                                                                            <option value="invoice_suspend">Invoice Suspend</option>
                                                                            <option value="invoice_terminate">Invoice Terminate</option>
                                                                            <option value="prepaid_followup" data-tags="[customer_name],[customer_code],[expiry_date],[product_name],[service_name],[system_user],[user_phone],[user_email],[SYSTEM_COMPANY],[SYSTEM_ADDRESS],[SYSTEM_TELEPHONE],[SYSTEM_EMAIL],[SYSTEM_WEB],[SYSTEM_LETTER_HEAD]">Prepaid Fallowup</option>
                                                                            <option value="prepaid_followup_sms">Prepaid Fallowup SMS</option>
                                                                            <option value="send_statement" data-tags="[customer_code],[customer_name],[statement_link],[balance]">Send Statement</option>
                                                                            <option value="quotation_email" data-tags="[customer_name],[quoattion_no]">Quotation Email</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div>
                                                                            <label>Available tags</label>
                                                                            <span id="available_tags"></span><br/>
                                                                            <span>(Use these tags to replace with value when the letter generating)</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Message Format Content</label>
                                                                            <textarea name="content" class="form-control" id="editor"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4 col-md-offset-4">
                                                                        <input type="hidden" name="edit_id" id="edit_id">
                                                                        <button class="btn btn-primary form-control" id="add_btn" name="add_btn" type="submit">ADD</button>
                                                                    </div>
                                                                </div>
                                                                </form>
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
    </script>
@endpush

