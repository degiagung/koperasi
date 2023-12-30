let dtpr;

$(document).ready(function () {
    
    if(role == 'pemilik' || role == 'superadmin'){
        $(".divutkpmilik").show();
    }
    loadfasilitas('kos','fasilitas');
    loadfasilitas('penghuni','fasilitas-penghuni');
    loadtipe();
    loadpenghuni();
    getListData();
    
});
$('.select2').select2();

var dateToday = new Date();

$('.daterange-time').daterangepicker({
    timePicker: false,
    applyClass: 'bg-slate-600',
    cancelClass: 'btn-clear_daterange',
    locale: {
        format: 'YYYY-MM-DD',
        cancelLabel: 'Clear'
    },
    maxDate: dateToday,
});

$("#filter-btn").on('click',function(e){
    	
    getListData()
    
})

function getListData() {
    filterstatus    = $("#filter-status").val() ;
    filterkondisi   = $("#filter-kondisi").val() ;
    $('#table-list').dataTable().fnClearTable();
    $('#table-list').dataTable().fnDraw();
    $('#table-list').dataTable().fnDestroy();
    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getListKamar",
            type: "POST",
            data: {
                status   : filterstatus,
                kondisi  : filterkondisi,
            },
            dataType: "json",
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
            { text: ' ', extend: 'pdfHtml5',  className: 'btndownload iconpdf',  title:'List kamar', exportOptions: {columns:[':not(.notdown)']}},
            { text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'List kamar', exportOptions: {columns:[':not(.notdown)']}},
        ],
        columns: [
            {
                data: "id",sClass:"tdnumber",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { data: "no_kamar",sClass:"td100",
                render: function (data, type, row, meta) {
                    return 'Kamar '+row.no_kamar;
                }, 
            },
            { data: "lantai",sClass:"td100",
                render: function (data, type, row, meta) {
                    return 'Lantai '+row.lantai;
                },
            },
            { data: "faskos",mRender: function (data, type, row) {
                if(row.faskosp){
                    return row.faskos+','+row.faskosp;
                }else{
                    return row.faskos;
                }
            } },
            { data: "status_kamar",sClass:"td100",
                mRender: function (data, type, row) {
                    if(row.status_kamar == 'Kosong'){
                        return `<a style="color:green;font-weight:bold;">`+row.status_kamar+`</a>`;
                    }else if(row.status_kamar == 'Booking'){
                        return `<a style="color:#c5c527;font-weight:bold;">`+row.status_kamar+`</a>`; 
                    }else{
                        return `<a style="color:red;font-weight:bold;">`+row.status_kamar+`</a>`;
                    }
                }
            },
            { data: "durasi",sClass:"td200",
                mRender: function (data, type, row) {
                    if(row.name){
                        return window.datetostring2('yymmdd',row.tgl_awal) +'<br><b> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;SD </b><br>'+window.datetostring2('yymmdd',row.tgl_akhir);
                    }else{
                        return '';
                    }
                }
            },
            { data: "sisa_durasi",
                mRender: function (data, type, row) {
                    if(row.name){
                        if(row.sisa_durasi < 0)
                        return `<a style="color:red;font-weight:bold;"> Telat `+row.sisa_durasi * -1+` hari</a>`
                        else if(row.sisa_durasi == 0)
                        return `<a style="color:#e1e155;">Hari Terakhir</a>`;
                        else
                        return `<a style="color:green;">`+row.sisa_durasi+` hari</a>`
                    }else{
                        return '';
                    }
                }
            },
            { data: "name" },
            { data: "k.status",
                mRender: function (data, type, row) {
                    if(row.idperbaikan)
                    return '<a style="color:red;font-weight:bold;">perbaikan</a>'
                    else
                    return '<a style="color:green;font-weight:bold;">baik</a>'
                }
            },
            { 
                mRender: function (data, type, row) {
                    // if(role == 'superadmin'){
                        var $rowData = `<button type="button" class="btn btn-primary btn-icon-sm mx-2 edit-btn"><i class="bi bi-pencil-square"></i></button>`;
                        $rowData += `<button type="button" class="btn btn-danger btn-icon-sm delete-btn"><i class="bi bi-x-square"></i></button>`;
                        return $rowData;
                    // }
                },
                className: "text-center notdown"},
        ],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: "current" }).nodes();
            var last = null;

            $(rows)
                .find(".edit-btn")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    editdata(rowData);
                });
            $(rows)
                .find(".delete-btn")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    deleteData(rowData);
                });
        },
        
    }
    );


}

let isObject = {};

