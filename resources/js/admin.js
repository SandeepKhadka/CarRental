import "../assets/plugins/jquery/jquery.min.js";
import "./bootstrap";
import "../assets/dist/js/adminlte.js";

import "../assets/plugins/bootstrap/js/bootstrap.bundle.min.js";
import "../assets/plugins/chart/Chart.min.js";
import "../assets/plugins/sparklines/sparkline.js";
import "../assets/plugins/summernote/summernote-bs4.js";
import "../assets/plugins/laravel-filemanager/js/stand-alone-button.js";
import "../assets/plugins/bootstrap-switch-button/dist/bootstrap-switch-button.min.js";

import "../assets/plugins/jqvmap/jquery.vmap.min.js";
import "../assets/plugins/jqvmap/maps/jquery.vmap.usa.js";

import "../assets/plugins/jquery-knob/jquery.knob.min.js";

import "../assets/plugins/datatables/jquery.dataTables.min.js";

import "../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js";

import "../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js";

import "../assets/dist/js/pages/dashboard.js";

// import "../views/admin/section/scripts.blade.php"
//filemanager
$("#lfm").filemanager("image");

//summernote
$(document).ready(function () {
    $("#description").summernote();
});

$(document).ready(function () {
    $("#summary").summernote();
});

// var loadFile = function(event){
//     var holder = document.getElementById('holder');
//     holder.src = URL.createObjectURL(event.target.files[0]);
// }

//image preview
$(function () {
    $("#image").change(function () {
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf(".") + 1).toLowerCase();
        if (
            input.files &&
            input.files[0] &&
            (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")
        ) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#holder").attr("src", e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            $("#holder").attr("src", "");
        }
    });
});

// notification set timeout
setTimeout(function () {
    $("#alert").slideUp();
}, 4000);

// Data Tables

$(document).ready(function () {
    $("#table").DataTable();
});

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
