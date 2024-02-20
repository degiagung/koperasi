

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
            { sClass:"notdwon",render:function (data,type,row) {
                return `<a class="bukti" style="cursor:pointer;">Klik Disini</a>`;
            } },
            { sClass:"notdwon",render:function (data,type,row) {
                return `<a class="nota" style="cursor:pointer;">Klik Disini</a>`;
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
            $(rows)
                .find(".nota")
                .on("click", function () {
                    isObject = {};
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    
                    showbill(rowData);
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

function showbill(params) {
    
    $(".btndownloadsert").removeAttr("onclick");
    $(".btndownloadsert").attr("onclick","generatePDF('Penarikan Simpanan "+params.name+"','"+datetostring2('yymmdd',params.tgl_approve)+"')");

    $("#divbill").empty();

    p2   		= params.tgl_approve.toString().replaceAll('-','');
    yyyy 		= p2.substring(0,4);
    mm 			= p2.substring(4,6);
    dd 			= p2.substring(6,8);
    date        = yyyy+''+mm+''+dd;
    $("#divbill").append(`
        <center>
            <table class="bill" id="tablebill" style="width:500px;">
                <tr style="border-bottom: 3px solid black;text-align: center;">
                    <th>
                        <h3>PENARIKAN SIMPANAN</h3>
                        <h6>PS`+params.idpenarikan+date+`</h6>
                    </th>
                </tr>
                <tr>
                    <th>
                        <div class="row">
                            <div class="col-sm-6">
                                NRP
                            </div>
                            <div class="col-sm-6">
                                : `+params.nrp+`<br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                NAMA
                            </div>
                            <div class="col-sm-6">
                                : `+params.name+`<br>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                JUMLAH
                            </div>
                            <div class="col-sm-6">
                                : `+formatRupiah(params.jml_pengajuan)+`<br>
                            </div>
                        </div>
                    </th>
                    
                </tr>
                <tr style="border-bottom: 3px solid black;text-align: end;">
                    <th>
                    <br>
                    <br>
                        Bandung, `+datetostring2('yymmdd',params.tgl_approve)+`<br>
                        &ensp;&ensp;&ensp;<img src="`+baseURL+`/template/admin/images/ttd.jpg" style="width:100px" alt="">

                    </th>
                </tr>
            </table>
        </center>
    `);
    $("#modal-bill").modal('show');
}

function generatePDF(p1,p2){   
    
    // var testDivElement = document.getElementById('sertifikat');
    var imgData;
    html2canvas($("#tablebill"), {
        useCORS: true,
        onrendered: function (canvas) {
            imgData = canvas.toDataURL('image/png');
            // var doc = new jsPDF();
            var doc = new jsPDF('landscape', 'mm', 'a4');
            doc.addImage(imgData, 'PNG', 15, 40, 150, 60);
            // doc.addImage(imgData, 'PNG', 15, 40, 180, 160);
            doc.save(p1+'_'+p2.replaceAll(' ','')+'.pdf');
            // window.open(imgData);
        }
    });

    // $("#myModal").modal('hide');
    
};

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