function editdata(rowData) {
    isObject = {};
    isObject = rowData;
    isObject['tipe'] = 'update';
    if(rowData.status_kamar == 'Booking'){
        editbooking(rowData);
    }else{

        fotokamar(rowData.id)
        loadfasilitas('kos','fasilitas-perbaikan',rowData.id);
        $(".perbaikan").show();
        $('#formkamar select').val('').trigger('change');
        $('#formkamar input').val('');
        $("#form-no").val(rowData.no_kamar);
        $("#form-lantai").val(rowData.lantai);
        $("#form-tipe").val(rowData.tipe).trigger('change');;
        $("#form-harga").val(rowData.harga);
        $("#form-penghuni").val(rowData.user_id).trigger('change');
        $("#form-durasi").val(rowData.tgl_awal);
        $("#form-bln").val(getMonthDifference(new Date(rowData.tgl_awal), new Date(rowData.tgl_akhir)));
       
        const idfaskos=rowData.idfaskos;
        const idfaskosp=rowData.idfaskosp;
        const idperbaikan=rowData.idperbaikan;
        const faskos = [];
        const faskosp = [];
        const fasper = [];
        if(idfaskos){
            $.each(idfaskos.split(","), function(i,e){
                faskos.push(e);    
            });
            $("#form-fasilitas").val(faskos).trigger('change');
        }
        if(idfaskosp){
            $.each(idfaskosp.split(","), function(i,e){
                faskosp.push(e);
            });
            $("#form-fasilitas-penghuni").val(faskosp).trigger('change')
        }
        // console.log(idperbaikan)
        setTimeout(() => {
            if(idperbaikan){
                $.each(idperbaikan.split(","), function(i,e){
                    fasper.push(e);
                });
                $("#form-fasilitas-perbaikan").val(fasper).trigger('change')
            }
        }, 2000);
        $("#modal-data").modal("show");
    }


}

function editbooking(data) {
  
    swal({
        title: "Apakah Yakin Untuk Menyetujui ?",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Setujui",
        cancelButtonText: "Kembali",
        closeOnConfirm: !1,
        closeOnCancel: !1,
    }).then(function (e) {
        if (e.value) {
            $.ajax({
                url: baseURL + "/setujuibooking",
                type: "POST",
                data: JSON.stringify({ id: data.user_id }),
                dataType: "json",
                contentType: "application/json",
                beforeSend: function () {
                    Swal.fire({
                        title: "Loading",
                        text: "Mohon Tunggu...",
                    });
                },
                complete: function () {
                    $('#table-list').DataTable().ajax.reload();
                },
                success: function (response) {
                    // Handle response sukses
                    if (response.code == 0) {
                        swal("Berhasil !", response.message, "success");
                    } else {
                        sweetAlert("Oops...", response.message, "ERROR");
                    }
                },
                error: function (xhr, status, error) {
                    sweetAlert("Oops...", "ERROR", "ERROR");
                },
            });
        } else {
            swal(
                "Batal",
                "Data tidak berubah",
                "ERROR"
            );
        }
    });
}

function fotokamar(id){
    $(".fotokamar").empty();
    $.ajax({
    type: 'POST',
    dataType: 'json',
    url: baseURL + '/getfotokamar',
    data: {
        id    : id,

    }, success: function(result){
        $(".fotokamar").show();
        var content = '';
        $.each(result.data, function(i,e){
            file = baseURL+e['alamat'].replaceAll('../public','')+e['file'];
            if(e['jenis'] == 'sampul'){
                content +=`<div class="col-sm-3">
                <label>Foto Sampul</label>
                <img src="`+file+`" style="width:100px;height:50px;" alt="">
                </div>
                `;
            }else{
                content += `
                    <div class="col-sm-3">
                        <label>Foto Lainnya</label>
                        <img src="`+file+`" style="width:100px;height:50px;" alt="">
                    </div>
                    `
                
            }
        });
        $(".fotokamar").append(content);
    }
    });
}

$("#add-btn").on("click", function (e) {
    $(".fotokamar").hide();
    $(".perbaikan").hide();
    e.preventDefault();

    $('#formkamar input').val('');
    $('#formkamar select').val('').trigger('change');

    isObject = {};
    isObject["id"] = null;
    isObject["tipe"] = '';
    $("#modal-data").modal("show");
});

$("#form-penghuni").change(function (e) {
    if($("#form-penghuni").val()){
        $(".durasi").show();
    }else{
        $(".durasi").hide();
    }
});

$("#save-btn").on("click", function (e) {
    e.preventDefault();
    checkValidation();

});

