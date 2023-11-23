

let dtpr;

$(document).ready(function () {
    loadSatuan()
    getListData();
});



function getListData() {
    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getObatList",
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
        language: {
            oPaginate: {
                sFirst: "First",
                sLast: "Last",
                sNext: ">",
                sPrevious: "<",
            },
        },
        columns: [
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { data: "nama_obat" },
            { data: "nama_satuan" },
            { data: "harga_jual" },
            { data: "harga_beli" },
            { data: "min_stok" },
            { data: "id" },
        ],
        columnDefs: [
           
            {
                mRender: function (data, type, row) {
                    var $rowData = `<button type="button" class="btn btn-primary btn-icon-sm mx-2 edit-btn"><i class="bi bi-pencil-square"></i></button>`;
                    $rowData += `<button type="button" class="btn btn-danger btn-icon-sm delete-btn"><i class="bi bi-x-square"></i></button>`;
                    return $rowData;
                },
                visible: true,
                targets: 6,
                className: "text-center",
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
    isObject = rowData;

    $("#form-harga-jual").val(rowData.harga_jual);
    $("#form-harga-beli").val(rowData.harga_beli);
    $("#form-stok-minimum").val(rowData.min_stok);
    $("#form-name").val(rowData.nama_obat);
    $("#form-satuan").val(rowData.id_satuan).trigger("change");

    $("#modal-data").modal("show");
}

$("#add-btn").on("click", function (e) {
    e.preventDefault();

    isObject = {};
    isObject["id"] = null;
    $("#form-harga-jual").val("");
    $("#form-harga-beli").val("");
    $("#form-name").val("");
    $("#form-stok-minimum").val("");
    $("#form-satuan").val("").trigger("change");

    $("#modal-data").modal("show");
});

$("#save-btn").on("click", function (e) {
    e.preventDefault();
    checkValidation();
});


function checkValidation() {
   
    // console.log($el);
    if (
        validationSwalFailed(
            (isObject["nama_obat"] = $("#form-name").val()),
            "Name field cannot be empty."
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["id_satuan"] = $("#form-satuan").val()),
            "Please choose a satuan."
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["harga_beli"] = $("#form-harga-beli").val()),
            "Harga Beli field cannot be empty."
        )
    )
        return false;
 
    if (
        validationSwalFailed(
            (isObject["harga_jual"] = $("#form-harga-jual").val()),
            "Harga Jual field cannot be empty."
        )
    )
        return false;
    isObject["min_stok"] = $("#form-stok-minimum").val()
  
    saveData();
}



function deleteData(data) {
  
    swal({
        title: "Are you sure to delete ?",
        text: "You will not be able to recover this imaginary file !!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it !!",
        cancelButtonText: "No, cancel it !!",
        closeOnConfirm: !1,
        closeOnCancel: !1,
    }).then(function (e) {
        console.log(e);
        if (e.value) {
            $.ajax({
                url: baseURL + "/deleteGlobal",
                type: "POST",
                data: JSON.stringify({ id: data.id, tableName:"obat" }),
                dataType: "json",
                contentType: "application/json",
                beforeSend: function () {
                    Swal.fire({
                        title: "Loading",
                        text: "Please wait...",
                    });
                },
                complete: function () {},
                success: function (response) {
                    // Handle response sukses
                    if (response.code == 0) {
                        swal("Deleted !", response.message, "success").then(
                            function () {
                                location.reload();
                            }
                        );
                    } else {
                        sweetAlert("Oops...", response.message, "error");
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    // console.log(xhr.responseText);
                    sweetAlert("Oops...", xhr.responseText, "error");
                },
            });
        } else {
            swal(
                "Cancelled !!",
                "Hey, your imaginary file is safe !!",
                "error"
            );
        }
    });
}

function saveData() {
    
    $.ajax({
        url: baseURL + "/saveObat",
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
        complete: function () {},
        success: function (response) {
            // Handle response sukses
            if (response.code == 0) {
                swal("Saved !", response.message, "success").then(function () {
                    location.reload();
                });
                // Reset form
            } else {
                sweetAlert("Oops...", response.message, "error");
            }
        },
        error: function (xhr, status, error) {
            // Handle error response
            // console.log(xhr.responseText);
            sweetAlert("Oops...", xhr.responseText, "error");
        },
    });
}

async function loadSatuan() {
    try {
        const response = await $.ajax({
            url: baseURL + "/getSatuanList",
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
                text: item.nama_satuan,
            };
        });

        $("#form-satuan").select2({
            data: res,
            placeholder: "Please choose an option",
            dropdownParent: $("#modal-data"),
        });
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "error");
    }
}