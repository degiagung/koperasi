

let dtpr;

$(document).ready(function () {
    getListData();
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
            url: baseURL + "/getpengajuansukarela",
            type: "POST",
            dataType: "json",
            data    : {
                'keanggotaan'   :$('#filter-keanggotaan').val(),
                'statuspinjam'  :$('#filter-approve').val(),
                'jenis'         :$('#filter-jenis').val(),
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
            { text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'List Pengajuan Simpanan Sukarela Periode transaksi('+$('#filter-tahun').val()+''+$('#filter-bulan').val()+')_date'+datenow(new Date), exportOptions: {columns:[':not(.notdown)']}},
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
            { visibe:false,class:"notanggota",data: "name",render:function (data,type,row) {
                if(row.jenis == 'manual'){
                    if(row.created_by)
                        return 'tunai'
                    else
                        return 'Transfer';
                }else if(row.jenis == 'potong gaji'){
                    return 'Potong dari gaji';
                }else{
                    return ''
                }
            } },
            { visibe:false,class:"notanggota",data: "nrp" },
            { visibe:false,class:"notanggota",data: "name",render:function (data,type,row) {
                return row.name;
            } },
            { visibe:false,class:"notanggota",data: "keanggotaan" },
            
            // { render:function (data,type,row) {
            //     return datetostring2('yymmdd',row.tgl_pengajuan);
            // } },
            { render:function (data,type,row) {
                return datetostring2('yymmdd',row.tgl_approve);
            } },
            { render:function (data,type,row) {
                return formatRupiah(row.amount);
            } },
            { render:function (data,type,row) {
                if(row.tgl_awal){
                    return datetostring2('yymm',row.tgl_awal);
                }else{
                    return '';
                }
            } },
            { render:function (data,type,row) {
                if(row.durasi){
                    return row.durasi+' BULAN';
                }else{
                    return '';
                }
            } },
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
                .find(".bukti")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    $(".buktidiv").empty();
                    if(rowData.file){
                        file = rowData.file ;
                        file = baseURL+file.replaceAll('../public','');
                        content =`<center>
                                        <img src="`+file+`" style="width:300px;" alt="">
                                    <center>
                        `;
                        $(".buktidiv").append(content);
                        $("#modal-bukti").modal('show');
                    }else{
                        swalwarning('Anggota belum upload bukti transaksi');
                    }
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
                url: baseURL + "/approvalsukarela",
                type: "POST",
                data: JSON.stringify({ id: isObject.idsukarela, status: status }),
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

$("#add-btn-manual").on("click", function (e) {
    e.preventDefault();
    isObject = {};
    $("#form-simpananmanual").val("");
    $("#form-formbuktimanual").val("");
    loadUsers()
    $("#modal-data-manual").modal("show");
});

$("#add-btn").on("click", function (e) {
    e.preventDefault();
    isObject = {};
    $("#form-simpanan").val("");
    $("#form-bulan").val("");
    $("#form-durasi").val("");
    $("#modal-data").modal("show");
});

$("#ajukan-btn").on("click", function (e) {
    e.preventDefault();
   
    jumlah = $("#form-simpanan").val();
    if (jumlah.replaceAll('.','') < 50000){
        swalwarning('Minimal pengajuan Rp 50000');
        return false;
    }
    if ($("#form-bulan").val() == ''){
        swalwarning('Bulan Mulai harus diisi.');
        return false;
    }
    if ($("#form-durasi").val() < 1){
        swalwarning('Minimal 1 Bulan');
        return false;
    }

    ajukansukarela();
});

$("#ajukanmanual-btn").on("click", function (e) {
    e.preventDefault();
    jumlah = $("#form-simpananmanual").val();
    if(role == 'superadmin' || role == 'bendahara koperasi'){
        
        if ($("#form-anggota").val() == ''){
            swalwarning('Anggota tidak boleh kosong');
            return false;
        }
    }
    if (jumlah.replaceAll('.','') < 50000){
        swalwarning('Minimal pengajuan Rp 50000');
        return false;
    }
    if ($("#form-buktimanual").val() == ''){
        swalwarning('Bukti tidak boleh kosong');
        return false;
    }

    ajukansukarelamanual();
});

function ajukansukarela(){
    jumlah      = $("#form-simpanan").val() ;
    bulan       = $("#form-bulan").val() ;
    durasi      = $("#form-durasi").val() ;
    title = 'Simpan Rp.'+formatRupiah(jumlah)+' mulai dari '+bulan+' dengan durasi '+durasi+'X potongan gaji';
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
                url: baseURL + "/actionpengajuansukarela",
                type: "POST",
                data: JSON.stringify({ 
                    jumlah      : jumlah, 
                    bulan       : bulan, 
                    durasi      : durasi,
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

function ajukansukarelamanual() {
    const formData    = new FormData(document.getElementById("formbuktimanual"));
    formData.append('jumlah',$('#form-simpananmanual').val());
    formData.append('anggota',$('#form-anggota').val());

    $.ajax({
        url: baseURL + "/actionpengajuansukarelamanual",
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
                $("#modal-data-manual").modal("hide");
            } else {
                sweetAlert("Oops...", response.info, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
}

if(role == 'superadmin' || role == 'bendahara koperasi'){
    $(".divnabung").show();
}else{
    $(".divnabung").hide();
}
async function loadUsers() {
    try {
        const response = await $.ajax({
            url: baseURL + "/getUsersangggota",
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
            return {
                id: item.id,
                text: item.name,
            };
        });

        $("#form-anggota").select2({
            data: res,
            placeholder: "Pilih Anggota",
            dropdownParent: $("#modal-data-manual"),
        });
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}