function checkValidation() {

    if (
        validationSwalFailed(
            ($("#form-no").val()),
            "No Kamar tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            ($("#form-lantai").val()),
            "Lantai tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            ($("#form-tipekamar").val()),
            "Tipe Kamar tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            ($("#form-harga").val()),
            "Harga Kamar tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            ($("#form-fasilitas").val()),
            "fasilitas dari kos tidak boleh kosong"
        )
    )
        return false;
    if(isObject['tipe'] == ''){
        if (
            validationSwalFailed(
                ($("#form-sampul").val()),
                "Foto Sampul Kamar tidak boleh kosong"
            )
        )
            return false;
    }
        
    if($("#form-penghuni").val()){
        if (
            validationSwalFailed(
                ($("#form-durasi").val()),
                "Tanggal Kos tidak boleh kosong"
            )
        )
            return false;
            
    let jmlbulan    = $("#form-bln").val() ; 
    if(jmlbulan <= 0){
            swalwarning('Jumlah Bulan minimal 1 bulan');
            return false ;
        }
    }
    
    saveData();
}

function deleteData(data) {
    const formData    = new FormData();
    isObject = {};
    formData.append('tipe','deleted');
    formData.append('id',data.id);
    swal({
        title: "Apakah Yakin untuk mendelete ?",
        text: "Data tidak dapat di kembalikan",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Delete !!",
        cancelButtonText: "Tidak,Batalkan !!",
        closeOnConfirm: !1,
        closeOnCancel: !1,
    }).then(function (e) {
        if (e.value) {
            $.ajax({
                url: baseURL + "/actionKamar",
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
                        swal("Berhasil Delete !", '', "success");
                    } else {
                        sweetAlert("Oops...", response.info, "ERROR");
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
                "Cancelled !!",
                "Hey, your imaginary file is safe !!",
                "ERROR"
            );
        }
    });
}

function saveData() {
    const formData    = new FormData(document.getElementById("formfilelainnya"));
    formData.append('tipe',isObject['tipe']);
    formData.append('id',isObject['id']);
    formData.append('noold',isObject['no_kamar']);
    formData.append('no',$('#form-no').val());
    formData.append('lantai',$('#form-lantai').val());
    formData.append('tipekamar',$('#form-tipekamar').val());
    formData.append('harga',$('#form-harga').val());
    formData.append('fasilitas',$('#form-fasilitas').val());
    formData.append('fasilitaspenghuni',$('#form-fasilitas-penghuni').val());
    formData.append('fasilitasperbaikan',$('#form-fasilitas-perbaikan').val());
    formData.append('penghuni',$('#form-penghuni').val());
    formData.append('durasi',$('#form-durasi').val());
    formData.append('jmlbulan',$('#form-bln').val());

    $.ajax({
        url: baseURL + "/actionKamar",
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
        success: function (response) {
            // Handle response sukses
            if (response.code == 0) {
                savesampul(response.data);
            } else {
                sweetAlert("Oops...", response.info, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
}

function savesampul(idkamar) {
    const formData    = new FormData(document.getElementById("formsample"));
    formData.append('idkamar',idkamar);

    $.ajax({
        url: baseURL + "/saveFileSampul",
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
            $("#modal-data").modal("hide");
            $('#table-list').DataTable().ajax.reload();
        },
        success: function (response) {
            // Handle response sukses
            if (response.code == 0) {
                swal("Berhasil !", 'Data Kamar telah di perbaharui', "success");
            } else {
                sweetAlert("Oops...", response.info, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
}

async function loadpenghuni() {
    $("#form-penghuni").empty();
    try {
        const response = await $.ajax({
            url: baseURL + "/getPenghuni",
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                // Swal.fire({
                //     title: "Loading",
                //     text: "Please wait...",
                // });
            },
        });

        const res = response.data ;
        let content = '<option value="">Pilih Penghuni</option>';
        for (let i = 0; i < res.length; i++) {
            const user_id = res[i]['id'];
            const penghuni = res[i]['name'];

            content += `
                <option value="`+user_id+`">`+penghuni+`</option>
            `;
        }
        $("#form-penghuni").append(content);
        $("#form-penghuni").select2({
            dropdownParent: $("#modal-data"),
        });
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}

async function loadtipe() {
    try {
        const response = await $.ajax({
            url: baseURL + "/getTipeKamar",
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
                text: item.tipe,
            };
        });

        $("#form-tipekamar").select2({
            data: res,
            placeholder: "Please choose an option",
            dropdownParent: $("#modal-data"),
        });
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}

async function loadfasilitas(jenis,id,kamar) {
    try {
        $("#form-"+id).empty();
        const response = await $.ajax({
            url: baseURL + "/getFasilitas",
            type: "POST",
            dataType: "json",
            data:{
                jenis : jenis,
                kamar:kamar
            }
        });

        const res = response.data ;
        let content = '';
        for (let i = 0; i < res.length; i++) {
            const id = res[i]['id'];
            const fasilitas = res[i]['fasilitas'];

            content += `
                <option value="`+id+`">`+fasilitas+`</option>
            `;
        }
        $("#form-"+id).append(content);
        $("#form-"+id).select2({
            dropdownParent: $("#modal-data"),
        });
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}