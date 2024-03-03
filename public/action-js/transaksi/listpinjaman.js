

let dtpr;

$(document).ready(function () {
    calllistdata();

    if(role == 'superadmin' || role == 'bendahara koperasi'){
        $(".btnkirimnota").show();
    }else{
        $(".btnkirimnota").hide();
    }
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
    if($("#filter-tahun").val() == '' && $("#filter-bulan").val()){
        swalwarning('filter tahun harus diisi');
        return false ;
    };
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
                'statuspinjam'  :$('#filter-status').val(),
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
            { text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'List Pinjaman Periode transaksi('+$('#filter-tahun').val()+''+$('#filter-bulan').val()+')_date'+datenow(new Date), exportOptions: {columns:[':not(.notdown)']}},
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
            { render:function (data,type,row) {
                return datetostring2('yymmdd',row.tglapprove);
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
                return row.tenor +' BLN';
    
            } },
            { render:function (data,type,row) {
                // return row.tenor +' BLN & Rp.'+formatRupiah(row.pinjaman)+ '<b>X2%/BLN</b> = Rp.' +formatRupiah(row.pinjaman2persen);
                return 'Rp.'+formatRupiah(row.pinjaman);
    
            } },
            { render:function (data,type,row) {
                // return row.tenor +' BLN & Rp.'+formatRupiah(row.pinjaman)+ '<b>X2%/BLN</b> = Rp.' +formatRupiah(row.pinjaman2persen);
                return 'Rp.' +formatRupiah(row.pinjamanbunga);
    
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
            { sClass:"notdown",render:function (data,type,row) {
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
                        $("#sisatagihan").val(formatRupiah(rowData.sisapinjaman1));
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

function getListDataAnggota() {

    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getPinjaman",
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
            { text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'List Pinjaman Periode transaksi('+$('#filter-tahun').val()+''+$('#filter-bulan').val()+')_date'+datenow(new Date), exportOptions: {columns:[':not(.notdown)']}},
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
                    
                    isObject = {};
                    isObject = rowData ;
                    if(rowData.status_pinjaman == 'lunas'){
                        buktilunas();
                    }else{
                        if (role == 'bendahara koperasi' || role == 'superadmin') {
                            $("#sisatagihan").val('Rp.'+formatRupiah(rowData.sisapinjaman1));
                            $("#modal-payment").modal('show');
                        }
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

                    // if(rowData.status_pinjaman == 'lunas'){
                    //     buktilunas();
                    // }else{
                        getlistbukti(rowData)
                    // }
                    
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
    if ($("#form-bukti-kwitansi").val() == ''){
        swalwarning('Kwitansi tidak boleh kosong');
        return false;
    }
    const formData    = new FormData(document.getElementById("formbuktikwitansi"));
    formData.append('id',isObject.idpinjam);
    formData.append('userid',isObject.user);
    swal({
        title: "Yakin untuk update LUNAS pinjaman ?",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, update ",
        cancelButtonText: "Tidak, Batalkan !!",
        closeOnConfirm: !1,
        closeOnCancel: !1,
    }).then(function (e) {
        if (e.value) {
            $.ajax({
                url: baseURL + "/lunasipinjaman",
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

function getlistbukti(rowData){
    jumlah          = formatRupiah(rowData.totalbayarperbulan1);
    sisapinjaman1   = formatRupiah(rowData.sisapinjaman1);
    tenor           = rowData.tenor;
    $("#detailbukti").empty();
   $.ajax({
        url: baseURL + "/getbuktipinjaman",
        type: "POST",
        dataType: "json",
        data:{
            id      : rowData.idpinjam,
            bukti   : rowData.idbukti
        },
        beforeSend: function () {
            // Swal.fire({
            //     title: "Loading",
            //     text: "Please wait...",
            // });
        },
        complete: function () {
        },
        success: function (response) {
            // Handle response sukses
            if (response.code == 0) {
                content = '';
                for (let i = 0; i < rowData.totaltenor; i++) {
                    no = i+1 ;
                    file = '';
                    if (role == 'anggota') {
                        jenis= 'Upload Bukti';
                    }else{
                        jenis= 'Belum Upload';
                    }
                    content += `
                        <tr>
                            <td>`+jumlah+`</td>
                            <td>`+no+`</td>
                    `;
                    idtrans = '';
                    ketbil  = '';
                    terkirim= '';
                    varnota = '';
                    var threeMonthsAgo = moment(rowData.tglapprove, "YYYY-MM-DD").add(no, 'months');
                    var mm2     = threeMonthsAgo.format('MM');
                    var yyyy2   = threeMonthsAgo.format('YYYY');
                    tgl = yyyy2+''+mm2+'01' ;
                    for (let j = 0; j < response.data.length; j++) {
                        if(no == response.data[j]['tenor'] && response.data[j]['lunas'] == null){
                            file = response.data[j]['file'];
                            jenis= 'Lihat Bukti';
                            idtrans = response.data[j]['id'];
                            if(response.data[j]['nota'] == 'terkirim'){
                                varnota = `
                                    <td style="text-align:center;"><a onclick="showbill('`+no+`','`+rowData.name+`','`+rowData.nrp+`','`+tgl+`  ','50000','PINJAMAN','PJ','`+idtrans+`')" style="cursor:pointer;color:red;">Nota</a></td>
                                `;
                                terkirim = `
                                    
                                    <td style="text-align:center;"><a style="color:green;">TERKIRIM</a></td>
                                
                                `;
                            }
                        }
                    }
                    
                    
                    if(role == 'anggota'){
                        content += `
                            <td style="text-align:center;"><a onclick="bukti('`+file+`',`+no+`)" style="cursor:pointer;color:red;">`+jenis+`</a></td>
    
                        `+varnota;
                    }else{
                        content += `
                            <td style="text-align:center;"><a onclick="bukti('`+file+`',`+no+`)" style="cursor:pointer;color:red;">`+jenis+`</a></td>
                            <td style="text-align:center;"><a onclick="showbill('`+no+`','`+rowData.name+`','`+rowData.nrp+`','`+tgl+`  ','50000','PINJAMAN','PJ','`+idtrans+`')" style="cursor:pointer;color:red;">Nota</a></td>
                        `+terkirim;
                    }
                    
                    content += `</tr>`;  
                }

                file = '';
                if (rowData.status_pinjaman == 'lunas'){
                    content += `
                        <tr>
                            <td>`+sisapinjaman1+`</td>
                            <td>PELUNASAN</td>
                    `;
                    for (let k = 0; k < response.data.length; k++) {
                        if(response.data[k]['lunas'] == 'lunas'){
                            file = response.data[k]['file'];
                        }
                    }
                    content += `
                        <td style="text-align:center;"><a onclick="bukti('`+file+`','')" style="cursor:pointer;color:red;">Lihat Bukti</a></td>
                    `;
                    content += `</tr>`;
                }
                
                $("#detailbukti").append(content);
                $("#modal-detail").modal('show');
            } else {
                sweetAlert("Oops...", response.info, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
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
        if (role != 'anggota') {
            return false ;
        }
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

async function buktilunas() {

    $(".buktidiv").empty();
    try {
        const response = await $.ajax({
            url: baseURL + "/buktilunas",
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
            if (role == 'bendahara koperasi' || role == 'superadmin') {
                $("#form-bukti").val('');
                $("#modal-upload").modal('show');
            }
        }
        
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}

var idtransjakarta = '';
function showbill(id,name,nrp,tgl,rp,jenis,kode,idtrans) {
    idtransjakarta = idtrans ;
    if(id == 'pokok'){
        jenis   = 'SIMPANAN POKOK';
        name    = isObject.name;
        nrp     = isObject.nrp;
        var threeMonthsAgo = moment(isObject.tgl_dinas, "YYYY-MM-DD").add(1, 'months');
        var mm2     = threeMonthsAgo.format('MM');
        var yyyy2   = threeMonthsAgo.format('YYYY');
        tgl         = yyyy2+''+mm2+'01' ;
        rp          = 50000;
        kode        = 'SM';
        id          = '01' ;
    }
    $(".btndownloadsert").removeAttr("onclick");
    $(".btndownloadsert").attr("onclick","generatePDF('"+jenis+" "+name+"','"+tgl+"')");

    $("#divbill").empty();

    p2   		= tgl.toString().replaceAll('-','');
    yyyy 		= p2.substring(0,4);
    mm 			= p2.substring(4,6);
    dd 			= p2.substring(6,8);
    date        = yyyy+''+mm+''+dd;

    $("#divbill").append(`
        <center>
            <table class="bill" id="tablebill" style="width:500px;">
                <tr style="border-bottom: 3px solid black;text-align: center;">
                    <th>
                        <h3>`+jenis+`</h3>
                        <h6>`+kode+id+""+date+`</h6>
                    </th>
                </tr>
                <tr>
                    <th>
                        <div class="row">
                            <div class="col-sm-6">
                                NRP
                            </div>
                            <div class="col-sm-6">
                                : `+nrp+`<br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                NAMA
                            </div>
                            <div class="col-sm-6">
                                : `+name+`<br>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                JUMLAH
                            </div>
                            <div class="col-sm-6">
                                : `+formatRupiah(rp)+`<br>
                            </div>
                        </div>
                    </th>
                    
                </tr>
                <tr style="border-bottom: 3px solid black;text-align: end;">
                    <th>
                    <br>
                    <br>
                        Bandung, `+datetostring2('yymmdd',tgl)+`<br>
                        &ensp;&ensp;&ensp;<img src="`+baseURL+`/template/admin/images/ttd.jpg" style="width:100px" alt=""><br>
                        BENDAHARA PRIMKOPAU

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

function kirimnota(){
   
    const formData    = new FormData(document.getElementById("formbuktikwitansi"));
    formData.append('id',isObject.idtransjakarta);
    swal({
        title: "Yakin untuk kirim nota ke anggota ?",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Kirim ",
        cancelButtonText: "Tidak, Batalkan !!",
        closeOnConfirm: !1,
        closeOnCancel: !1,
    }).then(function (e) {
        if (e.value) {
            $.ajax({
                url: baseURL + "/kirimnota",
                type: "POST",
                dataType: "json",
                data:{
                    id      : idtransjakarta,
                },
                beforeSend: function () {
                    Swal.fire({
                        title: "Loading",
                        text: "Please wait...",
                    });
                },
                complete: function () {
                },
                success: function (response) {
                    // Handle response sukses
                    if (response.code == 0) {
                        swal("BERHASIL !", response.message, "success");
                        $("#modal-bill").modal('hide');
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

function getlistbukti(rowData){
    jumlah          = formatRupiah(rowData.totalbayarperbulan1);
    sisapinjaman1   = formatRupiah(rowData.sisapinjaman1);
    tenor           = rowData.tenor;
    $("#detailbukti").empty();
   $.ajax({
        url: baseURL + "/getbuktipinjaman",
        type: "POST",
        dataType: "json",
        data:{
            id      : rowData.idpinjam,
            bukti   : rowData.idbukti
        },
        beforeSend: function () {
            // Swal.fire({
            //     title: "Loading",
            //     text: "Please wait...",
            // });
        },
        complete: function () {
        },
        success: function (response) {
            // Handle response sukses
            if (response.code == 0) {
                content = '';
                for (let i = 0; i < rowData.totaltenor; i++) {
                    no = i+1 ;
                    file = '';
                    if (role == 'anggota') {
                        jenis= 'Upload Bukti';
                    }else{
                        jenis= 'Belum Upload';
                    }
                    content += `
                        <tr>
                            <td>`+jumlah+`</td>
                            <td>`+no+`</td>
                    `;
                    idtrans = '';
                    ketbil  = '';
                    terkirim= '';
                    varnota = '';
                    var threeMonthsAgo = moment(rowData.tglapprove, "YYYY-MM-DD").add(no, 'months');
                    var mm2     = threeMonthsAgo.format('MM');
                    var yyyy2   = threeMonthsAgo.format('YYYY');
                    tgl = yyyy2+''+mm2+'01' ;
                    for (let j = 0; j < response.data.length; j++) {
                        if(no == response.data[j]['tenor'] && response.data[j]['lunas'] == null){
                            file = response.data[j]['file'];
                            jenis= 'Lihat Bukti';
                            idtrans = response.data[j]['id'];
                            if(response.data[j]['nota'] == 'terkirim'){
                                varnota = `
                                    <td style="text-align:center;"><a onclick="showbill('`+no+`','`+rowData.name+`','`+rowData.nrp+`','`+tgl+`  ','50000','PINJAMAN','PJ','`+idtrans+`')" style="cursor:pointer;color:red;">Nota</a></td>
                                `;
                                terkirim = `
                                    
                                    <td style="text-align:center;"><a style="color:green;">TERKIRIM</a></td>
                                
                                `;
                            }
                        }
                    }
                    
                    
                    if(role == 'anggota'){
                        content += `
                            <td style="text-align:center;"><a onclick="bukti('`+file+`',`+no+`)" style="cursor:pointer;color:red;">`+jenis+`</a></td>
    
                        `+varnota;
                    }else{
                        content += `
                            <td style="text-align:center;"><a onclick="bukti('`+file+`',`+no+`)" style="cursor:pointer;color:red;">`+jenis+`</a></td>
                            <td style="text-align:center;"><a onclick="showbill('`+no+`','`+rowData.name+`','`+rowData.nrp+`','`+tgl+`  ','50000','PINJAMAN','PJ','`+idtrans+`')" style="cursor:pointer;color:red;">Nota</a></td>
                        `+terkirim;
                    }
                    
                    content += `</tr>`;   
                }

                file = '';
                if (rowData.status_pinjaman == 'lunas'){
                    content += `
                        <tr>
                            <td>`+sisapinjaman1+`</td>
                            <td>PELUNASAN</td>
                    `;
                    for (let k = 0; k < response.data.length; k++) {
                        if(response.data[k]['lunas'] == 'lunas'){
                            file = response.data[k]['file'];
                        }
                    }
                    content += `
                        <td style="text-align:center;"><a onclick="bukti('`+file+`','')" style="cursor:pointer;color:red;">Lihat Bukti</a></td>
                    `;
                    content += `</tr>`;
                }
                
                $("#detailbukti").append(content);
                $("#modal-detail").modal('show');
            } else {
                sweetAlert("Oops...", response.info, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
}