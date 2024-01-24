

let dtpr;

$(document).ready(function () {
    calllistdata();
});

function calllistdata(){
    if(role == 'anggota'){
        getListDataAnggota();
    }else{
        getListData();
    }
}
$(".select2").select2();
$(".select2add").select2({
    dropdownParent: $("#modal-data"),
    dropdownParent: $("#modal-payment"),
});

$("#filter-btn").on('click',function(e){
    $('#table-list').dataTable().fnClearTable();
    $('#table-list').dataTable().fnDraw();
    $('#table-list').dataTable().fnDestroy();
    calllistdata()
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
            { text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'List Pinjaman', exportOptions: {columns:[':not(.notdown)']}},
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
                    return "<a class='updatestatus' style='font-weight:bold;color:green;cursor:pointer;'>LUNAS</a>";
                 else
                    return "<a class='updatestatus' style='font-weight:bold;color:red;cursor:pointer;'>BELUM LUNAS</a>";
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
                // return row.tenor +' BLN & Rp.'+formatRupiah(row.pinjaman)+ '<b>X2%/BLN</b> = Rp.' +formatRupiah(row.pinjaman2persen);
                return row.tenor +' BLN & Rp.'+formatRupiah(row.pinjaman)+ '<b>X2%</b> = Rp.' +formatRupiah(row.pinjamanbunga);
    
            } },
            { render:function (data,type,row) {
                if(row.status_pinjaman == 'lunas')
                    return (row.totaltenor+row.sisatenor)+' BLN X Rp.'+formatRupiah(row.totalbayarperbulan1)+' = Rp.' +formatRupiah(row.pinjamanbunga);
                else
                    // return row.totaltenor+' BLN X Rp.'+formatRupiah(row.totalbayarperbulan)+' = Rp.' +formatRupiah(row.totalbayar);
                    return row.totaltenor+' BLN X Rp.'+formatRupiah(row.totalbayarperbulan1)+' = Rp.' +formatRupiah(row.totalbayar1);
        
            } },
            { render:function (data,type,row) {
                if(row.status_pinjaman == 'lunas')
                return 'Rp. ' +formatRupiah(row.limitpinjaman)
                else
                return 'Rp. ' +formatRupiah(row.sisalimit);
            } },
            { render:function (data,type,row) {
                if(row.status_pinjaman == 'lunas')
                    return "<a class='updatestatus' style='font-weight:bold;color:green;cursor:pointer;'>LUNAS</a>";
                else
                    if (row.sisapinjaman > 0)
                    return row.sisatenor+' BLN & Rp.' +formatRupiah(row.sisapinjaman1);
                    else
                    return row.sisatenor+' BLN & Rp.0';
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

function getListDataAnggota() {

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
                    $('#table-list-pinjam').DataTable().ajax.reload();
                }
            },
            { text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'List Pinjaman', exportOptions: {columns:[':not(.notdown)']}},
        ],
        columns: [
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { render:function (data,type,row) {
                // return row.sisatenor+' '+row.totaltenor+' '+row.status_pinjaman ;
                if(row.sisatenor == row.totaltenor || row.status_pinjaman == 'lunas')
                    return "<a class='updatestatus' style='font-weight:bold;color:green;cursor:pointer;'>LUNAS</a>";
                 else
                    return "<a class='updatestatus' style='font-weight:bold;color:red;cursor:pointer;'>BELUM LUNAS</a>";
            } },
            
            { render:function (data,type,row) {
                return datetostring2('yymmdd',row.tglapprove);
            } },
            { render:function (data,type,row) {
                return datetostring2('yymmdd',row.tglbayar);
            } },
            { render:function (data,type,row) {
                // return formatRupiah(row.pinjamanbunga) ;
                return formatRupiah(row.totalbayarperbulan1) ;
            } },
            { render:function (data,type,row) {
                return row.tenor;
            } },
            { render:function (data,type,row) {
                return row.totaltenor;
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

            $(rows)
                .find(".bukti")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    $(".buktidiv").empty();
                    isObject    = {};
                    isObject    = rowData ;
                    getlistbukti(rowData)
                    
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
        
    if(rowData.status_pinjaman == 'lunas'){
        sisatenor = 'LUNAS' ;
    }
    else{
        if (rowData.sisapinjaman > 0){
            sisatenor = rowData.sisatenor+' BLN & ' +formatRupiah(rowData.sisapinjaman);
        }
    }
    console.log(rowData);
    $("#form-nrp").val(rowData.nrp);
    $("#form-name").val(rowData.name);
    $("#form-keanggotaan").val(rowData.keanggotaan);
    $("#form-tgldinas").val(datetostring2('yymmdd',rowData.tgl_dinas));
    $("#form-limit").val(formatRupiah(rowData.limitpinjaman));
    $("#form-totallimit").val(sisalimit);
    $("#form-pinjaman").val(pengajuan);
    $("#form-sisatenor").val(sisatenor);
    $("#form-tgltarik").val(datetostring2('yymmdd',rowData.tglaju));
    $("#form-tglbayar").val(datetostring2('yymmdd',rowData.tglbayar));


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

async function getlistbukti(rowData) {
    jumlah = formatRupiah(rowData.totalbayarperbulan1);
    tenor  = rowData.tenor;
     $("#detailbukti").empty();
    try {
        const response = await $.ajax({
            url: baseURL + "/getbuktipinjaman",
            type: "POST",
            dataType: "json",
            data:{
                id : rowData.idpinjam
            },
            beforeSend: function () {
                
            },
        });

        content = '';
        for (let i = 0; i < rowData.totaltenor; i++) {
            no = i+1 ;
            file = '';
            jenis= 'Upload Bukti';
            content += `
                <tr>
                    <td>`+tenor+`</td>
                    <td>`+jumlah+`</td>
                    <td>`+no+`</td>
            `;
            for (let j = 0; j < response.data.length; j++) {
                if(no == response.data[j]['tenor']){
                    file = response.data[j]['file'];
                    jenis= 'Lihat Bukti';
                }
            }
            content += `
                <td style="text-align:center;"><a onclick="bukti('`+file+`',`+no+`)" style="cursor:pointer;color:red;">`+jenis+`</a></td>
            `;
            content += `</tr>`;   
        }
        
        $("#detailbukti").append(content);
        $("#modal-detail").modal('show');
        
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}

function bukti(file,no) {
    if(file){
        $(".buktidiv").empty();
        file = file ;
        file = baseURL+file.replaceAll('../public','');
        content =`<center>
                        <img src="`+file+`" style="width:300px;" alt="">
                    <center>
        `;
        $(".buktidiv").append(content);
        $("#modal-bukti").modal('show');
    }else{
        $("#modal-upload").modal('show');
        isObject['nobukti'] = no ;
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
    formData.append('no',isObject.nobukti);

    $.ajax({
        url: baseURL + "/saveBuktipinjam",
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
