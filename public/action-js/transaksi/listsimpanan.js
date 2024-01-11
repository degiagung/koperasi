

let dtpr;

$(document).ready(function () {
    getListData();
});

$(".select2").select2();
$(".select2add").select2({
    dropdownParent: $("#modal-data"),
});

$("#filter-btn").on('click',function(e){
    $('#table-list').dataTable().fnClearTable();
    $('#table-list').dataTable().fnDraw();
    $('#table-list').dataTable().fnDestroy();
    getListData();
    
});
let isObject = {};

function getListData() {

    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getSimpanan",
            type: "POST",
            dataType: "json",
            data    : {
                'keanggotaan'   :$('#filter-keanggotaan').val()
            },
            dataSrc: function (response) {
                if (response.code == 0) {
                    es = response.data;
                    // console.log(es);

                    return response.data;
                } else {
                    return response;
                }
            },
            complete: function () {
                // loaderPage(false);
            },
        },
        processing:true,
        autoWidth: false,
        dom: '<"datatable-header"lfB><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search      : '_INPUT_',
            lengthMenu  : '_MENU_',
            paginate    : { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        buttons: [
            
            { 
                className: 'btnreload',
                text: '<i class="bi bi-arrow-clockwise" ></li>',
                action: function ( e, dt, node, config ) {     
                    $('#table-list').DataTable().ajax.reload();
                }
            },
            { text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'List Simpanan', exportOptions: {columns:[':not(.notdown)']}},
        ],
        columns: [
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { data: "nrp" },
            { data: "name",render:function (data,type,row) {
                return "<a class='detail' style='cursor:pointer;'>"+row.name+"</a>";
            } },
            { render:function (data,type,row) {
                return datetostring2('yymmdd',row.tgl_dinas);
            } },
            { data: "keanggotaan" },
            { render:function (data,type,row) {
                return 'Rp. ' +formatRupiah(row.simpananpokok);
            } },
            { render:function (data,type,row) {
                return 'Rp. ' +formatRupiah(row.simpananwajib);
            } },
            { render:function (data,type,row) {
                return 'Rp. ' +formatRupiah(row.sukarela);
            } },
            { render:function (data,type,row) {
                return 'Rp. ' +formatRupiah(row.total);
            } },
            { render:function (data,type,row) {
                return 'Rp. ' +formatRupiah(row.penarikan);
            } },
            { render:function (data,type,row) {
                if (row.saldo > 0)
                return 'Rp. ' +formatRupiah(row.saldo);
                else
                return 'Rp. 0';
            } },
        ],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: "current" }).nodes();
            var last = null;

            $(rows)
                .find(".detail")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    detail(rowData);
                });
        },
    });
    var action    = dtpr.columns(".action");
    if(role == 'sekertaris koperasi' || role == 'superadmin' ){
        action.visible(true);
    }
}

function detail(rowData) {
    isObject = rowData;

    $("#form-nrp").val(rowData.nrp);
    $("#form-name").val(rowData.name);
    $("#form-tgldinas").val(datetostring2('yymmdd',rowData.tgl_dinas));
    $("#form-smwajib").val(formatRupiah(rowData.simpananpokok));
    $("#form-smpokok").val(formatRupiah(rowData.simpananwajib));
    $("#form-smsukarela").val(formatRupiah(rowData.sukarela));
    $("#form-tarik").val(formatRupiah(rowData.penarikan));
    $("#form-tgltarik").val(rowData.tgl_penarikan);
    $("#form-saldo").val(formatRupiah(rowData.saldo));


    $("#modal-data").modal("show");
}