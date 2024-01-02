

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
            url: baseURL + "/getPinjaman",
            type: "POST",
            dataType: "json",
            data    : {
                'keanggotaan'   :$('#filter-keanggotaan').val(),
                'statuspinjam'  :$('#filter-status').val()
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
            { text: ' ', extend: 'pdfHtml5',  className: 'btndownload iconpdf',  title:'Pinjaman Anggota', exportOptions: {columns:[':not(.notdown)']}},
            { text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'Pinjaman Anggota', exportOptions: {columns:[':not(.notdown)']}},
        ],
        columns: [
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { render:function (data,type,row) {
                if(row.sisatenor == row.totaltenor || row.status_pinjaman == 'lunas')
                    return "<a style='color:green;cursor:pointer;'>LUNAS</a>";
                 else
                    return "<a style='color:red;cursor:pointer;'>BELUM LUNAS</a>";
            } },
            { data: "nrp" },
            { data: "name",render:function (data,type,row) {
                return "<a class='detail' style='cursor:pointer;'>"+row.name+"</a>";
            } },
            { render:function (data,type,row) {
                return datetostring2('yymmdd',row.tgl_dinas);
            } },
            { data: "keanggotaan" },
            { render:function (data,type,row) {
                if (row.limitpinjaman > 0)
                return 'Rp. ' +formatRupiah(row.limitpinjaman);
                else
                return 'Rp. 0';
            } },
            { render:function (data,type,row) {
                if (row.pinjaman2persen > 0)
                return row.tenor +' BLN & Rp.'+formatRupiah(row.pinjaman)+ '<b>X2%/BLN</b> = Rp.' +formatRupiah(row.pinjaman2persen);
                else
                return row.tenor +' BLN & Rp.0';
            } },
            { render:function (data,type,row) {
                if (row.totalbayar > 0)
                return row.totaltenor+' X Rp.'+formatRupiah(row.totalbayarperbulan)+' = Rp.' +formatRupiah(row.totalbayar);
                else
                return row.totaltenor+' X 0';
            } },
            { render:function (data,type,row) {
                if (row.sisalimit > 0)
                return 'Rp. ' +formatRupiah(row.sisalimit);
                else
                return '0';
            } },
            { render:function (data,type,row) {
                if (row.sisapinjaman > 0)
                return row.sisatenor+' & Rp.' +formatRupiah(row.sisapinjaman);
                else
                return row.sisatenor+' & Rp.0';
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
    $("#form-smwajib").val(rowData.simpananpokokwajib);
    $("#form-smpokok").val(rowData.simpananpokokwajib);
    $("#form-smsukarela").val(rowData.sukarela);
    $("#form-tarik").val(rowData.penarikan);
    $("#form-tgltarik").val(rowData.tgl_penarikan);
    $("#form-saldo").val(rowData.saldo);


    $("#modal-data").modal("show");
}