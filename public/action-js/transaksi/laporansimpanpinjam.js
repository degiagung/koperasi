

let dtpr;

var datePickerOptions = {
  dateFormat: 'd/m/yy',
  firstDay: 1,
  changeMonth: true,
  changeYear: true
}

$(document).ready(function () {
    getListData();
});

$(".select2").select2();
$(".select2add").select2({
    dropdownParent: $("#modal-data"),
    dropdownParent: $("#modal-payment"),
});

$("#filter-btn").on('click',function(e){
    if($("#filter-tahun").val() == '' && $("#filter-bulan").val()){
        swalwarning('filter tahun harus diisi');
        return false ;
    };
    $('#table-list').dataTable().fnClearTable();
    $('#table-list').dataTable().fnDraw();
    $('#table-list').dataTable().fnDestroy();
    getListData();
    
});
let isObject = {};

function getListData() {
    $(".total").empty();
    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getlaporan",
            type: "POST",
            dataType: "json",
            data    : {
                'keanggotaan'   :$('#filter-keanggotaan').val(),
                'statuspinjam'  :$('#filter-status').val(),
                'tahun'         :$('#filter-tahun').val(),
                'bulan'         :$('#filter-bulan').val(),
            },
            dataSrc: function (response) {
                if (response.code == 0) {
                    console.log(response.data.sum[0])
                    es = response.data.data;
                    sum = response.data.sum[0];
                    $(".totalsimpanan").html(formatRupiah(sum.simpanan));
                    $(".totaltariksimpanan").html(formatRupiah(sum.tariksimpanan));
                    $(".totalsisasimpanan").html(formatRupiah(sum.sisasimpanan));
                    $(".totalpinjamawal").html(formatRupiah(sum.pinjaman));
                    $(".totalbayar").html(formatRupiah(sum.totalbayar));
                    $(".totalsisapinjam").html(formatRupiah(sum.sisapinjaman));
                    // console.log(es);
                    return es;
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
            { footer: true, text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'Laporan Periode transaksi('+$('#filter-tahun').val()+''+$('#filter-bulan').val()+')_date'+datenow(new Date), exportOptions: {columns:[':not(.notdown)']}},
        ],
        columns: [
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { data: "nrp" },
            { data: "name"},
            { render:function (data,type,row) {
                return datetostring2('yymmdd',row.tgl_dinas);
            } },
            { data: "keanggotaan" },
            { render:function (data,type,row) {
                return row.jmldinas+' Bulan';
            } },
            { render:function (data,type,row) {
                return formatRupiah(row.simpanan);
            } },
            { render:function (data,type,row) {
                return formatRupiah(row.tariksimpanan) ;
            } },
            { render:function (data,type,row) {
                return formatRupiah(row.sisasimpanan) ;
            } },
            { render:function (data,type,row) {
                return formatRupiah(row.pinjaman) ;
            } },
            { render:function (data,type,row) {
                return formatRupiah(row.totalbayar) ;
            } },
            { render:function (data,type,row) {
                return formatRupiah(row.sisapinjaman) ;
            } },
        ],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: "current" }).nodes();
            var last = null;

            
        },
    });
    var action    = dtpr.columns(".action");
    if(role == 'sekertaris koperasi' || role == 'superadmin' ){
        action.visible(true);
    }
}