@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Pre Reminders</h3>
        <ul class="breadcrumbs mb-3">
          <li class="nav-home">
            <a href="{{ route('index.reminders') }}">
              <i class="icon-home"></i>
            </a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item text-capitalize">
            <a href="#">Pre Reminders</a>
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
                                     <h1 class="text-uppercase">Recurring Invoices</h1>

                                     @if (count($routesPermissions) == 1)
                                            @if ($routesPermissions[0]->route == request()->route()->getName() && Auth::user()->privilege === $routesPermissions[0]->userType)
                                                @if($routesPermissions[0]->show == 1)


                                      <div class="row justify-content-center">
                                        <div class="col-md-6 col-md-offset-3">
                                                <form method="post" >
                                                    <div class="row justify-content-start">
                                                        <div class="col-md-6">
                                                          <label for="invoice_frequency">Recurring Period</label>
                                                          <select class="form-control" id="invoice_frequency" name="invoice_frequency" >
                                                              <option value="0" data-days="0"> Non Recurring </option>
                                                          </select>
                                                      </div>
                                                        <div class="col-md-6">
                                                          <label for="po_number">PO #</label>
                                                          <div class="input-group">
                                                              <input type="text" class="form-control" id="po_number" name="po_number" value="" placeholder="PO Number" />
                                                              <span class="input-group-addon">
                                                              </span>
                                                          </div>
                                                      </div>
                                                        <div class="col-md-6">
                                                          <label for="invoice_date">Invoice Date</label>
                                                          <div class="input-group date p-0" id="datepicker1">
                                                              <input type="text" class="form-control" id="invoice_date" name="invoice_date" value="" required />
                                                              <span class="input-group-append">
                                                                <span class="input-group-text bg-light d-block">
                                                                    <i class="fa fa-calendar"></i>
                                                                </span>
                                                                </span>
                                                          </div>
                                                      </div>
                                                      <div class="col-md-6" title="Next invoice generation date">
                                                          <label for="due_date">Due Date</label>
                                                          <div class="input-group date p-0" id="datepicker2">
                                                              <input type="text" class="form-control" id="due_date" name="due_date" value="" required />
                                                              <span class="input-group-append">
                                                                <span class="input-group-text bg-light d-block">
                                                                    <i class="fa fa-calendar"></i>
                                                                </span>
                                                                </span>
                                                          </div>
                                                      </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group p-0">
                                                              <label for="invoice_type">Invoice Type</label>
                                                              <select class="form-control" id="invoice_type" name="invoice_type" required="required">
                                                                  <option value="">- Select Invoice Type -</option>
                                                                  <option value="proforma" selected>Proforma Invoice</option>
                                                                  <option value="invoice">Invoice</option>
                                                              </select>
                                                          </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                            <div class="form-group p-0">
                                                              <label for="fiscal_type">Fiscal Type</label>
                                                              <select class="form-control" id="fiscal_type" name="fiscal_type" required="required">
                                                                  <option value="">- Select Fiscal Type -</option>
                                                                  <option value="fiscalized">Need to fiscalize</option>
                                                                  <option value="non-fiscalized" selected="selected">No need to fiscalize [Already Fiscalized]</option>
                                                              </select>
                                                          </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                            <div class="form-group p-0">
                                                              <label for="invoice_product_category">Product Category</label>
                                                              <select class="form-control" id="invoice_product_category" name="invoice_product_category" required="required">
                                                                  <option value="" data-s_acc_id="">- SELECT CATEGORY -</option>
                                                              </select>
                                                          </div>
                                                      </div>


                                                      <div class="col-md-12">
                                                            <div class="form-group p-0">
                                                                <label class="control-label">Select Customer</label>
                                                                <input type="text" class="form-control" id="customer_name" name="customer_name" value="" placeholder="Search customer name" />
                                                                <input type="hidden" name="customer_id" id="customer_id">
                                                            </div>
                                                        </div>
                                                      <div class="col-md-12">
                                                          <label for="public_note">Public Note - (Display on the invoice)</label>
                                                              <textarea name="public_note" id="public_note" class="form-control" style="min-width: 100%"></textarea>
                                                      </div>
                                                      <div class="col-md-12">
                                                          <label for="private_note">Private Note</label>
                                                              <textarea name="private_note" id="private_note" class="form-control" style="min-width: 100%"></textarea>
                                                      </div>

                                                        <div class="col-md-12">
                                                            &nbsp;
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-primary" name="submit">
                                                                    GO TO ADD INVOICE<span class="glyphicon glyphicon-chevron-right"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                      <input type="hidden" name="inv_start_date" id="inv_start_date" />
                                                      <input type="hidden" name="inv_end_date" id="inv_end_date" />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                        @endif
                                        @endif
                                  @endif
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
        $("#datepicker1").datepicker({
            autoclose: true
        });
        $("#datepicker2").datepicker({
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

