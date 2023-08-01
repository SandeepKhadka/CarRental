{{-- <!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.js') }}"></script>

<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sparklines/sparkline.js') }}"></script>
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('assets/plugins/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-switch-button/dist/bootstrap-switch-button.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('assets/dist/js/pages/dashboard.js') }}"></script>

<script>
    //filemanager
    $("#lfm").filemanager("image");
</script>

<script>
    //summernote
    $(document).ready(function() {
        $("#description").summernote();
    });

    $(document).ready(function() {
        $("#summary").summernote();
    });
</script>

<script>
    //image preview
    $(function() {
        $("#image").change(function() {
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf(".") + 1).toLowerCase();
            if (
                input.files &&
                input.files[0] &&
                (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")
            ) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $("#holder").attr("src", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                $("#holder").attr("src", "");
            }
        });
    });
</script>

<script>
    // notification set timeout
    setTimeout(function() {
        $("#alert").slideUp();
    }, 4000);
</script>

<script>
    // Data Tables

    $(document).ready(function() {
        $("#table").DataTable();
    });
</script>

<script>
    if (window.$('#is_parent').is(':checked')) {
        window.$('#parent_cat_div').hide();
    }
    window.$('#is_parent').change(function() {
        window.$('#parent_cat_div').slideToggle();
    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script> --}}
@yield('scripts')
</body>

</html>
