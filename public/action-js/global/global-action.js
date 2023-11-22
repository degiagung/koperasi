$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});


$(".datatable-basic").DataTable();
$(".select-search").select2();