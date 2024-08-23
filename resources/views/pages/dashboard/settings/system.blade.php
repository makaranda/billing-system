@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3 text-capitalize">System</h3>
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
            <a href="#">System</a>
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
                                     <h1 class="text-uppercase">System</h1>

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

                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                            <div class="card-header">PROPERTY INFORMATION</div>
                                              <div class="card-body">
                                                <form name="system_information" id="system_information" method="post">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="hotel_name">Property Name</label>
                                                                <input type="text" class="form-control" id="hotel_name" name="hotel_name" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="full_name">Web Site</label>
                                                                <input type="text" class="form-control" id="web_site" name="web_site" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="physical_address">Physical Address</label>
                                                                <textarea class="form-control" id="physical_address" name="physical_address"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="postal_address">Postal Address</label>
                                                                <textarea class="form-control" id="postal_address" name="postal_address"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="telephone">Telephone</label>
                                                                <input type="text" class="form-control" id="telephone" name="telephone" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="mobile">Mobile</label>
                                                                <input type="text" class="form-control" id="mobile" name="mobile" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="fax">Fax</label>
                                                                <input type="text" class="form-control" id="fax" name="fax" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="email">Email</label>
                                                                <input type="email" class="form-control" id="email" name="email" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label" for="tandc">Terms and Conditions</label>
                                                                <textarea class="form-control" id="tandc" name="tandc"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <button type="submit" name="submit" class="btn btn-primary form-control">Save</button>
                                                                <input type="hidden" name="edit_id" id="edit_id">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                            <div class="card-header">LOGO IMAGE</div>
                                              <div class="card-body">
                                                <form name="frm_logo" id="frm_logo" method="post">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label" for="logo">Logo Image</label>
                                                                        <input type="file" id="logo" />
                                                                        <input type="hidden" class="form-control" id="photo_logo" name="photo_logo">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button type="button" id="upload_logo" class="btn btn-primary form-control">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="control-label" for="logo_image">Preview</label>
                                                            <img src="#" id="logo_image" width="200" class="pull-right" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <i>Image must be 400 X 150 Pixels in dimension. Otherwise it will not properly display in used places.</i>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                            <div class="card-header">LETTER HEAD IMAGE (2380 X 300 Pixels)</div>
                                              <div class="card-body">
                                                <form name="frm_letter_head" id="frm_letter_head" method="post">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label" for="letter_head">Letter Head Image</label>
                                                                        <input type="file" id="letter_head" />
                                                                        <input type="hidden" class="form-control" id="photo_letter_head" name="photo_letter_head">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button type="button" id="upload_letter_head" class="btn btn-primary form-control">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="control-label" for="letter_head_image">Preview</label>
                                                            <img src="#" id="letter_head_image" width="100%" class="pull-right" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <i>Image must be 2380 X 300 Pixels in dimension. Otherwise it will not properly display in used places.</i>
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

@endsection

@push('css')
    <style>

    </style>
@endpush

@push('scripts')
    <script src="{{ url('public/vendors/ckeditor/ckeditor.js') }}"></script>
    <script>
    $( document ).ready( function () {
        CKEDITOR.replace( 'tandc' );

        $('#system_information').parsley();
        $('#system_information').on('submit',function(event){
            event.preventDefault();
            $('#overlay').show();
        //alert();
            $.ajax({
                url: ""+form_type+"",
                cache: false,
                method: 'POST',
                data: $(this).serialize() + '&_token={{ csrf_token() }}&action=addSystemInformation&debtCollectorVal='+debtCollectorValue+'',
                success: function(response){
                    console.log(response.message);
                    get_hotel();

                    $('#system_information').parsley().reset();
                    //$('#system_information')[0].reset();
                    if(response.messageType == 'success'){
                        Swal.fire({
                            position: "bottom-end",
                            icon: "success",
                            title: ""+response.message+"",
                            showConfirmButton: false,
                            timer: 4000
                        });
                    }else if(response.messageType == 'wrong'){
                        Swal.fire({
                            position: "bottom-end",
                            icon: "error",
                            title: ""+response.message+"",
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }

                    $('#overlay').hide();
                },
                error: function (errors) {
                    console.log('Error:', errors);
                    $('#overlay').hide();
                }
            });
        });

        get_hotel();
        function get_hotel() {
            $('#overlay').show();

            $.ajax({
            url : "{{ route('system.information') }}",
            cache: false,
            data: {_token: '{{ csrf_token() }}','hotel':'hotel'},
            type: 'GET',
            dataType: 'json',
            success : function(data) {
                console.log(data);
                if(data.getSyetemDetails != ''){
                    //alert(data.getSyetemDetails[0].name);
                    $('#hotel_name').val(data.getSyetemDetails[0].name);
                    $('#physical_address').val(data.getSyetemDetails[0].address);
                    $('#postal_address').val(data.getSyetemDetails[0].address_post);
                    $('#telephone').val(data.getSyetemDetails[0].telephone);
                    $('#mobile').val(data.getSyetemDetails[0].mobile);
                    $('#fax').val(data.getSyetemDetails[0].fax);
                    $('#email').val(data.getSyetemDetails[0].email);
                    $('#web_site').val(data.getSyetemDetails[0].web);
                    CKEDITOR.instances.tandc.setData(data.getSyetemDetails[0].tandc);
                    $('#logo_image').attr('src', "{{ url('public/images/setting/') }}/" + data.getSyetemDetails[0].logo + "?" + new Date().getTime());
                    $('#letter_head_image').attr('src', "{{ url('public/images/setting/') }}/" + data.getSyetemDetails[0].letter_head + "?" + new Date().getTime());
                }
                $('#overlay').hide();
            },
            error: function(data) {
                $('#overlay').hide();
            }
        });
        }


        function readURL1(input){
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                $('#logo_image').attr('src',e.target.result);
                $('#photo_logo').val(e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL2(input){
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                $('#letter_head_image').attr('src',e.target.result);
                $('#photo_letter_head').val(e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#logo').change(function() {
            readURL1(this);
        });

        $('#letter_head').change(function() {
            readURL2(this);
        });

    });
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

