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
                                                        <button type="button" class="btn btn-xs btn-info pull-right ml-1 addMessageFormat">
                                                            <span class="glyphicon glyphicon-plus"></span>
                                                            Add New Message Format
                                                        </button>
                                                    @endif
                                                </div>

                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <form id="frm_add_format" method="post">
                                                                <input type="hidden" name="form_type" id="form_type" value="messageformats.addmessageformat">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="fw-bold">Message Format Name</label>
                                                                            <input type="text" name="name" id="name" class="form-control" required/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="fw-bold">Format Type</label>
                                                                            <select name="format_type" id="format_type" class="form-control" required>
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
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="p-3">
                                                                            <label class="fw-bold">Available tags</label>
                                                                            <span id="available_tags"></span><br/>
                                                                            <span>(Use these tags to replace with value when the letter generating)</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="fw-bold">Message Format Content</label>
                                                                            <textarea name="content" class="form-control" id="editor" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4 col-md-offset-4">
                                                                        <input type="hidden" name="edit_id" id="edit_id">
                                                                        <button class="btn btn-primary form-control ml-3 mb-3" id="add_btn" name="add_btn" type="submit">ADD</button>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <hr/>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="panel">
                                                            <div class="card-body" id="message_format_information">

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
</div>

@endsection

@push('css')
    <style>

    </style>
@endpush

@push('scripts')
    <script src="{{ url('public/vendors/ckeditor/ckeditor.js') }}"></script>
    <script>
    $(document).ready(function () {
        CKEDITOR.replace('content');
        // Define editMessage in global scope



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

            let updateUrl = '{{ route("messageformats.deletemessageformat", ":id") }}';
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
                    listMessages();
                    $('#overlay').hide();
                },
                error: function(xhr, status, error) {
                    //console.log("Error getting Categories ! \n", xhr, status, error);
                    $('#overlay').hide();
                }
            });

        });

        function editMessage(id) {
            $('#overlay').show();
            $('#form_type').val('messageformats.updatemessageformat');
            $('#edit_id').val(id);

            let updateUrl = '{{ route("messageformats.editmessageformat", ":id") }}';
            updateUrl = updateUrl.replace(':id', id);

            $.ajax({
                url: updateUrl,
                cache: false,
                data: { '_token': '{{ csrf_token() }}', 'id': id },
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.message_formats.name != '') {
                        $('#frm_add_format #name').val(response.message_formats.name);
                        //SetEditor(response.message_formats.content);
                        $('#frm_add_format #format_type').val(response.message_formats.type).change();
                        CKEDITOR.instances.editor.setData(response.message_formats.content);
                    }

                    listMessages();
                    $('#overlay').hide();
                },
                error: function(response) {
                    $('#overlay').hide();
                }
            });
        }
        //editMessageButton deleteRecordButton messageformats.addmessageformat
        $('#frm_add_format').parsley();
        $('#frm_add_format').on('submit', function(event){
            event.preventDefault();

            $('#overlay').show();
            var edit_id = ($('#edit_id').val())?$('#edit_id').val():'';
            var form_type = '';

            if($('#form_type').val() == 'messageformats.updatemessageformat'){
                form_type = '{{ route("messageformats.updatemessageformat", ":id") }}';
                form_type = form_type.replace(':id', edit_id);
            }else{
                form_type = '{{ route("messageformats.addmessageformat") }}';
            }
            var content = CKEDITOR.instances.editor.getData();
            console.log(form_type);
            $.ajax({
                url : form_type,
                cache: false,
                data: $(this).serialize() + '&_token={{ csrf_token() }}&content='+content+'',
                type: 'POST',
                dataType: 'json',
                success : function(response) {
                    console.log(response);
                    //var arr = data.split("|");
                    $('#frm_add_format').parsley().reset();
                    $('#frm_add_format')[0].reset();
                    CKEDITOR.instances.editor.setData('');
                    $('#form_type').val('messageformats.addmessageformat');
                    $('#edit_id').val('');
                    Swal.fire({
                        position: "bottom-end",
                        icon: response.messageType === 'success' ? "success" : "error",
                        title: response.message,
                        showConfirmButton: false,
                        timer: response.messageType === 'success' ? 4000 : 2500
                    });
                    $('#add_btn').text('ADD');
                    listMessages();
                    $('#overlay').hide();
                },
                error: function(xhr, status, error) {
                    console.log("Error getting Messages ! \n", xhr, status, error);
                    $('#overlay').hide();
                }
            });

        });

        $(document).on('click','.deleteRecordButton',function(){
            let dataArr = $(this).attr('data-list').split('/');
            deleteRecord(dataArr[0],dataArr[1],dataArr[2]);
        });

        $(document).on('click','.editMessageButton',function(){
            //console.log($(this).attr('data-id'));
            editMessage($(this).attr('data-id'));
            $('#add_btn').text('UPDATE');
        });

        $(document).on('click','.addMessageFormat',function(){
            $('#frm_add_format').parsley().reset();
            $('#frm_add_format')[0].reset();
            CKEDITOR.instances.editor.setData('');

            $('#form_type').val('messageformats.addmessageformat');
            $('#edit_id').val('');
        });
        //SetEditor('');
        // Initialize CKEditor and other document ready tasks
        listMessages();

        // Define listMessages function in global scope
        function listMessages() {
            $('#overlay').show();
            $.ajax({
                url: "{{ route('messageformats.fetchmessageformats') }}",
                cache: false,
                data: { _token: '{{ csrf_token() }}', 'order': 'ASC' },
                type: 'GET',
                success: function(data) {
                    $('#overlay').hide();
                    $('#message_format_information').html(data);
                },
                error: function(xhr, status, error) {
                    $('#overlay').hide();
                }
            });
        }

    });

    </script>
@endpush

