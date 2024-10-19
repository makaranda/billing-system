@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Customers</h3>
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
            <a href="#">Customers</a>
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
                                     <h1 class="text-uppercase">Customers</h1>

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
                                                <button type="button" class="btn btn-xs btn-info pull-right ml-1 addCustomerButton" data-bs-toggle="modal" data-bs-target="#addCustomerModal" role="button">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                    Add New Customer
                                                </button>
                                            @endif
                                        </div>
                                        <div class="panel panel-default p-3">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                          <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <input type="text" id="search_customer_code" class="form-control" placeholder="Code">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <input type="text" id="search_customer_name" class="form-control" placeholder="Name">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <input type="text" id="search_customer_email" class="form-control" placeholder="Email">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <input type="text" id="search_customer_telephone" class="form-control" placeholder="Telephone/Mobile">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <select class="form-control" id="search_group" name="search_group">
                                                                                <option value="" data-s_acc_id="">- All Groups -</option>
                                                                                @foreach ($productCategoriesDetails as $productCategory)
                                                                                    <option value="{{ $productCategory->id }}" data-s_acc_id="{{ $productCategory->sales_account_id }}">{{ $productCategory->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <button type="button" id="search_customer" class="btn btn-primary form-control" title="Search">
                                                                        <span class="glyphicon glyphicon-search"></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="edit_page_no" id="edit_page_no" value="1">
                                                          </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"><div class="col-md-12"><span id="table_list">No customers available !</span></div></div>
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



<div id="addCustomerModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">ADD/EDIT CUSTOMER</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body pl-5 pr-5 pb-4">
              <form id="frm_add_customer" method="post">
                 <input type="hidden" name="form_type" id="form_type" value="cuscustomers.addcustomer">
                 <div class="row">
                 <div class="col-md-12" id="err_msg_div"></div>
                 <div class="col-md-12">
                     <ul class="nav nav-tabs" role="tablist">
                         <li role="presentation" class="nav-item">
                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Details</button>
                         </li>
                         <li role="presentation" class="nav-item">
                            <button class="nav-link" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="false">Account</button>
                         </li>
                         <li role="presentation" class="nav-item">
                            <button class="nav-link" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">Contacts</button>
                         </li>
                         <li role="presentation" class="nav-item">
                            <button class="nav-link" id="terms_n_conditions-tab" data-bs-toggle="tab" data-bs-target="#terms_n_conditions" type="button" role="tab" aria-controls="terms_n_conditions" aria-selected="false">Terms</button>
                         </li>
                         <li role="presentation" class="nav-item">
                            <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab" aria-controls="notes" aria-selected="false">Notes</button>
                         </li>
                         <li role="presentation" class="nav-item">
                            <button class="nav-link" id="subAccounts-tab" data-bs-toggle="tab" data-bs-target="#subAccounts" type="button" role="tab" aria-controls="subAccounts" aria-selected="false">Sub Accounts</button>
                         </li>
                     </ul>
                     <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <div class="row">
                              <div class="col-md-6">
                                  <div class="row">
                                      <div class="col-md-4">
                                          <div class="form-group">
                                              <label class="control-label required" for="c_code">Code</label>
                                              <input type="text" class="form-control" name="c_code" id="c_code" required="required">
                                          </div>
                                      </div>
                                      <div class="col-md-8">
                                          <div class="form-group">
                                              <label class="control-label required" for="c_company">Customer / Company Name</label>
                                              <input type="text" class="form-control" name="c_company" id="c_company" required="required">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="control-label required" for="c_address">Street Address</label>
                                      <input type="text" class="form-control" id="c_address" name="c_address" required="required">
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label class="control-label required" for="c_city">City</label>
                                              <input type="text" class="form-control" id="c_city" name="c_city" required="required">
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="c_postal_code">Postal Code</label>
                                              <input type="text" class="form-control" id="c_postal_code" name="c_postal_code">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="control-label required" for="c_territory_id">Territory</label>
                                      <select class="searchable form-control" id="c_territory_id" name="c_territory_id" required="required">
                                          <option value="">- Select Territory - </option>
                                          @foreach ($getAllterritories as $territory)
                                            <option value="{{ $territory->id }}">{{ $territory->name }} </option>
                                          @endforeach
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label class="control-label required" for="c_telephone">Telephone</label>
                                              <input type="text" class="form-control" id="c_telephone" name="c_telephone" required="required">
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="c_mobile">Mobile</label>
                                              <input type="text" class="form-control" id="c_mobile" name="c_mobile"  required>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="c_email">Email</label>
                                      <input type="text" class="form-control" id="c_email" name="c_email">
                                  </div>
                                  <div class="form-group">
                                      <label for="c_fax">Fax</label>
                                      <input type="text" class="form-control" id="c_fax" name="c_fax">
                                  </div>
                                  <div class="form-group">
                                      <label for="c_web">Web Site</label>
                                      <input type="text" class="form-control" id="c_web" name="c_web">
                                  </div>
                              </div>
                              <div class="col-md-12">
                                  <div class="row">
                                      <div class="col-md-3">
                                          <div class="form-group">
                                              <label for="c_currency">Currency</label>
                                              <select class="form-control" id="c_currency" name="c_currency">
                                                @foreach ($getAllcurrencies as $currency)
                                                  <option value="{{ $currency->id }}">{{ $currency->code }} </option>
                                                @endforeach
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-md-3">
                                          <div class="form-group">
                                              <label class="control-label required" for="c_category">Category</label>
                                              <select class="form-control" id="c_category" name="c_category" required="required">
                                                  <option value="">- Select Category - </option>
                                                  @foreach ($getAllCustomerGroup as $customerGroup)
                                                    <option value="{{ $customerGroup->id }}">{{ $customerGroup->name }} </option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-md-3">
                                          <div class="form-group">
                                              <label class="control-label required" for="c_group">Product Group</label>
                                              <select class="form-control" id="c_group" name="c_group" required="required">
                                                  <option value="">- Select Group - </option>
                                                  @foreach ($productCategoriesDetails as $productCategory)
                                                    <option value="{{ $productCategory->id }}">{{ $productCategory->name }} </option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-md-3">
                                          <div class="form-group">
                                              <label for="c_branch">Branch</label>
                                              <select class="form-control" id="c_branch" name="c_branch">
                                                  <option value="">- Select Branch - </option>
                                                  @foreach ($getAllBranches as $branche)
                                                    <option value="{{ $branche->id }}">{{ $branche->name }} </option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="tab-pane" id="account" role="tabpanel" aria-labelledby="account-tab">
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="c_vat_reg_no">VAT Registration No.</label>
                                      <input type="text" class="form-control" id="c_vat_reg_no" name="c_vat_reg_no" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="c_wht_reg_no">WHT Excemption No.</label>
                                      <input type="text" class="form-control" id="c_wht_reg_no" name="c_wht_reg_no" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="c_price_type">Default Price Type</label>
                                      <select class="form-control" id="c_price_type" name="c_price_type" required>
                                          <option value="">- Select Default Price Type - </option>
                                          @foreach ($getAllPriceTypes as $priceTypes)
                                            <option value="{{ $priceTypes->id }}">{{ $priceTypes->name }} </option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="c_last_credit_review">Last Credit Review</label>
                                              <div class="input-group" id="datepicker1">
                                                  <input type="text" class="form-control" id="c_last_credit_review" name="c_last_credit_review" />
                                                  <span class="input-group-addon">
                                                  <span class="glyphicon glyphicon-calendar"></span>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="c_next_credit_review">Next Credit Review</label>
                                              <div class="input-group" id="datepicker2">
                                                  <input type="text" class="form-control" id="c_next_credit_review" name="c_next_credit_review" />
                                                  <span class="input-group-addon">
                                                  <span class="glyphicon glyphicon-calendar"></span>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="c_credit_limit">Credit Limit</label>
                                              <input type="text" class="form-control" id="c_credit_limit" name="c_credit_limit" value="0.00">
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="c_book_balance">Book Balance</label>
                                              <input type="text" class="form-control" id="c_book_balance" name="c_book_balance" value="0.00">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="c_collection_bureau">Collection Bureau</label>
                                      <select class="form-control" id="c_collection_bureau" name="c_collection_bureau" required>
                                          <option value="">- Select Collection Bureau - </option>
                                          @foreach ($getAllCollectionBureaus as $collectionBureau)
                                            <option value="{{ $collectionBureau->id }}">{{ $collectionBureau->name }} </option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="c_settlement_due_days">Settlement Due Days</label>
                                              <input type="text" class="form-control" id="c_settlement_due_days" name="c_settlement_due_days" value="0">
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="c_discount_period">Discount Period (Days)</label>
                                              <input type="text" class="form-control" id="c_discount_period" name="c_discount_period" value="0">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="c_interest">Interest (%)</label>
                                              <input type="text" class="form-control" id="c_interest" name="c_interest" value="0.00">
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="c_settlement_discount">Settlement Discount (%)</label>
                                              <input type="text" class="form-control" id="c_settlement_discount" name="c_settlement_discount" value="0.00">
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="tab-pane" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="row">
                                      <div class="col-md-12"><h4>Contact Person 1</h4></div>
                                  </div>
                                  <div class="form-group">
                                      <label for="c_position1">Position</label>
                                      <input type="text" class="form-control" id="c_position1" name="c_position1">
                                  </div>
                                  <div class="form-group">
                                      <label for="c_name1">Contact Person</label>
                                      <input type="text" class="form-control" id="c_name1" name="c_name1">
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="c_telephone1">Contact Telephone</label>
                                              <input type="text" class="form-control" id="c_telephone1" name="c_telephone1">
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="c_mobile1">Contact Mobile</label>
                                              <input type="text" class="form-control" id="c_mobile1" name="c_mobile1">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="c_email1">Contact Email</label>
                                      <input type="text" class="form-control" id="c_email1" name="c_email1">
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="row">
                                      <div class="col-md-12"><h4>Contact Person 2</h4></div>
                                  </div>
                                  <div class="form-group">
                                      <label for="c_position2">Position</label>
                                      <input type="text" class="form-control" id="c_position2" name="c_position2">
                                  </div>
                                  <div class="form-group">
                                      <label for="c_name2">Contact Person</label>
                                      <input type="text" class="form-control" id="c_name2" name="c_name2">
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="c_telephone2">Contact Telephone</label>
                                              <input type="text" class="form-control" id="c_telephone2" name="c_telephone2">
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="c_mobile2">Contact Mobile</label>
                                              <input type="text" class="form-control" id="c_mobile2" name="c_mobile2">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="c_email2">Contact Email</label>
                                      <input type="text" class="form-control" id="c_email2" name="c_email2">
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="tab-pane" id="terms_n_conditions" role="tabpanel" aria-labelledby="terms_n_conditions-tab">
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label for="c_t_n_c">Terms and Conditions</label>
                                      <textarea class="form-control" id="c_t_n_c" name="c_t_n_c"></textarea>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="tab-pane" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label for="c_notes">Special Notes</label>
                                      <textarea class="form-control" id="c_notes" name="c_notes"></textarea>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="tab-pane" id="subAccounts" role="tabpanel" aria-labelledby="subAccounts-tab">
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="sub_customer_name">SUB ACCOUNTS</label>
                                      <input type="text" class="form-control" id="sub_customer_name" name="sub_customer_name">
                                      <input type="hidden" id="sub_customer_id" name="sub_customer_id">

                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="btn_add_subaccounts">&nbsp;</label>
                                      <br/>
                                      <button type="button" class="btn btn-primary" id="btn_add_subaccounts">Add</button>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12">
                                  <div id="div_sub_accounts">Loading....</div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <hr/>
                  <div class="col-md-12">
                      <div class="row">
                          <div class="col-md-6">
                              <button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">
                              CANCEL
                              </button>
                          </div>
                          <div class="col-md-6">
                              <button type="submit" class="btn btn-primary form-control" id="c_submit" name="c_submit">
                              <span class="glyphicon glyphicon-plus"></span> SAVE CUSTOMER
                              </button>
                              <input type="hidden" id="edit_id" name="edit_id" />
                          </div>
                      </div>
                  </div>
              </div>
              </div>
              </form>
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
    <script src="{{ url('public/vendors/ckeditor/ckeditor.js') }}"></script>
    <script>

    $(function () {
        $("#datepicker").datepicker({
            autoclose: true
        });
    });

    CKEDITOR.replace( 'email_body' );

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

    $('.addCustomerButton').click(function(){
        $('#frm_add_customer').parsley().reset();
        $('#frm_add_customer')[0].reset();

        $('#edit_id').val('');
        $('#form_type').val('cuscustomers.addcustomer');
        //toggleAudio();
    });

    $(document).ready(function() {
        $("#statement_type").on('change',function() {
            if($(this).val() == 'daterange'){
                $('#div_daterange').removeClass('d-none');
            }else{
                ///loadCustomerStatement();
                $('#div_daterange').addClass('d-none');
            }
        });
    });

    $('#search_customer').click(function(){
        var code = $('#search_customer_code').val();
        var name = $('#search_customer_name').val();
        var email = $('#search_customer_email').val();
        var telephone = $('#search_customer_telephone').val();
        var group = $('#search_group').val();
        var currrent_page = $("#edit_page_no").val();

        listTableDatas(currrent_page,code,name,email,telephone,group);
    });

    function toggleAudio() {
        var audioElement = document.getElementById('error_sound');
        if (audioElement.paused) {
            audioElement.play();
        } else {
            audioElement.pause();
        }
    }
    function showCustomerProfile(id){

        $('#overlay').show();

        let updateUrl = '{{ route("cuscustomers.fetchstatementcustomer", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);

        $.ajax({
                url : updateUrl,
                cache: false,
                data: { _token: '{{ csrf_token() }}','order':'ASC'},
                type: 'GET',
                success : function(data) {
                    //console.log('Success: '+data);

                    $('#overlay').hide();
                    $('#customerProfileModal modal-body').html(data);

                    $('#customerProfileModal').modal('show');
                },
                error: function(xhr, status, error) {
                    //console.log("Error getting Categories ! \n", xhr, status, error);
                    $('#overlay').hide();
                }
        });

    }

    function showCustomerProfile(id){
        $('#customerProfileModal').modal('show');
    }

    function viewCustomerStatement(id = null, email = null){
        $('#btn_statementemail').attr('data-cus-id',id);
        $('#btn_statementemail').attr('data-email',email);
        $('#customerStatementModal').modal('show');
    }

    function viewActivity(id){

        $('#overlay').show();

        let updateUrl = '{{ route("cuscustomers.fetchstatementcustomer", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);

        $.ajax({
                url : updateUrl,
                cache: false,
                data: { _token: '{{ csrf_token() }}','order':'ASC'},
                type: 'GET',
                success : function(data) {
                    //console.log('Success: '+data);

                    $('#overlay').hide();
                    $('#viewStatementModal .modal-body').html(data);

                    $('#viewStatementModal').modal('show');
                },
                error: function(xhr, status, error) {
                    //console.log("Error getting Categories ! \n", xhr, status, error);
                    $('#overlay').hide();
                }
        });
    }


	$('#btn_generateStatement').click(function(){
		loadCustomerStatement();
	});

	$('#btn_statementemail').click(function() {
        $('#overlay').show();
        var customerId = $(this).attr('data-cus-id');
        var customerEmail = $(this).attr('data-email');

        // Corrected route name
        let updateUrl = '{{ route("cuscustomers.getemaildetailscustomer", ":id") }}';
        updateUrl = updateUrl.replace(':id', customerId);

        $.ajax({
            url: updateUrl,
            cache: false,
            data: {
                '_token': '{{ csrf_token() }}',
                'type': 'send_statement',
                'customer_id': customerId,
                'cus_email': customerEmail
            },
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                //console.log(response.message_format);
                 if (response.customers.id != '') {
                     $('#customerStatementEmailModal #email_subject').val(response.email_message.name);
                     $('#customerStatementEmailModal #to_email').val(response.customers.email);
                     $('#customerStatementEmailModal #cc_email').val('');
                     $('#customerStatementEmailModal #c_mobile').val('');
                     CKEDITOR.instances.email_body.setData(response.email_message);

                     $('#customerStatementEmailModal #format_id').val(response.message_format.id);
                     $('#customerStatementEmailModal #format_type').val(response.message_format.type);
                     $('#customerStatementEmailModal #file_name').val(response.message_format.name);
                     $('#customerStatementEmailModal #customer_id').val(customerId);

                     $('#customerStatementEmailModal').modal('show');
                 }
                $('#customerStatementEmailModal').modal('show');
                $('#overlay').hide();
            },
            error: function(response) {
                $('#overlay').hide();
            }
        });
    });



    $('#deleteRecordForm').parsley();
    $('#deleteRecordForm').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var delete_record_id = $('#delete_record_id').val();
        var form_type = $('#delete_record_form').val();

        let updateUrl = '{{ route("cuscustomers.deletecustomer", ":id") }}';
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

    $('#frm_add_customer').parsley();
    $('#frm_add_customer').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var edit_id = ($('#edit_id').val())?$('#edit_id').val():'';
        var form_type = '';

        if($('#form_type').val() == 'cuscustomers.editcustomer'){
            form_type = '{{ route("cuscustomers.updatecustomer", ":id") }}';
            form_type = form_type.replace(':id', edit_id);
        }else{
            form_type = '{{ route("cuscustomers.addcustomer") }}';
        }

        //console.log(form_type);
        $.ajax({
            url : form_type,
            cache: false,
            data: $(this).serialize() + '&_token={{ csrf_token() }}',
            type: 'POST',
            dataType: 'json',
            success : function(response) {
                $('#addCustomerModal').modal('hide');
                console.log(response);
                //var arr = data.split("|");
                $('#frm_add_customer').parsley().reset();
                $('#frm_add_customer')[0].reset();
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

    function enable_disable_delete_customer(id,route_path,type){
        $('#deleteModal').modal('show');

        $('#delete_record_id').val(id);
        $('#delete_record_form').val(route_path);
        $('#delete_record_type').val(type);

        //console.log(id+'-'+route_path+'-'+type);

        if(type == 'Disable'){
            $('.deleteModelTopic').text('Deactive Record');
            $('.deleteModelDesctiption').text('Are you sure to Inactive this Record now...!!!');
            $('.deleteModelBtn').text('Disable');
            $('.deleteModelBtn').removeClass('btn-danger');
            $('.deleteModelBtn').addClass('btn-danger');
        }else if(type == 'Enable'){
            $('.deleteModelTopic').text('Active Record');
            $('.deleteModelDesctiption').text('Are you sure to active this Record now...!!!');
            $('.deleteModelBtn').text('Active');
            $('.deleteModelBtn').removeClass('btn-danger');
            $('.deleteModelBtn').addClass('btn-success');
        }else if(type == 'Delete'){
            $('.deleteModelTopic').text('Delete Record');
            $('.deleteModelDesctiption').text('Are you sure to Delete this Record now...!!!');
            $('.deleteModelBtn').text('Delete');
            $('.deleteModelBtn').removeClass('btn-success');
            $('.deleteModelBtn').addClass('btn-danger');
        }
    }


    function editCustomer(id){
        $('#overlay').show();

        $('#form_type').val('cuscustomers.editcustomer');
        $('#edit_id').val(id);

        let updateUrl = '{{ route("cuscustomers.editcustomer", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);

        $.ajax({
            url : updateUrl,
            cache: false,
            data: {' _token': '{{ csrf_token() }}','id':id},
            type: 'GET',
            dataType: 'json',
            success : function(response) {
                //console.log("Error getting Product !"+response);
                $('#addCustomerModal').modal('show');
                if(response.customers.id != ''){

                    $('#addCustomerModal #c_code').val(response.customers.code);
                    $('#addCustomerModal #c_company').val(response.customers.company);
                    $('#addCustomerModal #c_telephone').val(response.customers.telephone);
                    $('#addCustomerModal #c_mobile').val(response.customers.mobile);
                    $('#addCustomerModal #c_address').val(response.customers.address);
                    $('#addCustomerModal #c_email').val(response.customers.email);
                    $('#addCustomerModal #c_city').val(response.customers.city);
                    $('#addCustomerModal #c_postal_code').val(response.customers.postal_code);
                    $('#addCustomerModal #c_fax').val(response.customers.fax);
                    $('#addCustomerModal #c_territory_id').val(response.customers.territory_id).change();
                    $('#addCustomerModal #c_web').val(response.customers.web_site);

                    //$('#addCustomerModal #c_currency').val(response.customers.currency_id).change();
                    $('#addCustomerModal #c_currency').val(response.customers.currency_id).change();
                    $('#addCustomerModal #c_category').val(response.customers.category_id).change();
                    $('#addCustomerModal #c_group').val(response.customers.group_id).change();
                    $('#addCustomerModal #c_branch').val(response.customers.branch_id).change();

                    console.log(response.customers.currency_id+'/'+response.customers.category_id+'/'+response.customers.group_id);

                    $('#addCustomerModal #c_vat_reg_no').val(response.customers.vat_reg_no);
                    $('#addCustomerModal #c_credit_limit').val(response.customers.credit_limit);
                    $('#addCustomerModal #c_book_balance').val(response.customers.account_balance);
                    $('#addCustomerModal #c_wht_reg_no').val(response.customers.wht_reg_no);
                    $('#addCustomerModal #c_collection_bureau').val(response.customers.collection_bureau_id).change();
                    $('#addCustomerModal #c_price_type').val(response.customers.default_price_type).change();

                    $('#addCustomerModal #c_settlement_due_days').val(response.customers.settlement_due);
                    $('#addCustomerModal #c_discount_period').val(response.customers.discount_period);

                    $('#addCustomerModal #c_last_credit_review').val(response.customers.last_credit_review);
                    $('#addCustomerModal #c_next_credit_review').val(response.customers.next_credit_review);
                    $('#addCustomerModal #c_interest').val(response.customers.interest);
                    $('#addCustomerModal #c_settlement_discount').val(response.customers.settlement_discount);

                    $('#addCustomerModal #c_position1').val(response.customers.contact_position);
                    $('#addCustomerModal #c_position2').val(response.customers.contact_position2);
                    $('#addCustomerModal #c_name1').val(response.customers.contact_name);
                    $('#addCustomerModal #c_name2').val(response.customers.contact_name2);
                    $('#addCustomerModal #c_telephone1').val(response.customers.contact_telephone);
                    $('#addCustomerModal #c_mobile1').val(response.customers.contact_mobile);
                    $('#addCustomerModal #c_telephone2').val(response.customers.contact_telephone2);
                    $('#addCustomerModal #c_mobile2').val(response.customers.contact_mobile2);
                    $('#addCustomerModal #c_email1').val(response.customers.contact_email);
                    $('#addCustomerModal #c_email2').val(response.customers.contact_email2);

                    $('#addCustomerModal #c_t_n_c').val(response.customers.t_n_c);
                    $('#addCustomerModal #c_notes').val(response.customers.notes);

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

    // Existing function with the `page` parameter for pagination
    function listTableDatas(page=1,code=null, name=null, email=null, telephone=null, group=null) {
        $('#overlay').show();
        $.ajax({
            url: "{{ route('cuscustomers.fetchcustomers') }}",
            cache: false,
            data: {
                _token: '{{ csrf_token() }}', 'code':code, 'name':name, 'email':email, 'telephone':telephone,'group':group,'page':page,'order':'customers.id DESC'
            },
            type: 'GET',
            success: function (response) {
                $('#overlay').hide();
                $('#table_list').html(response.html);
                // Re-bind the click event for pagination links after new content is loaded
                bindPaginationLinks();
            },
            error: function (xhr, status, error) {
                console.log("Error fetching data!", xhr, status, error);
                $('#overlay').hide();
            }
        });
    }

    // Function to handle pagination link clicks
    function bindPaginationLinks() {
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1]; // Get the page number
            listTableDatas(page,null, null, null, null, null); // Call the function with the page number
        });
    }

    // Call the function initially
    bindPaginationLinks();
    </script>
@endpush

