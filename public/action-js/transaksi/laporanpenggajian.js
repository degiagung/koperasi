$("#filter-btn").on('click',function(e){
    $('#table-list').dataTable().fnClearTable();
    $('#table-list').dataTable().fnDraw();
    $('#table-list').dataTable().fnDestroy();
    getListData();
    
});

getListData();
function getListData() {
    $(".total").empty();
    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getlaporanpotongan",
            type: "POST",
            dataType: "json",
            data    : {
                'periode'   :$('#periode').val(),
            },
            dataSrc: function (response) {
                if (response.code == 0) {
                    console.log(response.data.sum[0])
                    es = response.data.data;
                    sum = response.data.sum[0];
                    // $(".totalsimpanan").html(formatRupiah(sum.simpanan));
                    // $(".totaltariksimpanan").html(formatRupiah(sum.tariksimpanan));
                    // $(".totalsisasimpanan").html(formatRupiah(sum.sisasimpanan));
                    // $(".totalpinjamawal").html(formatRupiah(sum.pinjaman));
                    // $(".totalbayar").html(formatRupiah(sum.totalbayar));
                    // $(".totalsisapinjam").html(formatRupiah(sum.sisapinjaman));
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
            { footer: true, text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'Laporan transaksi_date'+datenow(new Date), exportOptions: {columns:[':not(.notdown)']}},
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
                return formatRupiah(row.pinjaman);
            } },
            { render:function (data,type,row) {
                return formatRupiah(row.wajib);
            } },
            { render:function (data,type,row) {
                return formatRupiah(row.sukarela);
            } },
            { render:function (data,type,row) {
                return formatRupiah(row.total);
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