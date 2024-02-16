

let dtpr;

$(document).ready(function () {
    getListData();
    gettotalsimpanan();
});

$(".select2").select2();
$(".select2add").select2({
    dropdownParent: $("#modal-approval"),
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
            url: baseURL + "/getlistpenarikan",
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
            { text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'List Penarikan Simpanan Periode transaksi('+$('#filter-tahun').val()+''+$('#filter-bulan').val()+')_date'+datenow(new Date), exportOptions: {columns:[':not(.notdown)']}},
        ],
        columns: [
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            // { render:function (data,type,row) {
            //     if(row.status == 'approve')
            //         return "<a class='approvalsukarela' style='color:green;cursor:pointer;font-weight:bold;' >APPROVED</a>";
            //     else if(row.status == 'reject')
            //         return "<a class='approvalsukarela' style='color:red;cursor:pointer;font-weight:bold;'>REJECTED</a>";
            //     else
            //         return "<a class='approvalsukarela' style='color:black;cursor:pointer;font-weight:bold;'>WAITING APPROVED</a>";
            // } },
            { visible:false,class:"notanggota",data: "nrp" },
            { visible:false,class:"notanggota",data: "name",render:function (data,type,row) {
                return row.name;
            } },
            { visible:false,class:"notanggota",data: "keanggotaan" },
            
            // { render:function (data,type,row) {
            //     return datetostring2('yymmdd',row.tgl_pengajuan);
            // } },
            { render:function (data,type,row) {
                return datetostring2('yymmdd',row.tgl_approve);
            } },
            // { render:function (data,type,row) {
            //     return formatRupiah(row.simpanan);
            // } },
            { render:function (data,type,row) {
                return formatRupiah(row.jml_pengajuan);
            } },
            // { render:function (data,type,row) {
            //     return formatRupiah(row.simpanan - row.jml_pengajuan);
            // } },
            { render:function (data,type,row) {
                return `<a class="bukti" style="cursor:pointer;">Klik Disini</a>`;
            } },
            
        ],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: "current" }).nodes();
            var last = null;

            $(rows)
                .find(".approvalsukarela")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    if(role == 'superadmin' || role == 'bendahara koperasi'){
                        isObject = {};
                        isObject = rowData ;
                        $("#modal-approval").modal('show');
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
            $(rows)
                .find(".bukti")
                .on("click", function () {
                    isObject = {};
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    isObject = rowData;
                    buktitarik();
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

function approval(){
    let status = $("#form-statusapprove").val();
    swal({
        title: "Yakin untuk "+status+" simpanan "+ isObject.name +" ?",
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
                url: baseURL + "/approvaltariksimpan",
                type: "POST",
                data: JSON.stringify({ id: isObject.idpenarikan, status: status }),
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
    jumlah = $("#form-pengajuan").val();
    jumlah = jumlah.replaceAll('.','');
    if (jumlah < 100000){
        swalwarning('Minimal Penarikan Rp 100000');
        return false;
    }
    if (parseFloat(jumlah) > parseFloat(issimpanan) ){
        swalwarning('Simpanan tidak mencukupi');
        return false;
    }

    ajukanpinjaman();
});

function ajukanpinjaman(){
    jumlah      = $("#form-pengajuan").val() ;
    jumlah      = jumlah.replaceAll('.','');
    title = 'Penarikan Rp.'+formatRupiah(jumlah) +' ? ';
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
                url: baseURL + "/actionpenarikan",
                type: "POST",
                data: JSON.stringify({ 
                    jumlah      : jumlah,
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

                },
                success: function (response) {
                    // Handle response sukses
                    if (response.code == 0) {
                        swal("BERHASIL !", response.message, "success");
                            $("#modal-data").modal("hide");

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

var issimpanan = 0 ; 
async function gettotalsimpanan() {
    $(".inputan").val('');
    try {
        const response = await $.ajax({
            url: baseURL + "/getsimpananperson",
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                // Swal.fire({
                //     title: "Loading",
                //     text: "Please wait...",
                // });
            },
        });
        if(response.data){
            item = response.data[0] ;
            $("#form-simpanan").val('Rp. '+formatRupiah(item.amount));
            issimpanan = item.amount ;
        }
        // const res = response.data.map(function (item) {
        // });

    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}

async function buktitarik() {

    $(".buktidiv").empty();
    try {
        const response = await $.ajax({
            url: baseURL + "/getbuktitarik",
            type: "POST",
            dataType: "json",
            data:{
                id      : isObject.idpenarikan ,
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
        }else{
            if (role == 'bendahara koperasi' || role == 'superadmin') {
                $("#form-bukti").val('');
                $("#modal-upload").modal('show');
            }

            if (role == 'anggota') {
                $("#modal-bukti").modal('show');
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
    formData.append('id',isObject.idpenarikan);
    formData.append('userid',isObject.user);

    $.ajax({
        url: baseURL + "/saveBuktitarik",
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