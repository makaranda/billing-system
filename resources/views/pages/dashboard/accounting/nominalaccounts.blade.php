@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Nominal Accounts</h3>
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
            <a href="#">Nominal Accounts</a>
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
                                     <h1 class="text-uppercase">Nominal Accounts</h1>

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
                                            <span class="text-uppercase">Nominal Accounts Information</span>
                                            @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                                <button type="button" class="btn btn-xs btn-info pull-right ml-1 addAccountButton" data-bs-toggle="modal" data-bs-target="#addAccountModal" role="button">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                    Add New Account
                                                </button>
                                            @endif
                                        </div>
                                        <div class="panel panel-default p-3">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="s_code" name="s_code" placeholder="Code" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="s_name" name="s_name" placeholder="Name" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select class="form-control" id="s_status" name="s_status">
                                                                <option value="">- ALL -</option>
                                                                <option value="1">Active</option>
                                                                <option value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select class="form-control" id="s_type" name="s_type">
                                                                <option value="">- ALL -</option>
                                                                <option value="control">Control</option>
                                                                <option value="non-control">Non-Control</option>
                                                                <option value="floating">Floating</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <button type="button" id="s_search" class="btn btn-primary form-control">
                                                                <span class="glyphicon glyphicon-serach"></span> Search</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <button type="button" id="s_reset" class="btn btn-default form-control">
                                                                <span class="glyphicon glyphicon-refresh"></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"><div class="col-md-12"><span id="table_list"></span></div></div>
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
<div class="modal fade" id="addAccountModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><span class="fa fa-plus"></span> ADD/EDIT ACCOUNT</h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
		<form name="frm_add_account" id="frm_add_account" method="post">
        <input type="hidden" name="form_type" id="form_type" value="cusaddcustomergroups.addcustomergroup">
        <input type="hidden" name="sub_cat_id" id="sub_cat_id" value="">
	    <div class="modal-body">
	        <div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="category_id">Category</label>
						<select class="form-control" id="category_id" name="category_id">
							<option value="">- SELECT CATEGORY -</option>
                            @foreach ($acAccountCategoriesDetails as $acAccountCategoriesDetail)
                                <option value="{{ $acAccountCategoriesDetail->id }}">{{ $acAccountCategoriesDetail->name }}</option>
                            @endforeach
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="sub_category_id">Sub Category</label>
						<select class="form-control" id="sub_category_id" name="sub_category_id">
							<option value="">- SELECT SUB CATEGORY -</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label" for="account_code">Account Code</label>
						<input type="text" class="form-control" id="account_code" name="account_code" placeholder="Account Code" />
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
						<label class="control-label" for="account_name">Account Name</label>
						<input type="text" class="form-control" id="account_name" name="account_name" placeholder="Account Name" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<input type="checkbox" name="is_control" id="is_control" /> Control Acc
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<input type="checkbox" name="allow_dr" id="allow_dr" /> Allow DR
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<input type="checkbox" name="allow_cr" id="allow_cr" /> Allow CR
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<input type="checkbox" name="is_floating" id="is_floating" /> Floating Acc
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




  <!-- Account Activity Modal -->
  <div class="modal fade" id="account_activity_modal" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><span class="glyphicon glyphicon-th-list"></span> ACCOUNT ACTIVITY</h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        	<div class="row">
        		<div class="col-md-3">
	        		<div class="form-group">
	        			<div class="input-group datepicker_field" id="datepicker1">
						    <input type='text' class="form-control" id="s_from_date" name="s_from_date" placeholder="From Date" />
						    <span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						    </span>
						</div>
	        		</div>
	        	</div>
        		<div class="col-md-3">
	        		<div class="form-group">
	        			<div class="input-group datepicker_field" id="datepicker2">
						    <input type='text' class="form-control" id="s_to_date" name="s_to_date" placeholder="To Date" />
						    <span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						    </span>
						</div>
	        		</div>
	        	</div>
        		<div class="col-md-3">
	        		<div class="form-group">
	        			<input type="text" class="form-control" name="s_reference" id="s_reference" placeholder="Reference" />
	        		</div>
	        	</div>
        		<div class="col-md-2">
	        		<div class="form-group">
	        			<button class="btn btn-primary form-control" id="btn_search"><span class="glyphicon glyphicon-search"></span></button>
	        			<input type="hidden" name="hidden_account_id" id="hidden_account_id">
	        		</div>
	        	</div>
        		<div class="col-md-1">
	        		<div class="form-group">
	        			<button class="btn btn-default form-control" id="btn_refresh"><span class="glyphicon glyphicon-refresh"></span></button>
	        		</div>
	        	</div>
        	</div>
        	<div class="row">
        		<div class="col-md-12" id="account_activity_information"></div>
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
        $("#s_from_date").datepicker({
            autoclose: true,
            orientation: "bottom"
        });

        $("#s_to_date").datepicker({
            autoclose: true,
            orientation: "bottom"
        });

        $("#cancel_date").datepicker({
            autoclose: true,
            orientation: "bottom"
        });

        $("#update_date").datepicker({
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

    function open_account_activity(account_id){
        $('#hidden_account_id').val(account_id);
        $('#account_activity_information').html("");
        $('#account_activity_modal').modal('show');

        get_account_activities(1,account_id);
    }

    $('#btn_search').click(function(){
        var account_id = $('#hidden_account_id').val();
        var from_date = $('#s_from_date').val();
        var to_date = $('#s_to_date').val();
        var reference = $('#s_reference').val();

        get_account_activities(1,account_id,from_date,to_date, reference);
    });

    $('#btn_refresh').click(function(){
        var account_id = $('#hidden_account_id').val();
        $('#s_from_date').val("");
        $('#s_to_date').val("");
        $('#s_reference').val("");

        get_account_activities(1,account_id);
    });

    function get_account_activities(page=1,account_id,from_date='',to_date='', reference=''){
        $.ajax({
            url : "{{ route('nominalaccounts.fetchaccountsactivities') }}",
            cache: false,
            data: {  _token: '{{ csrf_token() }}','page':page,'account_id':account_id,'from_date':from_date,'to_date':to_date,
            'reference':reference,'order':'customer_transactions.id DESC' },
            type: 'GET',
            success : function(data) {
                //console.log('Showing.....');
                $('#overlay').hide();
                $('#account_activity_information').html(data.html);
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
            get_account_activities(page,0, null, null, null); // Call the function with the page number
        });
    }

    // Call the function initially
    bindPaginationLinks();


    function category_change(category_id, selectedSubcategoryId, callback = null) {
        var subCategoryDropdown = $('#sub_category_id');

        // Clear existing subcategories before making the AJAX request
        subCategoryDropdown.empty();

        let categoryUrl = '{{ route("nominalaccounts.getsubcategories", ":id") }}';
        categoryUrl = categoryUrl.replace(':id', category_id);

        // If category is selected, fetch subcategories
        if (category_id) {
            $.ajax({
                url: categoryUrl,
                type: 'GET',
                success: function(data) {
                    subCategoryDropdown.empty(); // Clear the dropdown

                    if (data.length > 0) {
                        // Populate the subcategory dropdown if data exists
                        $.each(data, function(index, subcategory) {
                            subCategoryDropdown.append('<option value="'+subcategory.id+'">'+subcategory.name+'</option>');
                        });

                        // After populating, check if a subcategory should be selected
                        console.log('selectedSubcategoryId : '+selectedSubcategoryId);
                        if (selectedSubcategoryId) {
                            subCategoryDropdown.val(selectedSubcategoryId).change();
                        }
                    } else {
                        subCategoryDropdown.append('<option value="">- SELECT SUB CATEGORY -</option>');
                    }

                    // Execute the callback function after loading subcategories
                    if (callback) {
                        callback();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching subcategories: ", error);
                }
            });
        } else {
            subCategoryDropdown.append('<option value="">- SELECT SUB CATEGORY -</option>');
        }
    }

    $('#category_id').on('change', function() {
        var categoryId = $(this).val();
        var subCatId = ($('#sub_cat_id').val())?$('#sub_cat_id').val():'';
        category_change(categoryId,subCatId,'');
    });


    $('.addAccountButton').on('click',function(){
        $('#frm_add_account').parsley().reset();
        $('#frm_add_account')[0].reset();

        $('#edit_id').val('');
        $('#form_type').val('nominalaccounts.addnominalaccount');
    });

    $('#s_reset').click(function(){
        $('#s_code').val("");
        $('#s_name').val("");
        $('#s_status').val("").change();
        $('#s_type').val("").change();

        listTableDatas();
    });

    $('#s_search').click(function(){
        var code = $('#s_code').val();
        var name = $('#s_name').val();
        var status = $('#s_status').val();
        var type = $('#s_type').val();

        listTableDatas(null,null, code, name, status, type);
    });


    $('#deleteRecordForm').parsley();
        $('#deleteRecordForm').on('submit', function(event){
            event.preventDefault();
            $('#overlay').show();
            var delete_record_id = $('#delete_record_id').val();
            var form_type = $('#delete_record_form').val();

            let updateUrl = ($('#delete_record_form').val() == 'nominalaccounts.deletenominalaccount')?'{{ route("nominalaccounts.deletenominalaccount", ":id") }}':'{{ route("nominalaccounts.disablenominalaccount", ":id") }}';
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

    /* add Edit record */
    $('#frm_add_account').parsley();
    $('#frm_add_account').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var edit_id = ($('#edit_id').val())?$('#edit_id').val():'';
        var form_type = '';

        if($('#form_type').val() == 'nominalaccounts.editnominalaccount'){
            form_type = '{{ route("nominalaccounts.updatenominalaccount", ":id") }}';
            form_type = form_type.replace(':id', edit_id);
        }else{
            form_type = '{{ route("nominalaccounts.addnominalaccount") }}';
        }

        console.log(form_type);
        $.ajax({
            url : form_type,
            cache: false,
            data: $(this).serialize() + '&_token={{ csrf_token() }}',
            type: 'POST',
            dataType: 'json',
            success : function(response) {
                $('#addAccountModal').modal('hide');
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

    /* disable record */
    function disableRecord(id,route_path,type){
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


    function editRecord(id){
        $('#overlay').show();

        $('#form_type').val('nominalaccounts.editnominalaccount');
        $('#edit_id').val(id);

        let updateUrl = '{{ route("nominalaccounts.editnominalaccount", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);

        $.ajax({
            url : updateUrl,
            cache: false,
            data: {' _token': '{{ csrf_token() }}','id':id},
            type: 'GET',
            dataType: 'json',
            success : function(response) {
                console.log("Error getting Accounts !"+response.main_category);
                $('#addAccountModal').modal('show');
                if(response.nominalaccount.id != ''){
                    $('#sub_cat_id').val(response.nominalaccount.sub_category_id);
                    // category_change(response.main_category, function() {
                    //     // After the subcategories are loaded, set the correct subcategory
                    //     console.log(response.main_category+'='+response.nominalaccount.sub_category_id);
                    //     $('#addAccountModal #sub_category_id').val(response.nominalaccount.sub_category_id).change();
                    // });
                    //category_change(3,31,'');
                    // category_change(response.main_category, 31, function() {
                    //     console.log("Subcategories loaded and subcategory selected."+response.nominalaccount.sub_category_id);
                    // });


                    $('#addAccountModal #category_id').val(response.main_category).change();
                    $('#addAccountModal #sub_category_id').val(response.nominalaccount.sub_category_id).change();
                    $('#addAccountModal #account_code').val(response.nominalaccount.code);
                    $('#addAccountModal #account_name').val(response.nominalaccount.name);

                    if(response.nominalaccount.is_control == 1) $('#is_control').prop("checked",true); else $('#is_control').prop("checked",false);
                    if(response.nominalaccount.is_floating == 1) $('#is_floating').prop("checked",true); else $('#is_floating').prop("checked",false);
                    if(response.nominalaccount.allow_cr == 1) $('#allow_cr').prop("checked",true); else $('#allow_cr').prop("checked",false);
                    if(response.nominalaccount.allow_dr == 1) $('#allow_dr').prop("checked",true); else $('#allow_dr').prop("checked",false);

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

    function listTableDatas(category_id=null, sub_category_id=null, code=null, name=null, status=null, filter_param=null) {
        //alert();
        //console.log("THIS");
        $('#overlay').show();
        $.ajax({
                url : "{{ route('nominalaccounts.fetchnominalaccounts') }}",
                cache: false,
                data: { _token: '{{ csrf_token() }}','category_id':category_id,'sub_category_id':sub_category_id,'code':code,'name':name,'status':status,
                'filter_param':filter_param,'order':'ASC'},
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

