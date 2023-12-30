
$.extend($.fn.dataTable.defaults, {
    autoWidth: false,
    columnDefs: [
      {
        orderable: false,
        width: "100px",
        targets: [5],
      },
    ],
    dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
    language: {
        search      : '_INPUT_',
        lengthMenu  : '_MENU_',
        paginate    : { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
    },
    buttons: [
        { 
            className: 'btnreload',
            text: '<i class="icon-reload-alt" ></li>',
            action: function ( e, dt, node, config ) {     
                getListData();
            }
        },
    ],
    drawCallback: function () {
      $(this)
        .find("tbody tr")
        .slice(-3)
        .find(".dropdown, .btn-group")
        .addClass("dropup");
    },
    preDrawCallback: function () {
      $(this)
        .find("tbody tr")
        .slice(-3)
        .find(".dropdown, .btn-group")
        .removeClass("dropup");
    },
});

$('.select2').select2();
$("#form-pembayaran").select2({
    dropdownParent: $("#modal-update"),
});

$("#form-pembayaran").on('change',function(){
    if($("#form-pembayaran").val() == '1'){
        $(".divbln").hide();
    }else{
        $(".divbln").show();
    }
});

$("#filter-btn").on('click',function(e){
    	
    getListData()
    
})

getListData();
function getListData() {
    filtersisa = $("#filter-sisa").val() ;
    filterstatus = $("#filter-status").val() ;
    $('#table-list').dataTable().fnClearTable();
    $('#table-list').dataTable().fnDraw();
    $('#table-list').dataTable().fnDestroy();
    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/listKamarDashboard",
            type: "POST",
            data: {
                sisawaktu   : filtersisa,
                status   : filterstatus,
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
            {sClass:"td100",
                render: function (data, type, row, meta) {
                if(row.faskosp){
                    return row.faskos+','+row.faskosp;
                }else{
                    return row.faskos;
                }
                }, 
            },
            { data: "status_kamar",sClass:"td100",
                mRender: function (data, type, row) {
                    if(row.status_kamar == 'Kosong'){
                        return `<a style="color:green;font-weight:bold;">`+row.status_kamar+`</a>`;
                    }else{
                        return `<a style="color:red;font-weight:bold;">`+row.status_kamar+`</a>`;

                    }
                }
            },
            { data: "durasi",sClass:"td150 masakos",
                mRender: function (data, type, row) {
                    return window.datetostring2('yymmdd',row.tgl_awal) +'<br><b> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;SD </b><br>'+window.datetostring2('yymmdd',row.tgl_akhir);
                }
            },
            { data: "sisa_durasi",
                mRender: function (data, type, row) {

                    if(row.sisa_durasi < 0)
                    return `<a style="color:red;font-weight:bold;"> Telat `+row.sisa_durasi * -1+` hari</a>`
                    else if(row.sisa_durasi == 0)
                    return `<a style="color:#e1e155;">Hari Terakhir</a>`;
                    else
                    return `<a style="color:green;">`+row.sisa_durasi+` hari</a>`
                }
            },
            { data: "name" },
            { mRender: function (data, type, row) {
                return getMonthDifference(
                    new Date(row.tgl_awal), new Date(row.tgl_akhir)
                    ) + ' Bulan';
                }
            },
            { mRender: function (data, type, row) {
                rp = row.biaya * getMonthDifference(
                     new Date(row.tgl_awal), new Date(row.tgl_akhir)
                     ) ;
                return 'Rp. '+formatRupiah(String(rp)) ;
                    }
            },
            { mRender: function (data, type, row) {
                if(row.status_transaksi == null)
                    return `<a style="cursor:pointer;color:#fff;background: red;" class="showbilln" > Belum Bayar</a>`
                    else
                    return `<a style="cursor:pointer;color:#fff;background: green;" class="showbill" > Sudah Bayar</a>`
                }
            },
            { 
                mRender: function (data, type, row) {
                    
                    if(row.status_transaksi == null)
                    return  `<button type="button" class="btn btn-primary btn-icon-sm mx-2 edit-btn"><i class="bi bi-pencil-square"></i></button>`;
                    else
                    return  `<button type="button" class="btn btn-primary btn-icon-sm mx-2 showbill"><i class="bi bi-pencil-square"></i></button>`;
                // return $rowData;
                    
            },
                className: "text-center notdown action",visible:false},
                
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
                    if(rowData.status_transaksi != null){
                        swalsuccess('Sudah Melakukan Pembayaran')
                        return false;
                    }
                    editdata(rowData);
                });
            $(rows)
                .find(".showbill")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    showbill(rowData);
                });
            $(rows)
                .find(".showbilln")
                .on("click", function () {
                    swalwarning('Penghuni Belum Bayar');
                });
        },
    });

    var action     = dtpr.columns(".action");
    if(role == 'superadmin'){
        action.visible(true)  ;
    }
    else{
        action.visible(false)  ;
    }
}

