@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Products</h3>
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
            <a href="#">Products</a>
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
                                     <h1 class="text-uppercase">Products</h1>

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
                                                    <span class="text-uppercase">Product Information</span>
                                                    @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                        <button type="button" class="btn btn-xs btn-info pull-right ml-1 addExpensesModal" data-bs-toggle="modal" data-bs-target="#addExpensesModal" role="button">
                                                            <span class="glyphicon glyphicon-plus"></span>
                                                            Add Product
                                                        </button>
                                                    @endif
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="p-3" id="products_list"></div>
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
<div class="modal fade" id="addExpensesModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><span class="fa fa-plus"></span> ADD/EDIT PRODUCT</h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
        <form id="frm_expense_items" name="frm_expense_items" method="post">
            <input type="hidden" name="form_type" id="form_type" value="products.addproduct">
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="">- SELECT CATEGORY -</option>
                                    @foreach ($proCategoriesDetails as $proCategoriesDetail)
                                        <option value="{{ $proCategoriesDetail->id }}">{{ $proCategoriesDetail->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_code">Item Code</label>
                                <input type="text" name="item_code" id="item_code" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="item_name">Item Name</label>
                                <input type="text" name="item_name" id="item_name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tax_type">Tax Type</label>
                                <select name="tax_type" id="tax_type" class="form-control">
                                    <option value="1">Taxable</option>
                                    <option value="0">Non Taxable</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 align-content-center">
                            <div class="form-group">
                                <div class="row">
                                    {{-- {{ var_dump($taxesDetails); }} --}}
                                    @if(count($taxesDetails) > 0)
                                        @foreach ($taxesDetails as $tax)
                                            <div class="col-md-6">
                                                <label>
                                                    <input type="checkbox"
                                                        class="taxcheck"
                                                        id="taxcheck{{ $tax['id'] }}"
                                                        name="tax"
                                                        value="{{ $tax['id'] }}"
                                                        data-rate="{{ $tax['rate'] }}"
                                                        data-tax_id="{{ $tax['id'] }}"
                                                        checked>
                                                    {{ $tax['name'] }} ({{ $tax['rate'] }}%)
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="stock_type">Stock Type</label>
                                <select name="stock_type" id="stock_type" class="form-control">
                                    <option value="stock">Stock</option>
                                    <option value="service">Service</option>
                                    <option value="Software">Software</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="currency_id">Curruncy</label>
                                <select class="form-control" name="currency_id" id="currency_id" required>
                                    @foreach ($currenciesDetails as $currenciesDetail)
                                        <option value="{{ $currenciesDetail->id }}" data-rate="{{ $currenciesDetail->rate }}">{{ $currenciesDetail->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="price">Price (Tax Exclusive)</label>
                                <input type="text" name="price" id="price" class="form-control" value="0.00">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer d-block">
            <div class="row">
                <div class="col-md-6 pl-0">
                <div class="form-group">
                    <button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">Cancel</button>
                    <input type="hidden" id="expense_id" name="expense_id" />
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


<!-- Change Price Modal -->
  <div class="modal fade" id="changePriceModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-edit"></span> Change Price</h4>
        </div>
        <div class="modal-body">
        	<div class="row">
        		<div class="col-md-12">
        			<div class="form-group">
        				<label>Price (Tax Inclusive)</label>
        				<input type="text" id="new_price" class="form-control number">
        			</div>
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-12">
        			<div class="form-group">
        				<button class="btn btn-primary form-control" onclick="change_price();">Change</button>
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

    $('.addExpensesModal').on('click',function(){
        $('#frm_expense_items').parsley().reset();
        $('#frm_expense_items')[0].reset();

        $('#expense_id').val('');
        $('#form_type').val('products.addproduct');
    });


    $('#frm_expense_items').parsley();
    $('#frm_expense_items').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var expense_id = ($('#expense_id').val())?$('#expense_id').val():'';
        var form_type = '';

        if($('#form_type').val() == 'products.updateproduct'){
            form_type = '{{ route("products.updateproduct", ":id") }}';
            form_type = form_type.replace(':id', expense_id);
        }else{
            form_type = '{{ route("products.addproduct") }}';
        }
        //var form_type = ($('#form_type').val() == 'products.addproduct')?'{{ route("products.addproduct") }}':'{{ route("products.updateproduct",'+expense_id+') }}';

        console.log(form_type);
        $.ajax({
            url : form_type,
            cache: false,
            data: $(this).serialize() + '&_token={{ csrf_token() }}',
            type: 'POST',
            dataType: 'json',
            success : function(response) {
                $('#addExpensesModal').modal('hide');
                console.log(response);
                //var arr = data.split("|");
                $('#frm_expense_items').parsley().reset();
                $('#frm_expense_items')[0].reset();
                Swal.fire({
                    position: "bottom-end",
                    icon: response.messageType === 'success' ? "success" : "error",
                    title: response.message,
                    showConfirmButton: false,
                    timer: response.messageType === 'success' ? 4000 : 2500
                });
                listProducts();
                $('#overlay').hide();
            },
            error: function(xhr, status, error) {
                console.log("Error getting Categories ! \n", xhr, status, error);
                $('#overlay').hide();
            }
        });

    });

    //delete_record_form delete_record_id delete_record_type deleteModelTopic deleteModelDesctiption

    function deleteRecord(id,route_path,type){
        $('#deleteModal').modal('show');

        $('#delete_record_id').val(id);
        $('#delete_record_form').val(route_path);
        $('#delete_record_type').val(type);

        console.log(id+'-'+route_path+'-'+type);

        if(type == 'inactive'){
            $('.deleteModelTopic').text('Deactive Record');
            $('.deleteModelDesctiption').text('Are you sure to Inactive this Record now...!!!');
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



    $('#deleteRecordForm').parsley();
    $('#deleteRecordForm').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var delete_record_id = $('#delete_record_id').val();
        var form_type = $('#delete_record_form').val();

        let updateUrl = '{{ route("products.deleteproduct", ":id") }}';
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
                listProducts();
                $('#overlay').hide();
            },
            error: function(xhr, status, error) {
                //console.log("Error getting Categories ! \n", xhr, status, error);
                $('#overlay').hide();
            }
        });

    });

    function editProduct(id){
        $('#overlay').show();

        $('#form_type').val('products.updateproduct');
        $('#expense_id').val(id);

        let updateUrl = '{{ route("products.editproduct", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);

        $.ajax({
            url : updateUrl,
            cache: false,
            data: {' _token': '{{ csrf_token() }}','id':id},
            type: 'GET',
            dataType: 'json',
            success : function(response) {
                //console.log("Error getting Product !"+response);
                $('#addExpensesModal').modal('show');
                //var arr = data.split("|");
                //`category_id`, `code`, `name`, `description`, `currency_id`, `price`, `is_taxable`, `stock_type`, `created_at`, `updated_at`, `status`, `Kbilling_product_id`
                if(response.products.id != ''){
                    $('#addExpensesModal #category').val(response.products.category_id).change();
                    $('#addExpensesModal #item_code').val(response.products.code);
                    $('#addExpensesModal #item_name').val(response.products.name);
                    $('#addExpensesModal #description').val(response.products.description);
                    $('#addExpensesModal #tax_type').val(response.products.is_taxable).change();
                    $('#addExpensesModal #stock_type').val(response.products.stock_type).change();
                    $('#addExpensesModal #currency_id').val(response.products.currency_id).change();
                    $('#addExpensesModal #price').val(response.products.price);
                }

                listProducts();
                $('#overlay').hide();
            },
            error: function(response) {
                //console.log("Error All ! \n"+response);
                $('#overlay').hide();
            }
        });
    }

    listProducts();

    function listProducts() {
        //alert();
		//console.log("THIS");
		$('#overlay').show();
        $.ajax({
                url : "{{ route('products.fetchproproducts') }}",
                cache: false,
                data: { _token: '{{ csrf_token() }}','order':'ASC'},
                type: 'GET',
                success : function(data) {
                    //console.log('Success: '+data);
                    $('#overlay').hide();
                    $('#products_list').html(data);

                },
                error: function(xhr, status, error) {
                    //console.log("Error getting Categories ! \n", xhr, status, error);
                    $('#overlay').hide();
                }
        });
    }
    </script>
@endpush

