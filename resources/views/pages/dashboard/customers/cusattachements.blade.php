@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">Attachements</h3>
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
            <a href="#">Attachements</a>
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
                                     <h1 class="text-uppercase">Attachements</h1>

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
                                            <span class="text-uppercase">Customers Receipts</span>

                                            @if(isset($routepermissions['create']) && $routepermissions['create'] == 1)
                                               @if(!isset($debt_assignment_id,$assign_upto_date))
                                                    <button type="button" class="btn btn-xs btn-warning pull-right ml-1 addBankAccountButton" data-bs-toggle="modal" data-bs-target="#addArchiveModal" role="button">
                                                        <span class="glyphicon glyphicon-plus"></span>
                                                        Add Archives
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="panel panel-default p-3">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                          <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <select name="search_category" id="search_category" class="form-control">
                                                                            <option value="">- SELECT CATEGORY -</option>
                                                                            @foreach ($getArchiveCategories as $getArchiveCategory)
                                                                                <option value="{{ $getArchiveCategory->id }}">{{ $getArchiveCategory->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <select class="form-control" id="search_customer_group" name="search_customer_group">
                                                                            <option value="" data-s_acc_id="">- All Customer Groups -</option>
                                                                            @foreach ($productCategories as $productCategory)
                                                                                <option value="{{ $productCategory->id }}" data-s_acc_id="{{ $productCategory->sales_account_id }}">{{ $productCategory->name }}</option>
                                                                            @endforeach
                                                                        </select>
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
                                                                        <input type='text' class="form-control" id="search_reference" name="search_reference" placeholder="Reference" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <div class="input-group datepicker_field" id="datepicker3">
                                                                            <input type='text' class="form-control" id="search_from_date" name="search_from_date" placeholder="Uploaded date: from" />
                                                                            <span class="input-group-addon">
                                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <div class="input-group datepicker_field" id="datepicker4">
                                                                            <input type='text' class="form-control" id="search_to_date" name="search_to_date" placeholder="Uploaded date: to" />
                                                                            <span class="input-group-addon">
                                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <div class="input-group datepicker_field" id="datepicker5">
                                                                            <input type='text' class="form-control" id="search_reminder_from_date" name="search_reminder_from_date" placeholder="Reminder date: from" />
                                                                            <span class="input-group-addon">
                                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <div class="input-group datepicker_field" id="datepicker6">
                                                                            <input type='text' class="form-control" id="search_reminder_to_date" name="search_reminder_to_date" placeholder="Reminder Date: to" />
                                                                            <span class="input-group-addon">
                                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <select name="search_user" id="search_user" class="form-control">
                                                                            <option value="">- SELECT UPLOADED BY -</option>
                                                                            @foreach ($getAllSystemUsers as $getystemUser)
                                                                                <option value="{{ $getArchiveCategory->id }}">{{ $getArchiveCategory->full_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <button type="button" class="btn btn-primary form-control" name="search" title="Search" id="search">Serach</button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <button type="button" class="btn btn-default form-control" id="reset" name="reset" title="Reset Search"><span class="glyphicon glyphicon-refresh"></span></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row"><div class="col-md-12"><span id="table_list">No Customer Attachements !</span></div></div>
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
</div>



	<!-- Add Hotel Modal -->
	<div class="modal fade" id="addArchiveModal" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> ADD/EDIT ARCHIVES</h4>
					<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
				</div>
				<form id="frm_add_archives" method="post" action="#" enctype='multipart/form-data'>
                    @csrf
					<div class="modal-body">
						<div class="row">
							<div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="archive_date">Date</label>
                                    <div class="input-group datepicker_field" id="datepicker3">
                                        <input type='text' class="form-control" id="archive_date" name="archive_date" value="{{ date("Y-m-d", strtotime(WORKING_DATE)) }}" />
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
									<label class="control-label" for="category">Archive Category</label>
									<select name="category" id="category" class="form-control" required>
										<option value="">- SELECT -</option>
										@foreach ($getArchiveCategories as $getArchiveCategory)
                                            <option value="{{ $getArchiveCategory->id }}">{{ $getArchiveCategory->name }}</option>
                                        @endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label" for="description">Short Description</label>
									<input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="reminder_date">Reminder Date</label>
                                    <div class="input-group datepicker_field" id="datepicker3">
                                        <input type='text' class="form-control" id="reminder_date" name="reminder_date" placeholder="Reminder on 30 days before, 7 days before and on day" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<label class="control-label" for="file">File</label>
									<input type="file" class="form-control" id="file" name="file" required />
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

	<!-- Add Hotel Modal -->
	<div class="modal fade" id="updateArchiveModal" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> EDIT ARCHIVES</h4>
					<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
				</div>
				<form id="frm_update_archives" method="post" action="#" enctype='multipart/form-data'>
                    @csrf
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label" for="update_category">Archive Category</label>
									<select name="update_category" id="update_category" class="form-control" required>
										<option value="">- SELECT -</option>
										@foreach ($getArchiveCategories as $getArchiveCategory)
                                            <option value="{{ $getArchiveCategory->id }}">{{ $getArchiveCategory->name }}</option>
                                        @endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label" for="update_description">Short Description</label>
									<input type="text" class="form-control" id="update_description" name="update_description" placeholder="Enter Description" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="update_reminder_date">Reminder Date</label>
                                    <div class="input-group datepicker_field" id="datepicker3">
                                        <input type='text' class="form-control" id="update_reminder_date" name="update_reminder_date" placeholder="Reminder on 30 days before, 7 days before and on day" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
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
									<input type="hidden" id="update_edit_id" name="update_edit_id" />
								</div>
							</div>
							<div class="col-md-6 pr-0">
								<div class="form-group">
									<button type="submit" name="submit" class="btn btn-primary form-control">Update</button>
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
        //search_from_date  search_to_date  search_reminder_from_date search_reminder_to_date
        $("#archive_date").datepicker({
            autoclose: true,
            orientation: "bottom"
        });
        $("#reminder_date").datepicker({
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
        $("#search_reminder_from_date").datepicker({
            autoclose: true,
            orientation: "bottom"
        });
        $("#search_reminder_to_date").datepicker({
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



    $('#search').click(function() {
			var category = $('#search_category').val();
			var customer_group = $('#search_customer_group').val();
			var customer_id = $('#search_customer_id').val();
			var customer_id = $('#search_customer_name').val();
			var description = $('#search_description').val();
			var reference = $('#search_reference').val();
			var from_date = $('#search_from_date').val();
			var to_date = $('#search_to_date').val();
			var reminder_from_date = $('#search_reminder_from_date').val();
			var reminder_to_date = $('#search_reminder_to_date').val();
			var user = $('#search_user').val();

			listTableDatas(page=1, from_date, to_date, customer_id, customer_group, category, description, reference, user, reminder_from_date, reminder_to_date);
		});

    $('#reset').click(function() {
        //$('#yourFormId')[0].reset();
        $('#search_category').prop('selectedIndex', 0);
        $('#search_customer_group').prop('selectedIndex', 0);
        $('#search_customer_id').val('');
        $('#search_customer_name').val('');
        $('#search_description').val('');
        $('#search_reference').val('');
        $('#search_from_date').val('');
        $('#search_to_date').val('');
        $('#search_reminder_from_date').val('');
        $('#search_reminder_to_date').val('');
        $('#search_user').prop('selectedIndex', 0);
        listTableDatas();
    });

    $('#frm_update_archives').parsley();
    $('#frm_update_archives').on('submit', function(event) {
        event.preventDefault();
        $('#overlay').show();
        var edit_id = ($('#update_edit_id').val())?$('#update_edit_id').val():'';
        var form_type = '';
        // Use FormData for file upload
        let formData = new FormData(this);
        if($('#form_type').val() == 'cusattachements.updatecusattachement'){
            form_type = '{{ route("cusattachements.updatecusattachement", ":id") }}';
            form_type = form_type.replace(':id', edit_id);
        }else{
            form_type = '{{ route("cusattachements.updatecusattachement") }}';
        }
        $.ajax({
            url: form_type,
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false, // Necessary for FormData
            contentType: false, // Necessary for FormData
            success: function(response) {
                $('#updateArchiveModal').modal('hide');
                console.log(response);

                $('#frm_update_archives').parsley().reset();
                $('#frm_update_archives')[0].reset();

                Swal.fire({
                    position: "bottom-end",
                    icon: response.messageType === 'success' ? "success" : "error",
                    title: response.message,
                    showConfirmButton: false,
                    timer: response.messageType === 'success' ? 4000 : 2500
                });

                if(response.messageType === 'success') {
                    listTableDatas(); // Refresh data if successful
                }

                $('#overlay').hide();
            },
            error: function(xhr, status, error) {
                console.log("Error submitting archive form", xhr, status, error);
                $('#overlay').hide();
            }
        });
    });

    $('#frm_update_archives').parsley();
    $('#frm_update_archives').on('submit', function(event) {
        event.preventDefault();
        $('#overlay').show();
        var edit_id = $('#update_edit_id').val() || '';

        // Construct the URL dynamically with the pro_id
        let form_type = '{{ route("cusattachements.updatecusattachement", ":id") }}';
        form_type = form_type.replace(':id', edit_id);

        // Use FormData for the AJAX request
        let formData = new FormData(this);

        $.ajax({
            url: form_type,
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(response) {
                $('#updateArchiveModal').modal('hide');
                console.log(response);

                $('#frm_update_archives').parsley().reset();
                $('#frm_update_archives')[0].reset();

                Swal.fire({
                    position: "bottom-end",
                    icon: response.messageType === 'success' ? "success" : "error",
                    title: response.message,
                    showConfirmButton: false,
                    timer: response.messageType === 'success' ? 4000 : 2500
                });

                if(response.messageType === 'success') {
                    listTableDatas(); // Refresh data if successful
                }

                $('#overlay').hide();
            },
            error: function(xhr, status, error) {
                console.log("Error submitting archive form", xhr, status, error);
                $('#overlay').hide();
            }
        });
    });


    function editArchive(id){
        $('#overlay').show();

        $('#form_type').val('cusattachements.editcusattachement');
        $('#edit_id').val(id);

        let updateUrl = '{{ route("cusattachements.editcusattachement", ":id") }}';
        updateUrl = updateUrl.replace(':id', id);
        //updateArchiveModal frm_update_archives   update_category update_description update_reminder_date update_edit_id
        $.ajax({
            url : updateUrl,
            cache: false,
            data: {' _token': '{{ csrf_token() }}','id':id},
            type: 'GET',
            dataType: 'json',
            success : function(response) {
                console.log(response);

                if(response.customer_attachements.id != ''){
                    $('#updateArchiveModal #update_reminder_date').val(response.customer_attachements.reminder_date);
                    $('#updateArchiveModal #update_description').val(response.customer_attachements.description);
                    $('#updateArchiveModal #update_category').val(response.customer_attachements.category_id).change();
                    $('#updateArchiveModal #update_edit_id').val(response.customer_attachements.id);

                    $('#updateArchiveModal').modal('show');
                }

                listTableDatas();
                $('#overlay').hide();
            },
            error: function(xhr, status, error) {
                console.log("Error getting Categories ! \n", xhr, status, error);
                $('#overlay').hide();
            }
        });
    }


    $('#frm_add_payments').parsley();
    $('#frm_add_payments').on('submit', function(event){
        event.preventDefault();
        $('#overlay').show();
        var edit_id = ($('#edit_id').val())?$('#edit_id').val():'';
        var form_type = '';

        if($('#form_type').val() == 'cuscustomerreceipts.editcustomerreceipt'){
            form_type = '{{ route("cuscustomerreceipts.updatecustomerreceipt", ":id") }}';
            form_type = form_type.replace(':id', edit_id);
        }else{
            form_type = '{{ route("cuscustomerreceipts.addcustomerreceipt") }}';
        }

        //console.log(form_type);
        $.ajax({
            url : form_type,
            cache: false,
            data: $(this).serialize() + '&_token={{ csrf_token() }}',
            type: 'POST',
            dataType: 'json',
            success : function(response) {
                $('#addReceiptModal').modal('hide');
                console.log(response);
                //var arr = data.split("|");
                $('#frm_add_payments').parsley().reset();
                $('#frm_add_payments')[0].reset();
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

    function download_attachement_file(archive_id,archive_file){
        console.log(archive_id+'/'+archive_file);
        let url = "{{ url('') }}" + '/' + archive_file; // Construct the URL
        $.redirect(url, {}, "GET", "_blank");
    }

    function updateArchive(id, category, description, reminder_date) {
        $('#updateArchiveModal #edit_id').val(id);
        $('#updateArchiveModal #category').val(category);
        $('#updateArchiveModal #description').val(description);
        $('#updateArchiveModal #reminder_date').val(reminder_date);
        $('#updateArchiveModal').modal();
    }

    function deleteArchiveConfirmed(id) {
        $.ajax({
            url: "ajax/attachments/delete_archive.php",
            cache: false,
            data: {
                _token: "{{ csrf_token() }}",
                'id': id
            },
            type: 'POST',
            success: function(data) {
                var arr = data.split("|");
                if (arr[0] == 'success') {
                    listTableDatas();
                    $('#successMessage').html("Archive deleted successfuly.");
                    $('#successModal').modal();
                } else {
                    $('#errorMessage').html("Failed to delete archive, Please try again later ! \n" + arr[0]);
                    $('#errorModal').modal();
                }
            },
            error: function(data) {
                $('#errorMessage').html("Internal problem detected, Please try again later !");
                $('#errorModal').modal();
            }
        });
    }

    listTableDatas();

    function listTableDatas(page=1, from_date = null, to_date = null, customer_id = null, customer_group = null, category = null, description = null, reference = null, user = null, reminder_from_date = null, reminder_to_date = null) {
        $('#overlay').show();
        $.ajax({
            url: "{{ route('cusattachements.fetchcusattachement') }}",
            cache: false,
            data: {
                'from_date': from_date,
                'to_date': to_date,
                'customer_group': customer_group,
                'customer_id': customer_id,
                'category': category,
                'description': description,
                'reference': reference,
                'user': user,
                'reminder_from_date': reminder_from_date,
                'reminder_to_date': reminder_to_date,
                'order': 'archives.id DESC'
            },
            type: 'GET',
            success : function(response) {
                    //console.log('Success: '+data);
                $('#overlay').hide();
                $('#table_list').html(response.html);

                //bindPaginationLinks();
            },
            error: function(xhr, status, error) {
                console.error("Error getting data!", xhr, status, error);
                $('#overlay').hide();
            }
        });
    }


    $("#customer_name").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{ route('cusattachements.getcustomersnames') }}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    search: request.term,
                    active: -1
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            // Set selection
            $('#customer_name').val(ui.item.label);
            $('#customer_id').val(ui.item.value);
            return false;
        }
    });

    $("#customer_name").on('focus click', function() {
        $("#customer_name").select();
    });

    $("#customer_name").on('change', function() {
        if ($(this).val().length < 1) {
            $("#customer_id").val(0);
        }
    });


    $("#search_customer_name").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{ route('cusattachements.getcustomersnames') }}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    search: request.term,
                    active: -1
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            // Set selection
            $('#search_customer_name').val(ui.item.label);
            $('#search_customer_id').val(ui.item.value);
            return false;
        }
    });

    $("#search_customer_name").on('focus click', function() {
        $("#search_customer_name").select();
    });

    $("#search_customer_name").on('change', function() {
        if ($(this).val().length < 1) {
            $("#search_customer_id").val(0);
        }
    });

    //     // Function to handle pagination link clicks
    // function bindPaginationLinks() {
    // $(document).on('click', '.pagination a', function (e) {
    //     e.preventDefault();
    //     var page = $(this).attr('href').split('page=')[1]; // Get the page number
    //     //listTableDatas(page,null, null, 0, null, 0, 0, 1,null,null,null);
    //     listTableDatas(page);
    // });
    // }

    // // Call the function initially
    // bindPaginationLinks();
    </script>
@endpush

