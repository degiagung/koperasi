
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

$("#filter-btn").on('click',function(e){
    	
    getListData()
    
})

getListData();
function getListData() {
    filtersisa = $("#filter-sisa").val() ;
    $('#table-list').dataTable().fnClearTable();
    $('#table-list').dataTable().fnDraw();
    $('#table-list').dataTable().fnDestroy();
    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/listTransaksi",
            type: "POST",
            data: {
                sisawaktu   : filtersisa,
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
            { data: "name" },
            { data: "handphone" },
            { data: "no_kamar",sClass:"td100",
                render: function (data, type, row, meta) {
                    return 'Kamar '+row.no_kamar;
                }, 
            },
            {sClass:"td100",
                render: function (data, type, row, meta) {
                return row.fasilitas;
                }, 
            },
            {sClass:"td100",
                render: function (data, type, row, meta) {
                return row.fasilitas_penghuni;
                }, 
            },
            { data: "durasi",sClass:"td150",
                mRender: function (data, type, row) {
                    return window.datetostring2('yymmdd',row.tgl_awal) +'<br><b> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;SD </b><br>'+window.datetostring2('yymmdd',row.tgl_akhir);
                }
            },
            { mRender: function (data, type, row) {
                return datetostring2('yymmdd His nyatu',row.created_at)
            }
            },
            { mRender: function (data, type, row) {
                return `<a style="cursor:pointer;color:red;" class="showbill" >Klik Disini</a>`
            }
            },
            { mRender: function (data, type, row) {
                $rowData = `<button type="button" class="btn btn-danger btn-icon-sm delete-btn"><i class="bi bi-x-square"></i></button>`;
                return $rowData;
            }
            },
            
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
                        return false ;
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
            $(rows)
                .find(".delete-btn")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    deleteData(rowData);
                });
        },
    });
}

function showbill(params) {
    var masasewa = datetostring2('yymmdd',params.tgl_awal)+` - `+datetostring2('yymmdd',params.tgl_akhir) ;
    jmlbulan = params.jml_bulan +' Bulan';
    biaya = params.total_biaya;
    
    $(".btndownloadsert").removeAttr("onclick");
    $(".btndownloadsert").attr("onclick","generatePDF('"+params.name+"','"+masasewa+"')");

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
                                Sudah terima dari : <b class="bold">`+params.name+`</b> <br>
                                Uang sejumlah : <b class="bold">`+pembilang(biaya)+`</b> <br>
                                Untuk pembayaran sewa kamar No : <b class="bold">`+params.no_kamar+`</b> <br>
                                Masa sewa dari : <b class="bold">`+masasewa+`</b> <br>
                                Ukuran Kamar : <b class="bold">`+params.tipe+`</b> <br>
                            </div>
                            <div class="col-sm-6" style="font-size: 8px;">
                                <div style="padding-left:50px;">
                                    Puteri <br>
                                    `+params.handphone+` <br>
                                    <div class="col-sm-12" style="border: 3px solid black;">
                                        - mohon info jika ada perubahan no hp <br>
                                        - mohon disimpan baik-baik
                                    </div>
                                    <br>
                                    <b class="bold">Biaya Kamar Rp.`+formatRupiah(params.biaya_kamar) +` X `+jmlbulan+`</b><br>
                                    <b class="bold">Fasilitas Tambahan Rp. `+formatRupiah(params.biaya_tambahan)+` X `+jmlbulan+`</b><br>
                                </div>
                            </div>
                        </div>
                    </th>
                    <tr>
                        <th>
                            <div class="row">
                                <div class="col-sm-3" style="padding-top:10px">
                                    <b class="bold">Rp. `+formatRupiah(biaya)+`</b><br>
                                    Lunas Transfer BBCA
                                </div>
                                <div class="col-sm-5" style="border: 3px solid black;font-size:12px;text-align:center;"><b class="bold">
                                    MAHFUDZ (081220117988)<br>
                                    BCA 063 123 7460<br>
                                    Mandiri 13200 2442 7867
                                </b>
                                </div>
                                <div class="col-sm-4">
                                    Bandung, `+datetostring2('yymmdd',params.created_at)+`<br>
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
    const formData    = new FormData(document.getElementById("formbukti"));
    formData.append('idkamar',dataedit.id);
    formData.append('user_id',dataedit.user_id);
    formData.append('name',dataedit.name);
    formData.append('handphone',dataedit.handphone);
    formData.append('no_kamar',dataedit.no_kamar);
    formData.append('faskos',dataedit.faskos);
    formData.append('faskosp',dataedit.faskosp);
    formData.append('tgl_awal',dataedit.tgl_awal);
    formData.append('tgl_akhir',dataedit.tgl_akhir);
    formData.append('harga',dataedit.harga);
    formData.append('biayatambah',dataedit.biayatambah);
    formData.append('biaya',dataedit.biaya * getMonthDifference(
    new Date(dataedit.tgl_awal), new Date(dataedit.tgl_akhir)));

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

function deleteData(data) {
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
                url: baseURL + "/deleteTransaksi",
                type: "POST",
                data: JSON.stringify({ id: data.id }),
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
                "Dibatalkan !!",
                "File Tidak di Delete ",
                "ERROR"
            );
        }
    });
}