function showbill(params) {
    var masasewa = datetostring2('yymmdd',params.tgltransaksi1)+` - `+datetostring2('yymmdd',params.tgltransaksi2) ;
    jmlbulan = params.blntransaksi + ' Bulan' ;
    
    $(".btndownloadsert").removeAttr("onclick");
    $(".btndownloadsert").attr("onclick","generatePDF('"+params.nametransaksi+"','"+masasewa+"')");

    $("#divbill").empty();
    $("#divbill").append(`
        <center>
            <table class="bill" id="tablebill">
                <tr style="border-bottom: 3px solid black;">
                    <th>Jika kunci hilang/tertinggal, langsung dikenakan biaya ganti silinder kunci baru seharga Rp. 100.000</th>
                </tr>
                <tr>
                    <th>
                        <div class="row">
                            <div class="col-sm-6">
                                Sudah terima dari : <b class="bold">`+params.nametransaksi+`</b> <br>
                                Uang sejumlah : <b class="bold">`+pembilang(params.totaltransaksi)+`</b> <br>
                                Untuk pembayaran sewa kamar No : <b class="bold">`+params.kamartransaksi+`</b> <br>
                                Masa sewa dari : <b class="bold">`+masasewa+`</b> <br>
                                Ukuran Kamar : <b class="bold">`+params.tipetransaksi+`</b> <br>
                            </div>
                            <div class="col-sm-6" style="font-size: 8px;">
                                <div style="padding-left:50px;">
                                    Puteri <br>
                                    `+params.hptranaksi+` <br>
                                    <div class="col-sm-12" style="border: 3px solid black;">
                                        - mohon info jika ada perubahan no hp <br>
                                        - mohon disimpan baik-baik
                                    </div>
                                    <br>
                                    <b class="bold">Biaya Kamar Rp.`+formatRupiah(params.biayatransaksi) +` X `+jmlbulan+`</b><br>
                                    <b class="bold">Fasilitas Tambahan Rp. `+formatRupiah(params.biayatambahtransaksi)+` X `+jmlbulan+`</b><br>
                                </div>
                            </div>
                        </div>
                    </th>
                    <tr>
                        <th>
                            <div class="row">
                                <div class="col-sm-3" style="padding-top:10px">
                                    <b class="bold">Rp. `+formatRupiah(params.totaltransaksi)+`</b><br>
                                    Lunas Transfer BBCA
                                </div>
                                <div class="col-sm-5" style="border: 3px solid black;font-size:12px;text-align:center;"><b class="bold">
                                    MAHFUDZ (081220117988)<br>
                                    BCA 063 123 7460<br>
                                    Mandiri 13200 2442 7867
                                </b>
                                </div>
                                <div class="col-sm-4">
                                    Bandung, `+datetostring2('yymmdd',params.tgltransaksi)+`<br>
                                    &ensp;&ensp;&ensp;<img src="`+baseURL+`/template/admin/images/ttd.jpg" style="width:100px" alt="">

                                </div>
                            </div>
                        </th>
                    </tr>
                </tr>
                <tr style="border-top: 3px solid black;">
                    <th>Penjaga kos tidak memegang kunci cadangan, mohon kunci jangan sampai tertinggal/hilang</th>
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

var dataedit = '';
function editdata(p){
    dataedit = '';
    dataedit = p;
    $("#form-status").select2({
        dropdownParent: $(".modal"),
    });
    $("#btn-update").removeAttr("onclick");
    $("#btn-update").attr("onclick","savebukti()");

    $("#modal-update").modal('show');
}

function savebukti() {
    let jmlbulan    = $("#form-bln").val() ; 
    let jenispembayaran = $("#form-pembayaran").val();
    if($("#form-bukti").val() == ''){
        swalwarning('Bukti tidak boleh kosong');
        return false ;
    }
    if(jenispembayaran != '1'){
        if(jmlbulan <= 0){
            swalwarning('Jumlah Bulan minimal 1 bulan');
            return false ;
        }
    }
    const formData    = new FormData(document.getElementById("formbukti"));
    formData.append('idkamar',dataedit.id);
    formData.append('user_id',dataedit.user_id);
    formData.append('name',dataedit.name);
    formData.append('handphone',dataedit.handphone);
    formData.append('no_kamar',dataedit.no_kamar);
    formData.append('faskos',dataedit.faskos);
    formData.append('faskosp',dataedit.faskosp);
    formData.append('tgl_awal',dataedit.tgl_awal);
    formData.append('tipe_kamar',dataedit.tipe);
    formData.append('harga',dataedit.harga);
    formData.append('biayatambah',dataedit.biayatambah);
    formData.append('jmlbulan',jmlbulan);
    formData.append('biaya',dataedit.biaya * jmlbulan);
    formData.append('jenispembayaran',jenispembayaran);

    $.ajax({
        url: baseURL + "/saveBukti",
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
            $("#modal-update").modal("hide");
            $('#table-list').DataTable().ajax.reload();
        },
        success: function (response) {
            // Handle response sukses
            if (response.code == 0) {
                swal("Berhasil !", 'Bukti Berhasil disimpan', "success");
            } else {
                sweetAlert("Oops...", response.info, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
}