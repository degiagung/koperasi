

let dtpr;

$(document).ready(function () {
    getListData();
    // $('.select2').select2();
    $(".select2").select2({
        dropdownParent: $(".modal"),
    });
});


function getListData() {
    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getListFasilitas",
            type: "POST",
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
            { text: ' ', extend: 'pdfHtml5',  className: 'btndownload iconpdf',  title:'List Fasilitas', exportOptions: {columns:[':not(.notdown)']}},
            { text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'List Fasilitas', exportOptions: {columns:[':not(.notdown)']}},
        ],
        columns: [
            {
                data: "id",sClass:"tdnumber",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { data: "fasilitas" },
            { data: "penyedia" },
            { sClass:"td150",
                mRender: function (data, type, row) {
                    return formatRupiah(row.biaya);
                },
                visible: true,
                targets: 5,
                className: "text-center"},
            { sClass:"td100",
                mRender: function (data, type, row) {
                    var $rowData = `<button type="button" class="btn btn-primary btn-icon-sm mx-2 edit-btn"><i class="bi bi-pencil-square"></i></button>`;
                    $rowData += `<button type="button" class="btn btn-danger btn-icon-sm delete-btn"><i class="bi bi-x-square"></i></button>`;
                    return $rowData;
                },
                className: "text-center notdown action"},
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
    });
}

let isObject = {};

function editdata(rowData) {
    isObject = {};
    isObject = rowData;

    $("#form-fasilitas").val(rowData.fasilitas);
    $("#form-biaya").val(rowData.biaya);
    $('#form-penyedia').val(rowData.penyedia).trigger("change");

    $("#modal-data").modal("show");
}

$("#add-btn").on("click", function (e) {
    e.preventDefault();

    isObject = {};
    isObject["id"] = null;
    $("#form-fasilitas").val("");
    $("#form-biaya").val("0");
    $("#modal-data").modal("show");
});

$("#save-btn").on("click", function (e) {
    e.preventDefault();
    checkValidation();
});

function checkValidation() {
    if (
        validationSwalFailed(
            (isObject["name"] = $("#form-fasilitas").val()),
            "Fasilitas tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["penyedia"] = $("#form-penyedia").val()),
            "Penyedia tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["biaya"] = $("#form-biaya").val()),
            "Biaya minimal 0"
        )
    )
        return false;
    
    saveData();
}

function deleteData(data) {
    isObject = {};
    isObject["tipe"]    = 'deleted';
    isObject["id"]      = data.id;
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
        console.log(e);
        if (e.value) {
            $.ajax({
                url: baseURL + "/actionFasilitas",
                type: "POST",
                data: JSON.stringify(isObject),
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
                        swal("Berhasil Delete !", response.message, "success");
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
                "Cancelled !!",
                "Hey, your imaginary file is safe !!",
                "ERROR"
            );
        }
    });
}

function saveData() {
    isObject["tipe"] = '';
    $.ajax({
        url: baseURL + "/actionFasilitas",
        type: "POST",
        data: JSON.stringify(isObject),
        dataType: "json",
        contentType: "application/json",
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
                swal("Berhasil !", response.message, "success");
            } else {
                sweetAlert("Oops...", response.message, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
}