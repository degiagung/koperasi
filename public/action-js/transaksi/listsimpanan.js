

let dtpr;

$(document).ready(function () {
    calllistdata();
});

function calllistdata(){
    if(role == 'anggota'){
        // getListDataAnggota();
        getListData();
    }else{
        getListData();
    }
}

$(".select2").select2();
$(".select2add").select2({
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

function getListData() {

    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getSimpanan",
            type: "POST",
            dataType: "json",
            data    : {
                'keanggotaan'   :$('#filter-keanggotaan').val(),
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
            { text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'List Simpanan Periode transaksi('+$('#filter-tahun').val()+''+$('#filter-bulan').val()+')_date'+datenow(new Date), exportOptions: {columns:[':not(.notdown)']}},
        ],
        columns: [
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { visible:false,class:"notanggota",data: "nrp" },
            { visible:false,class:"notanggota",data: "name",render:function (data,type,row) {
                return "<a class='detail' style='cursor:pointer;'>"+row.name+"</a>";
            } },
            { render:function (data,type,row) {
                return datetostring2('yymmdd',row.tgl_dinas);
            } },
            {  visible:false,data: "keanggotaan" },
            { render:function (data,type,row) {
                return "<a class='smpokok' style='cursor:pointer;'>"+formatRupiah(row.simpananpokok)+"</a>";
            } },
            { render:function (data,type,row) {
                return "<a class='smwajib' style='cursor:pointer;'>"+formatRupiah(row.simpananwajib)+"</a>";
            } },
            { render:function (data,type,row) {
                return "<a class='smsukarela' style='cursor:pointer;'>"+formatRupiah(row.sukarela)+"</a>";
            } },
            { render:function (data,type,row) {
                return 'Rp. ' +formatRupiah(row.total);
            } },
            { render:function (data,type,row) {
                return 'Rp. ' +formatRupiah(row.penarikan);
            } },
            { render:function (data,type,row) {
                return 'Rp. ' +formatRupiah(row.saldo);
            } },
        ],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: "current" }).nodes();
            var last = null;

            $(rows)
                .find(".detail")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    detail(rowData);
                });
            $(rows)
                .find(".smpokok")
                .on("click", function () {
                    isObject = {};
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    isObject = rowData;
                    buktipokok(rowData.user);
                });
            $(rows)
                .find(".smwajib")
                .on("click", function () {
                    isObject = {};
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    isObject = rowData;
                    isObject['jenis'] = 'wajib';
                    getlistbukti(rowData);
                });
            $(rows)
                .find(".smsukarela")
                .on("click", function () {
                    isObject = {};
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    isObject = rowData;
                    detailsukarela();
                });
        },
    });
    var action      = dtpr.columns(".action");
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
    $("#form-smwajib").val(formatRupiah(rowData.simpananpokok));
    $("#form-smpokok").val(formatRupiah(rowData.simpananwajib));
    $("#form-smsukarela").val(formatRupiah(rowData.sukarela));
    $("#form-tarik").val(formatRupiah(rowData.penarikan));
    $("#form-tgltarik").val(rowData.tgl_penarikan);
    $("#form-saldo").val(formatRupiah(rowData.saldo));


    $("#modal-data").modal("show");
}
async function buktipokok(id) {
    $(".buktidiv").empty();
    $(".notapokok").show();
    try {
        const response = await $.ajax({
            url: baseURL + "/getbuktipokok",
            type: "POST",
            dataType: "json",
            data:{
                id  : id ,
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
            $(".notapokok").show();
        }else{
            $(".notapokok").hide();
            // if (role == 'bendahara koperasi' || role == 'superadmin') {
            if (role == 'anggota') {
                $("#form-bukti").val('');
                $("#modal-upload").modal('show');
                isObject['jenis'] = 'pokok';
            }

            // if (role == 'anggota'){
            if (role != 'anggota'){
                content =`<center>
                            Bukti Belum diupload
                        <center>
            `;
                $(".buktidiv").append(content);
                $("#modal-bukti").modal('show');
            }
        }
        
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}

async function getlistbukti(rowData) {
    $(".notapokok").hide();
    los  = rowData.los;
     $("#detailbukti").empty();
    try {
        const response = await $.ajax({
            url: baseURL + "/getbuktisimpanan",
            type: "POST",
            dataType: "json",
            data:{
                id : rowData.user
            },
            beforeSend: function () {
                
            },
        });

        content = '';
        for (let i = 0; i < los; i++) {
            no = i+1 ;
            file = '';
            // if (role == 'bendahara koperasi' || role == 'superadmin') {
            if (role == 'anggota') {
                jenis= 'Upload Bukti';
            }else{
                jenis= 'Belum Upload';
            }
            content += `
                <tr>
                    <td>`+datesimpanan(rowData.tgl_dinas,no)+`</td>
                    <td>`+no+`</td>
                    <td>Rp. 50.000.00</td>
            `;
            for (let j = 0; j < response.data.length; j++) {
                if(no == response.data[j]['tenor']){
                    file = response.data[j]['file'];
                    jenis= 'Lihat Bukti';
                }
            }
            var threeMonthsAgo = moment(rowData.tgl_dinas, "YYYY-MM-DD").add(no, 'months');
            var mm2     = threeMonthsAgo.format('MM');
            var yyyy2   = threeMonthsAgo.format('YYYY');
            tgl = yyyy2+''+mm2+'01' ;
            content += `
                <td style="text-align:center;"><a onclick="bukti('`+file+`',`+no+`)" style="cursor:pointer;color:red;">`+jenis+`</a></td>
                <td style="text-align:center;"><a onclick="showbill('`+no+`','`+rowData.name+`','`+rowData.nrp+`','`+tgl+`  ','50000','SIMPANAN WAJIB','SM')" style="cursor:pointer;color:red;">Nota</a></td>
            `;
            content += `</tr>`;   
        }
        
        $("#detailbukti").append(content);
        $(".totalbukti").html("Rp."+formatRupiah(rowData.simpananwajib));
        $("#modal-detail").modal('show');
        
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}

function showbill(id,name,nrp,tgl,rp,jenis,kode) {
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
                        &ensp;&ensp;&ensp;<img src="`+baseURL+`/template/admin/images/ttd.jpg" style="width:100px" alt="">
                        <br>BENDAHARA PRIMKOPAU
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
        // if (role == 'bendahara koperasi' || role == 'superadmin') {
        if (role == 'anggota') {
            $("#form-bukti").val('');
            $("#modal-upload").modal('show');
            isObject['nobukti'] = no ;

        }
    }   
}

$("#simpanbukti-btn").on("click", function (e) {
    e.preventDefault();

    if ($("#form-bukti").val() == ''){
        swalwarning('Bukti tidak boleh kosong');
        return false;
    }

    if (isObject['jenis'] == 'pokok') {
        isObject['nobukti'] = '';
    }
    simpanbukti(isObject['jenis']);
});

function simpanbukti(jenis) {
    const formData    = new FormData(document.getElementById("formbukti"));
    formData.append('id',isObject.user);
    formData.append('no',isObject.nobukti);
    formData.append('jenis',jenis);

    $.ajax({
        url: baseURL + "/saveBuktiSimpanan",
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
                $(".modal-upload").modal("hide");
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

function detailsukarela() {
    $('#table-detail-sukarela').dataTable().fnClearTable();
    $('#table-detail-sukarela').dataTable().fnDraw();
    $('#table-detail-sukarela').dataTable().fnDestroy();
    $("#modal-detail-sukarela").modal('show');
    tblskrl = $("#table-detail-sukarela").DataTable({
        ajax: {
            url: baseURL + "/getdetailsimpanan",
            type: "POST",
            dataType: "json",
            data    : {
                'id'   :isObject.user,
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
                    $('#table-detail-sukarela').DataTable().ajax.reload();
                }
            },
            { text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'Detail Simpanan Periode transaksi('+$('#filter-tahun').val()+''+$('#filter-bulan').val()+')_date'+datenow(new Date), exportOptions: {columns:[':not(.notdown)']}},
        ],
        columns: [
            {
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
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
            { render:function (data,type,row) {
                return "<a class='detail' style='cursor:pointer;'>Rp."+formatRupiah(row.amount)+"</a>";
            } },
            { render:function (data,type,row) {
                if(row.tgl_approve)
                    return datetostring2('yymmdd',row.tgl_approve);
                else
                    return '';
            } },
            { render:function (data,type,row) {
                if(row.tgl_awal1)
                    return datetostring2('yymmdd',row.tgl_awal1);
                else
                    return '';
            } },
            
            { render:function (data,type,row) {
                if(row.durasi)
                    return row.durasi;
                else
                    return '';
            } },
             { sClass:"notdown",render:function (data,type,row) {
                return `<a class="nota" style="cursor:pointer;">Nota</a>`;
            } },

        ],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: "current" }).nodes();
            var last = null;

            $(rows)
                .find(".detail")
                .on("click", function () {
                    isObject = {};
                    var tr = $(this).closest("tr");
                    var rowData = tblskrl.row(tr).data();
                    isObject = rowData;
                    isObject['user'] = rowData.user_id;
                    
                    if(rowData.jenis == 'manual'){
                        buktisimpananmanual();
                    }else{
                        getlistbuktipotonggaji();
                        isObject['jenis'] = 'potong gaji';

                    }
                });
            $(rows)
                .find(".nota")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = tblskrl.row(tr).data();
                    showbill(rowData.id,rowData.name,rowData.nrp,rowData.tgl_approve,rowData.amount,'SIMPANAN SUKARELA','SMS');
                });
        },
    });

}

async function buktisimpananmanual() {
    $(".buktidiv").empty();
    try {
        const response = await $.ajax({
            url: baseURL + "/getbuktimanual",
            type: "POST",
            dataType: "json",
            data:{
                userid  : isObject['user_id'] ,
                id      : isObject['id_bukti'] ,
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
            swalwarning('tidak ditemukan');
        }
        
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}
async function getlistbuktipotonggaji() {
    durasi  = isObject['durasi2'];
    jumlah  = isObject['amount'];
    total   = formatRupiah(durasi*jumlah);
     $("#detailbukti").empty();
    try {
        const response = await $.ajax({
            url: baseURL + "/getlistbuktipotonggaji",
            type: "POST",
            dataType: "json",
            data:{
                id : isObject['user_id']
            },
            beforeSend: function () {
                
            },
        });
        
        content = '';
        for (let i = 0; i < durasi; i++) {
            no = i+1 ;
            file = '';
            // if (role == 'bendahara koperasi' || role == 'superadmin') {
            if (role == 'anggota') {
                jenis= 'Upload Bukti';
            }else{
                jenis= 'Belum Upload';
            }
            console.log(isObject);
            content += `
                <tr>
                    <td>`+datesimpanan(isObject['tgl_awal'],no)+`</td>
                    <td>`+no+`</td>
                    <td>Rp.`+formatRupiah(jumlah/isObject['durasi'])+`</td>
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
        $(".totalbukti").html("Rp."+total);
        $("#modal-detail").modal('show');
        
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}

