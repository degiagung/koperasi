

let dtpr;

$(document).ready(function () {
    loadRole();
    getListData();
});



function getListData() {
    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getPenghuniList",
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
            { text: ' ', extend: 'pdfHtml5',  className: 'btndownload iconpdf',  title:'List User', exportOptions: {columns:[':not(.notdown)']}},
            { text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'List User', exportOptions: {columns:[':not(.notdown)']}},
        ],
        columns: [
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { data: "name" },
            { data: "email" },
            { data: "handphone" },
            { 
                mRender: function (data, type, row) {
                    var $rowData = `<button type="button" class="btn btn-primary btn-icon-sm mx-2 edit-btn"><i class="bi bi-pencil-square"></i></button>`;
                    $rowData += `<button type="button" class="btn btn-danger btn-icon-sm delete-btn"><i class="bi bi-x-square"></i></button>`;
                    return $rowData;
                },
                className: "text-center notdown action",
            },
        ],
        columnDefs: [
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

    $("#form-email").val(rowData.email);
    $("#form-password").val();
    $("#form-name").val(rowData.name);
    $("#form-role").val(rowData.role_id).trigger("change");

    let $el = $("input:radio[name=form-status]");

    $el.filter("[value=" + rowData.is_active + "]").prop("checked", true);

    $("#modal-data").modal("show");
}

$("#add-btn").on("click", function (e) {
    e.preventDefault();

    isObject = {};
    isObject["id"] = null;
    $("#form-email").val("");
    $("#form-password").val("");
    $("#form-name").val("");
    $("#form-role").val("").trigger("change");
    $("input:radio[name=form-status]").prop("checked", false);
    $("#modal-data").modal("show");
});

$("#save-btn").on("click", function (e) {
    e.preventDefault();
    checkValidation();
});


function checkValidation() {
    let $el = $("input:radio[name=form-status]:checked").val();
    // console.log($el);
    if (
        validationSwalFailed(
            (isObject["name"] = $("#form-name").val()),
            "Name field cannot be empty."
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["email"] = $("#form-email").val()),
            "Email field cannot be empty."
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["is_active"] = $el),
            "Please choose a status."
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["role_id"] = $("#form-role").val()),
            "Please choose a role."
        )
    )
        return false;
    isObject["password"] = $("#form-password").val();
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
                url: baseURL + "/deleteUser",
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
    
    $.ajax({
        url: baseURL + "/saveUser",
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
                sweetAlert("Oops...", response.message, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            // Handle error response
            // console.log("ERROR");
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
}

async function loadRole() {
    try {
        const response = await $.ajax({
            url: baseURL + "/getRole",
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
                text: item.role_name,
            };
        });

        $("#form-role").select2({
            data: res,
            placeholder: "Please choose an option",
            dropdownParent: $("#modal-data"),
        });
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}