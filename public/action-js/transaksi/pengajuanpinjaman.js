

let dtpr;

$(document).ready(function () {
    getListData();
    getdatlimitpinjaman();
});

$(".select2").select2();
$("#form-batal").select2({
    dropdownParent: $("#modal-batal"),
});
$("#form-statusapprove").select2({
    dropdownParent: $("#modal-approval"),
});
$(".select2add1").select2({
    dropdownParent: $("#modal-data"),
});
$("#form-tenor").select2({
    dropdownParent: $("#modal-data"),
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
let isId = '';
function getListData() {

    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getpengajuanpinjaman",
            type: "POST",
            dataType: "json",
            data    : {
                'keanggotaan'   :$('#filter-keanggotaan').val(),
                'statuspinjam'  :$('#filter-approve').val(),
                'tahun'         :$('#filter-tahun').val(),
                'bulan'         :$('#filter-bulan').val(),
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
            { text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'List Pengajuan Pinjaman Periode transaksi('+$('#filter-tahun').val()+''+$('#filter-bulan').val()+')_date'+datenow(new Date), exportOptions: {columns:[':not(.notdown)']}},
        ],
        columns: [
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { render:function (data,type,row) {
                if(row.status == 'approve')
                    return "<a class='approvalpinjaman' style='color:green;cursor:pointer;font-weight:bold;' >APPROVED</a>";
                else if(row.status == 'reject')
                    return "<a class='approvalpinjaman' style='color:red;cursor:pointer;font-weight:bold;'>REJECTED</a>";
                else if(row.status == 'batal')
                    return "<a class='approvalpinjaman' style='color:red;cursor:pointer;font-weight:bold;'>DI BATALKAN</a>";
                else
                    return "<a class='approvalpinjaman' style='color:black;cursor:pointer;font-weight:bold;'>WAITING APPROVED</a>";
            } },
            { visible:false,class:"notanggota",data: "nrp" },
            { visible:false,class:"notanggota",data: "name",render:function (data,type,row) {
                return row.name;
            } },
            { render:function (data,type,row) {
                return datetostring2('yymmdd',row.tgl_approve);
            } },
            { visible:false,class:"notanggota",data: "keanggotaan" },
            { render:function (data,type,row) {
                if (row.limitpinjaman > 0)
                return 'Rp. ' +formatRupiah(row.limitpinjaman);
                else
                return 'Rp. 0';
            } },
            { render:function (data,type,row) {
                // return row.tenor +' BLN & Rp.'+formatRupiah(row.pinjaman)+ '<b>X2%/BLN</b> = Rp.' +formatRupiah(row.pinjaman2persen);
                return row.tenor +' BLN & Rp.'+formatRupiah(row.pinjaman)+ '<b>X2%</b> = Rp.' +formatRupiah(row.pinjamanbunga);
    
            } },
            { render:function (data,type,row) {
                // return row.totaltenor+' BLN X Rp.'+formatRupiah(row.totalbayarperbulan)+' = Rp.' +formatRupiah(row.totalbayar);
                return row.totaltenor+' BLN X Rp.'+formatRupiah(row.totalbayarperbulan1)+' = Rp.' +formatRupiah(row.totalbayar1);
        
            } },
            { render:function (data,type,row) {
                if (row.sisalimit > 0)
                return 'Rp. ' +formatRupiah(row.sisalimit);
                else
                return '0';
            } },
            { render:function (data,type,row) {
                if (row.sisapinjaman > 0)
                return row.sisatenor+' BLN & Rp.' +formatRupiah(row.sisapinjaman);
                else
                return row.sisatenor+' BLN & Rp.0';
            } },
            { visible:false,sClass:"notdown action",render:function (data,type,row) {
                return "<a style='cursor:pointer' class='pengajuan'>Klik Disini</a>";
            } },
            { visible:false,sClass:"notdown action",render:function (data,type,row) {
                return "<a style='cursor:pointer' class='perjanjian'>Klik Disini</a>";
            } },
            { sClass:"notdown",render:function (data,type,row) {
                return "<a style='cursor:pointer' class='buktitf'>Klik Disini</a>";
            } },
        ],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: "current" }).nodes();
            var last = null;

            $(rows)
                .find(".approvalpinjaman")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    if((role == 'superadmin' || role == 'bendahara koperasi') && rowData.status == null){
                        isObject = {};
                        isObject = rowData ;
                        $("#modal-approval").modal('show');
                    }
                    if(role == 'anggota' && rowData.status == null){
                        $("#modal-batal").modal('show');
                    }
                });
            $(rows)
                .find(".pengajuan")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    detailpengajuan(rowData);
                });
            $(rows)
                .find(".buktitf")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    isObject = {};
                    isObject = rowData;
                    buktitf(rowData);
                });
            $(rows)
                .find(".perjanjian")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    if(rowData.status != 'approve'){
                        swalwarning('Maaf status pinjaman rejected');
                        return false;
                    }
                    detailperjanjian(rowData);
                });
        },
    });
    var action    = dtpr.columns(".action");
    var notanggota  = dtpr.columns(".notanggota");
    if(role == 'sekertaris koperasi' || role == 'superadmin' ){
        action.visible(true);
    }
    if(role != 'anggota'){
        notanggota.visible(true);
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

function detailpengajuan(rowData) {
    $(".nama").text('');
    $(".noanggota").text('');
    $(".pangkat").text('');
    $(".pinjaman").text('');
    $(".keperluan").text('');
    $(".tenor").text('');
    $(".tempattanggal").text('');
    $(".pangkatttd").text('');
    $(".pinjaman").text('');
    $(".tempattanggal").text('');

    $(".nama").text(rowData.name);
    $(".noanggota").text(rowData.no_anggota);
    $(".pangkat").text(rowData.pangkat+'/'+rowData.nrp);
    $(".pinjaman").text(formatRupiah(rowData.pinjaman) + ' ('+pembilang(rowData.pinjaman)+')');
    $(".keperluan").text(rowData.jenis);
    $(".tenor").text(rowData.tenor +' Bulan');
    $(".pangkatttd").text(rowData.pangkat+' NRP '+rowData.nrp);

    
    $("#modal-pengajuan").modal("show");
}

function detailperjanjian(rowData) {
    $(".pengajuannama").text('');
    $(".pengajuanpinjaman").text('');
    $(".pengajuantenor").text('');
    $(".pengajuanbayarsimpanan").text('');
    $(".pengajuatempattanggal").text('');
    $(".pengajuatempattanggal").text('');
    $(".pengajuanprovisi").text('');
    $(".pengajuanditerima").text('');
    $(".pengajuanterbilang").text('');

    pengajuanrp = rowData.pinjaman - (rowData.pinjaman*0.01) - 10000 ;
    $(".pengajuannama").text(rowData.name+'/'+rowData.pangkat+'/'+rowData.nrp);
    $(".pengajuanpinjaman").text(formatRupiah(rowData.pinjaman));
    $(".pengajuantenor").text(rowData.tenor);
    $(".pengajuanbayarsimpanan").text();
    $(".pengajuanprovisi").text(formatRupiah(rowData.pinjaman*0.01));
    $(".pengajuanditerima").text(formatRupiah(pengajuanrp));
    $(".pengajuanterbilang").text(pembilang(pengajuanrp));

    

    
    $("#modal-perjanjian").modal("show");
}

$(".tanggalinput" ).on('change',function() {
    $('.tempattanggal').empty();
    var tempat    = $(".tempatinput").val();
    var tanggal    = $(".tanggalinput").val();
    if(tempat == ''){
        swalwarning('Tempat Harus Di isi');
        return false ;
    }


    $('.tempattanggal').empty();
    $('.tempattanggal').text(tempat+', '+datetostring2('yymmdd',tanggal));

});
$(".pengajuantanggalinput" ).on('change',function() {
    $('.pengajuantempattanggal').empty();
    var tempat    = $(".pengajuantempatinput").val();
    var tanggal    = $(".pengajuantanggalinput").val();
    if(tempat == ''){
        swalwarning('Tempat Harus Di isi');
        return false ;
    }


    $('.pengajuatempattanggal').empty();
    $('.pengajuatempattanggal').text(tempat+', '+datetostring2('yymmdd',tanggal));

});

function printDiv(divId, title){
    $(".tempatinput").empty();
    $(".tanggalinput").empty();

    
  let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

  mywindow.document.write(`<html><head><title>${title}</title>`);
//   mywindow.document.write('</head><body style="padding-left: 200px;padding-right: 150px;padding-top: 150px;padding-bottom: 150px; !important;">');
  mywindow.document.write('</head><body>');
  mywindow.document.write(document.getElementById(divId).innerHTML);
  mywindow.document.write('</body></html>');

  mywindow.document.close(); // necessary for IE >= 10
  mywindow.focus(); // necessary for IE >= 10*/

  mywindow.print();
}

function approval(){
    let status = $("#form-statusapprove").val();
    if(role == 'anggota'){
        title = "Yakin untuk membatalkan pinjaman ?"
        status = 'batal';
    }else{
        title = "Yakin untuk "+status+" pinjaman "+ isObject.name +" ?" ;
    }
    swal({
        title: title,
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, "+status+" !!",
        cancelButtonText: "Tidak, Batalkan !!",
        closeOnConfirm: !1,
        closeOnCancel: !1,
    }).then(function (e) {
        if (e.value) {
            $.ajax({
                url: baseURL + "/approvalpinjaman",
                type: "POST",
                data: JSON.stringify({ idpinjam: isObject.idpinjam, status: status,jenis: '',pinjaman:isObject.pinjaman }),
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
                        $("#modal-approval").modal('hide');
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

$("#add-btn").on("click", function (e) {
    e.preventDefault();
    isObject = {};
    $("#form-pinjaman").val("");
    $("#form-tenor").val("");
    $("#modal-data").modal("show");
});

$("#ajukan-btn").on("click", function (e) {
    e.preventDefault();
    jumlah = $("#form-pinjaman").val();
    jumlah = jumlah.replaceAll('.','');
    if (jumlah < 500000){
        swalwarning('Minimal pengajuan Rp 500.000');
        return false;
    }
    if (parseFloat(jumlah) > parseFloat(islimit)){
        swalwarning('Limit Pinjaman tidak cukup');
        return false;
    }
    if ($("#form-tenor").val() < 5){
        swalwarning('Minimal tenor 5 Bulan');
        return false;
    }
    if ($("#form-keperluan").val() == ''){
        swalwarning('Keperluan harus diisi.');
        return false;
    }

    ajukanpinjaman();
});

function ajukanpinjaman(){
    pinjaman = $("#form-pinjaman").val() ;
    pinjaman = pinjaman.replaceAll('.','');
    tenor = $("#form-tenor").val() ;
    keperluan = $("#form-keperluan").val() ;
    title = 'Pinjaman Rp.'+formatRupiah(pinjaman)+' dengan tenor '+tenor+' Bulan ?';
    swal({
        title: title,
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Benar !!",
        cancelButtonText: "Tidak, Batalkan !!",
        closeOnConfirm: !1,
        closeOnCancel: !1,
    }).then(function (e) {
        if (e.value) {
            $.ajax({
                url: baseURL + "/actionpengajuanpinjaman",
                type: "POST",
                data: JSON.stringify({ 
                    pinjaman: pinjaman, 
                    tenor   : tenor,
                    keperluan   : keperluan 
                }),
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
                    getdatlimitpinjaman();
                },
                success: function (response) {
                    // Handle response sukses
                    if (response.code == 0) {
                        swal("BERHASIL !", response.message, "success");
                            $("#modal-data").modal("hide");
                            $("#modal-batal").modal("hide");

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
var islimit = 0 ; 
async function getdatlimitpinjaman() {
    $(".inputan").val('');
    try {
        const response = await $.ajax({
            url: baseURL + "/getlimitpinjaman",
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                // Swal.fire({
                //     title: "Loading",
                //     text: "Please wait...",
                // });
            },
        });
        const res = response.data.map(function (item) {
            $("#form-limit").val('Rp. '+formatRupiah(item.amount));
            islimit = item.amount ;
        });

        $("#form-role").select2({
            data: res,
            placeholder: "Please choose an option",
            dropdownParent: $("#modal-data"),
        });
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}

async function buktitf() {

    $(".buktidiv").empty();
    try {
        const response = await $.ajax({
            url: baseURL + "/getbuktitfpinjaman",
            type: "POST",
            dataType: "json",
            data:{
                id      : isObject.idpinjam ,
                userid  : isObject.user ,
            },
            beforeSend: function () {
                
            },
        });
        
        if( response.data.length >=1){
            file = response.data[0].file ;
            file = baseURL+file.replaceAll('../public','');
            content =`<center>
                            <img src="`+file+`" style="width:300px;" alt="">
                        <center>
            `;
            $(".buktidiv").append(content);
            $("#modal-bukti").modal('show');
        }else{
            $("#form-bukti").val('');
            if (role == 'bendahara koperasi' || role == 'superadmin') {
                $("#modal-upload").modal('show');
            }
            
        }
        
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}

$("#simpanbukti-btn").on("click", function (e) {
    e.preventDefault();

    if ($("#form-bukti").val() == ''){
        swalwarning('Bukti tidak boleh kosong');
        return false;
    }

    simpanbukti();
});

function simpanbukti() {
    const formData    = new FormData(document.getElementById("formbukti"));
    formData.append('id',isObject.idpinjam);
    formData.append('userid',isObject.user);

    $.ajax({
        url: baseURL + "/saveBuktitfpinjaman",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
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
                swal("BERHASIL !", response.info, "success");
                $("#modal-upload").modal("hide");
                $("#modal-bukti").modal("hide");
                $("#modal-detail").modal("hide");
                
                isObject = {};
            } else {
                sweetAlert("Oops...", response.info, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
}