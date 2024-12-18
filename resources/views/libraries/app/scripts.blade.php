
<script src="{{ url('public/assets/js/plugin/webfont/webfont.min.js')}}"></script>

<script src="{{ url('public/assets/js/core/jquery-3.7.1.min.js')}}"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="{{ url('public/assets/js/core/popper.min.js')}}"></script>
<script src="{{ url('public/assets/js/core/bootstrap.min.js')}}"></script>

<!-- jQuery Scrollbar -->
<script src="{{ url('public/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

<!-- Chart JS -->
<script src="{{ url('public/assets/js/plugin/chart.js/chart.min.js')}}"></script>

<!-- jQuery Sparkline -->
<script src="{{ url('public/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

<!-- Chart Circle -->
<script src="{{ url('public/assets/js/plugin/chart-circle/circles.min.js')}}"></script>

<!-- Datatables -->
<script src="{{ url('public/assets/js/plugin/datatables/datatables.min.js')}}"></script>

<!-- Bootstrap Notify -->
<script src="{{ url('public/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

<!-- jQuery Vector Maps -->
{{-- <script src="{{ url('public/assets/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
<script src="{{ url('public/assets/js/plugin/jsvectormap/world.js')}}"></script> --}}

<!-- Sweet Alert -->
<script src="{{ url('public/assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

<!-- Kaiadmin JS -->
<script src="{{ url('public/assets/js/kaiadmin.min.js')}}"></script>

<!-- Kaiadmin DEMO methods, don't include it in your project! -->
<script src="{{ url('public/assets/js/setting-demo.js')}}"></script>
<script src="{{ url('public/assets/js/demo.js')}}?v={{ date('is') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ url('public/assets/js/paginathing.js')}}"></script>


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/jquery-clockpicker.min.js" integrity="sha512-x0qixPCOQbS3xAQw8BL9qjhAh185N7JSw39hzE/ff71BXg7P1fkynTqcLYMlNmwRDtgdoYgURIvos+NJ6g0rNg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.js" integrity="sha512-1QoWYDbO//G0JPa2VnQ3WrXtcgOGGCtdpt5y9riMW4NCCRBKQ4bs/XSKJAUSLIIcHmvUdKCXmQGxh37CQ8rtZQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
--}}

{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}


<script src="{{ url('public/assets/js/jquery.redirect.js')}}"></script>
<script src="{{ url('public/assets/js/parsley.js')}}"></script>
<script src="{{ url('public/assets/js/myscript.js')}}"></script>

<script src="{{ url('public/assets/js/select2.min.js')}}"></script>
{{-- <script src="{{ url('public/assets/js/nice-select2.js')}}"></script> --}}

<script>
    $('#overlay').hide();
    WebFont.load({
      google: { families: ["Public Sans:300,400,500,600,700"] },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["{{ url('public/assets/css/fonts.min.css')}}"],
      },
      active: function () {
        sessionStorage.fonts = true;
      },
    });

setInterval(function() {
    //alert();
    checkUserAvailability();
}, 60000);

function checkUserAvailability(){
    $.ajax({
        url: '{{ route('users.availability') }}',
        cache: false,
        method: 'GET',
        dataType: 'json',
        data: {_token: '{{ csrf_token() }}','action':'activeUser'},
        success: function(response){
            //alert();
            console.log(response.message);
            if(response.message == 'inactive'){
                Swal.fire({
                    position: "bottom-end",
                    icon: "success",
                    title: "You have Not Permission to access anything here please contact System Administrator..!!",
                    showConfirmButton: false,
                    timer: 5000
                });

                setTimeout(function() {
                    $.redirect("{{ route('admin.logout') }}", {'action': 'logout', _token: '{{ csrf_token() }}'}, "GET", "_self");
                }, 10000);
                //console.log(response.user_id);
                //console.log(response.user_name);
            }
        },
        error: function (errors) {
            console.log('Error:', errors);
        }
    });
}

  </script>
