

let dtpr;

$(document).ready(function () {
    loadRole();
    getListData();
});

$(".select2").select2();
$(".select2add").select2({
    dropdownParent: $("#modal-data"),
});

$("#filter-btn").on('click',function(e){
    $('#table-list').dataTable().fnClearTable();
    $('#table-list').dataTable().fnDraw();
    $('#table-list').dataTable().fnDestroy();
    getListData();
    
});
let isObject = {};

function getListData() {

    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getAggotaList",
            type: "POST",
            dataType: "json",
            data    : {
                'status'        :$('#filter-status').val(),
                'keanggotaan'   :$('#filter-keanggotaan').val()
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
            { data: "no_anggota" },
            { data: "name" },
            { data: "pangkat" },
            { data: "nrp" },
            { render:function (data,type,row) {
                return datetostring2('yymmdd',row.tgl_dinas);
            } },
            { data: "handphone" },
            { data: "keanggotaan" },
            { data: "role_name" },
            { data: "status_name" },
            { 
                visible:false,mRender: function (data, type, row) {
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
    var action    = dtpr.columns(".action");
    if(role == 'sekertaris koperasi' || role == 'superadmin' ){
        action.visible(true);
    }
}

function editdata(rowData) {
    isObject = rowData;

    $("#form-noanggota").val(rowData.no_anggota);
    $("#form-name").val(rowData.name);
    $("#form-pangkat").val(rowData.pangkat);
    $("#form-nrp").val(rowData.nrp);
    $("#form-alamat").val(rowData.alamat);
    $("#form-handphone").val(rowData.handphone);
    $("#form-tgldinas").val(rowData.tgl_dinas);
    $("#form-status").val(rowData.status).trigger("change");
    $("#form-role").val(rowData.role_id).trigger("change");
    $("#form-limit").val(rowData.limit_pinjaman);
    $("#form-password").val();

    let $el = $("input:radio[name=form-status]");

    $el.filter("[value=" + rowData.is_active + "]").prop("checked", true);

    $("#modal-data").modal("show");
}

$("#add-btn").on("click", function (e) {
    e.preventDefault();

    isObject = {};
    isObject["id"] = null;
    isObject["idlimit"] = null;
    $("#form input").val("");
    $("#form textarea").val("");
    $("#form-role").val("").trigger("change");
    
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
            (isObject["limit_pinjaman"] = $("#form-limit").val()),
            "Limit Pinjaman tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["noanggota"] = $("#form-noanggota").val()),
            "No Anggota tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["name"] = $("#form-name").val()),
            "Name tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["pangkat"] = $("#form-pangkat").val()),
            "Pangkat tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["nrp"] = $("#form-nrp").val()),
            "NRP tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["alamat"] = $("#form-alamat").val()),
            "Alamat tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["handphone"] = $("#form-handphone").val()),
            "Handphone tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["tgldinas"] = $("#form-tgldinas").val()),
            "Tgl Dinas tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["status"] = $("#form-status").val()),
            "Status Anggota tidak boleh kosong"
        )
    )
        return false;
    // if (
    //     validationSwalFailed(
    //         (isObject["is_active"] = $el),
    //         "Please choose a status."
    //     )
    // )
    //     return false;
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
        title: "Yakin untuk INACTIVE ?",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Inactive !!",
        cancelButtonText: "Tidak, Batalkan !!",
        closeOnConfirm: !1,
        closeOnCancel: !1,
    }).then(function (e) {
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
                complete: function () {
                    $('#table-list').DataTable().ajax.reload();
                },
                success: function (response) {
                    // Handle response sukses
                    if (response.code == 0) {
                        swal("BERHASIL !", response.message, "success");
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
        complete: function () {
            $('#table-list').DataTable().ajax.reload();
            $("#modal-data").modal("hide");

        },
        success: function (response) {
            // Handle response sukses
            if (response.code == 0) {
                swal("Saved !", response.message, "success");
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