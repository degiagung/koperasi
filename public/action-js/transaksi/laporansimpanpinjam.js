

let dtpr;

$(document).ready(function () {
    getListData();
});

$(".select2").select2();
$(".select2add").select2({
    dropdownParent: $("#modal-data"),
    dropdownParent: $("#modal-payment"),
});

$("#filter-btn").on('click',function(e){
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
                'statuspinjam'  :$('#filter-status').val()
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
                    return "<a style='font-weight:bold;color:green;cursor:pointer;'>LUNAS</a>";
                 else
                    return "<a style='font-weight:bold;color:red;cursor:pointer;'>BELUM LUNAS</a>";
            } },
            { data: "nrp" },
            { data: "name"},
            { render:function (data,type,row) {
                return datetostring2('yymmdd',row.tgl_dinas);
            } },
            { data: "keanggotaan" },
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

            $(rows)
                .find(".updatestatus")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    if(role == 'superadmin' || role == 'bendahara koperasi'){
                        isObject = {};
                        isObject = rowData ;
                        $("#modal-payment").modal('show');
                    }
                });

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
    pengajuan = rowData.tenor +' BLN & Rp.'+formatRupiah(rowData.pinjaman)+ ' X2%  = Rp.' +formatRupiah(rowData.pinjamanbunga) ;
    if(rowData.status_pinjaman == 'lunas'){
        saldo = formatRupiah(rowData.limitpinjaman)
    }else{
        saldo = formatRupiah(rowData.sisalimit);
    }
    
    if(rowData.status_pinjaman == 'lunas'){
        sisalimit = formatRupiah(rowData.limitpinjaman);
    }else{
        sisalimit = rowData.totaltenor+' BLN X '+formatRupiah(rowData.totalbayarperbulan1)+' = ' +formatRupiah(rowData.totalbayar1);
    }
        
    console.log(rowData);
    $("#form-nrp").val(rowData.nrp);
    $("#form-name").val(rowData.name);
    $("#form-keanggotaan").val(rowData.keanggotaan);
    $("#form-tgldinas").val(datetostring2('yymmdd',rowData.tgl_dinas));
    $("#form-limit").val(formatRupiah(rowData.limitpinjaman));
    $("#form-totallimit").val(sisalimit);
    $("#form-pinjaman").val(pengajuan);
    $("#form-tgltarik").val(datetostring2('yymmdd',rowData.tgl_aju));
    $("#form-saldo").val(saldo);


    $("#modal-data").modal("show");
}

function approval(){
    let status = $("#form-statuslunas").val();
    swal({
        title: "Yakin untuk update "+status+" pinjaman "+ isObject.name +" ?",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, update "+status+" !!",
        cancelButtonText: "Tidak, Batalkan !!",
        closeOnConfirm: !1,
        closeOnCancel: !1,
    }).then(function (e) {
        if (e.value) {
            $.ajax({
                url: baseURL + "/approvalpinjaman",
                type: "POST",
                data: JSON.stringify({ idpinjam: isObject.idpinjam, status: status,jenis: 'statuslunas' }),
                dataType: "json",
                contentType: "application/json",
                beforeSend: function () {
                    Swal.fire({
                        title: "Loading",
                        text: "Please wait...",
                    });
                },
                complete: function () {
                    $('#table-list').DataTable().ajax.reload();
                },
                success: function (response) {
                    // Handle response sukses
                    if (response.code == 0) {
                        swal("BERHASIL !", response.message, "success");
                        $("#modal-payment").modal('hide');
                    } else {
                        sweetAlert("Oops...", response.message, "ERROR");
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    // console.log("ERROR");
                    sweetAlert("Oops...", "ERROR", "ERROR");
                },
            });
        } else {
            swal(
                "BATAL !!",
            );
        }
    });
}