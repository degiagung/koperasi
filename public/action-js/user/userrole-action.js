let dtview;
let dtjson;

getListView();

$(".permission-btn").on("click", function (e) {
    e.preventDefault();
    if (dtview) {
        dtview.ajax.reload();
    } else {
        getListView();
    }
});

$(".jsondata-btn").on("click", function (e) {
    e.preventDefault();
    if (dtjson) {
        dtjson.ajax.reload();
    } else {
        getListJson();
    }
});

function getListView() {
    dtview = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getAccessRole",
            type: "POST",
            data: {
                param_type: "VIEW",
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
            
            { text: '', extend: 'pdfHtml5',  className: 'btndownload iconpdf',  title:'List Akses', exportOptions: {columns:[':not(.notdown)']}},
            { text: '', extend: 'excel',  className: 'btndownload iconexcel',  title:'List Akses', exportOptions: {columns:[':not(.notdown)']}},
            { 
                className: 'btnreload',
                text: '<i class="bi bi-arrow-clockwise" ></li>',
                action: function ( e, dt, node, config ) {     
                    $('#table-list').DataTable().ajax.reload();
                }
            },
        ],
        columns: [
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { data: "header_menu" },
            { data: "menu_name" },
            { data: "url" },
            { data: "id" },
        ],
        columnDefs: [
            // {
            //     mRender: function (data, type, row) {
            //         // var $rowData = '<button class="btn btn-sm btn-icon isEdit i_update"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit font-medium-2 text-info"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>';
            //         // $rowData += `<button class="btn btn-sm btn-icon delete-record i_delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash font-medium-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>`;
            //         $rowData = ` <span class="badge badge-danger">Inactive</span>`;
            //         if (row.is_active == 1) {
            //             $rowData = `<span class="badge badge-success">Active</span>`;
            //         }
            //         return $rowData;
            //     },
            //     visible: true,
            //     targets: 4,
            //     className: "text-center",
            // },
            {
                mRender: function (data, type, row) {
                    var $rowData = `<button type="button" class="btn btn-primary btn-icon-sm permission-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-lock" viewBox="0 0 16 16">
                                        <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5v-1a1.9 1.9 0 0 1 .01-.2 4.49 4.49 0 0 1 1.534-3.693C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm7 0a1 1 0 0 1 1-1v-1a2 2 0 1 1 4 0v1a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-2Zm3-3a1 1 0 0 0-1 1v1h2v-1a1 1 0 0 0-1-1Z"/>
                                    </svg></button>`;
                    $rowData += `<button type="button" class="btn btn-info btn-icon-sm edit-btn mx-2"><i class="bi bi-pencil"></i></button>`;
                    //     $rowData += `<button type="button" class="btn btn-success btn-icon-sm jsondata-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-json" viewBox="0 0 16 16">
                    //     <path fill-rule="evenodd" d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM4.151 15.29a1.176 1.176 0 0 1-.111-.449h.764a.578.578 0 0 0 .255.384c.07.049.154.087.25.114.095.028.201.041.319.041.164 0 .301-.023.413-.07a.559.559 0 0 0 .255-.193.507.507 0 0 0 .084-.29.387.387 0 0 0-.152-.326c-.101-.08-.256-.144-.463-.193l-.618-.143a1.72 1.72 0 0 1-.539-.214 1.001 1.001 0 0 1-.352-.367 1.068 1.068 0 0 1-.123-.524c0-.244.064-.457.19-.639.128-.181.304-.322.528-.422.225-.1.484-.149.777-.149.304 0 .564.05.779.152.217.102.384.239.5.41.12.17.186.359.2.566h-.75a.56.56 0 0 0-.12-.258.624.624 0 0 0-.246-.181.923.923 0 0 0-.37-.068c-.216 0-.387.05-.512.152a.472.472 0 0 0-.185.384c0 .121.048.22.144.3a.97.97 0 0 0 .404.175l.621.143c.217.05.406.12.566.211a1 1 0 0 1 .375.358c.09.148.135.335.135.56 0 .247-.063.466-.188.656a1.216 1.216 0 0 1-.539.439c-.234.105-.52.158-.858.158-.254 0-.476-.03-.665-.09a1.404 1.404 0 0 1-.478-.252 1.13 1.13 0 0 1-.29-.375Zm-3.104-.033a1.32 1.32 0 0 1-.082-.466h.764a.576.576 0 0 0 .074.27.499.499 0 0 0 .454.246c.19 0 .33-.055.422-.164.091-.11.137-.265.137-.466v-2.745h.791v2.725c0 .44-.119.774-.357 1.005-.237.23-.565.345-.985.345a1.59 1.59 0 0 1-.568-.094 1.145 1.145 0 0 1-.407-.266 1.14 1.14 0 0 1-.243-.39Zm9.091-1.585v.522c0 .256-.039.47-.117.641a.862.862 0 0 1-.322.387.877.877 0 0 1-.47.126.883.883 0 0 1-.47-.126.87.87 0 0 1-.32-.387 1.55 1.55 0 0 1-.117-.641v-.522c0-.258.039-.471.117-.641a.87.87 0 0 1 .32-.387.868.868 0 0 1 .47-.129c.177 0 .333.043.47.129a.862.862 0 0 1 .322.387c.078.17.117.383.117.641Zm.803.519v-.513c0-.377-.069-.701-.205-.973a1.46 1.46 0 0 0-.59-.63c-.253-.146-.559-.22-.916-.22-.356 0-.662.074-.92.22a1.441 1.441 0 0 0-.589.628c-.137.271-.205.596-.205.975v.513c0 .375.068.699.205.973.137.271.333.48.589.626.258.145.564.217.92.217.357 0 .663-.072.917-.217.256-.146.452-.355.589-.626.136-.274.205-.598.205-.973Zm1.29-.935v2.675h-.746v-3.999h.662l1.752 2.66h.032v-2.66h.75v4h-.656l-1.761-2.676h-.032Z"/>
                    //   </svg></button>`;
                    return $rowData;
                },
                visible: true,
                targets: 4,
                className: "text-center",
            },
        ],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: "current" }).nodes();
            var last = null;

            $(rows)
                .find(".permission-btn")
                .on("click", function (e) {
                    e.preventDefault();
                    var tr = $(this).closest("tr");
                    var rowData = dtview.row(tr).data();
                    settingPermissionMenu(rowData);
                });
            $(rows)
                .find(".edit-btn")
                .on("click", function (e) {
                    e.preventDefault();
                    var tr = $(this).closest("tr");
                    var rowData = dtview.row(tr).data();
                    setDataMenu(rowData);
                });
            $(rows)
                .find(".jsondata-btn")
                .on("click", function (e) {
                    e.preventDefault();
                    var tr = $(this).closest("tr");
                    var rowData = dtview.row(tr).data();
                    setJsonData(rowData);
                });
        },
    });
}

function getListJson() {
    dtjson = $("#table-list-json").DataTable({
        ajax: {
            url: baseURL + "/getAccessRole",
            type: "POST",
            data: {
                param_type: "JSON",
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
            { data: "url" },
            { data: "id" },
        ],
        columnDefs: [
            // {
            //     mRender: function (data, type, row) {
            //         // var $rowData = '<button class="btn btn-sm btn-icon isEdit i_update"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit font-medium-2 text-info"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>';
            //         // $rowData += `<button class="btn btn-sm btn-icon delete-record i_delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash font-medium-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>`;
            //         $rowData = ` <span class="badge badge-danger">Inactive</span>`;
            //         if (row.is_active == 1) {
            //             $rowData = `<span class="badge badge-success">Active</span>`;
            //         }
            //         return $rowData;
            //     },
            //     visible: true,
            //     targets: 4,
            //     className: "text-center",
            // },
            {
                mRender: function (data, type, row) {
                    var $rowData = `<button type="button" class="btn btn-primary btn-icon-sm permission-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-lock" viewBox="0 0 16 16">
                                        <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5v-1a1.9 1.9 0 0 1 .01-.2 4.49 4.49 0 0 1 1.534-3.693C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm7 0a1 1 0 0 1 1-1v-1a2 2 0 1 1 4 0v1a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-2Zm3-3a1 1 0 0 0-1 1v1h2v-1a1 1 0 0 0-1-1Z"/>
                                    </svg></button>`;
                    //     $rowData += `<button type="button" class="btn btn-info btn-icon-sm edit-btn mx-2"><i class="bi bi-pencil"></i></button>`;
                    //     $rowData += `<button type="button" class="btn btn-success btn-icon-sm jsondata-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-json" viewBox="0 0 16 16">
                    //     <path fill-rule="evenodd" d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM4.151 15.29a1.176 1.176 0 0 1-.111-.449h.764a.578.578 0 0 0 .255.384c.07.049.154.087.25.114.095.028.201.041.319.041.164 0 .301-.023.413-.07a.559.559 0 0 0 .255-.193.507.507 0 0 0 .084-.29.387.387 0 0 0-.152-.326c-.101-.08-.256-.144-.463-.193l-.618-.143a1.72 1.72 0 0 1-.539-.214 1.001 1.001 0 0 1-.352-.367 1.068 1.068 0 0 1-.123-.524c0-.244.064-.457.19-.639.128-.181.304-.322.528-.422.225-.1.484-.149.777-.149.304 0 .564.05.779.152.217.102.384.239.5.41.12.17.186.359.2.566h-.75a.56.56 0 0 0-.12-.258.624.624 0 0 0-.246-.181.923.923 0 0 0-.37-.068c-.216 0-.387.05-.512.152a.472.472 0 0 0-.185.384c0 .121.048.22.144.3a.97.97 0 0 0 .404.175l.621.143c.217.05.406.12.566.211a1 1 0 0 1 .375.358c.09.148.135.335.135.56 0 .247-.063.466-.188.656a1.216 1.216 0 0 1-.539.439c-.234.105-.52.158-.858.158-.254 0-.476-.03-.665-.09a1.404 1.404 0 0 1-.478-.252 1.13 1.13 0 0 1-.29-.375Zm-3.104-.033a1.32 1.32 0 0 1-.082-.466h.764a.576.576 0 0 0 .074.27.499.499 0 0 0 .454.246c.19 0 .33-.055.422-.164.091-.11.137-.265.137-.466v-2.745h.791v2.725c0 .44-.119.774-.357 1.005-.237.23-.565.345-.985.345a1.59 1.59 0 0 1-.568-.094 1.145 1.145 0 0 1-.407-.266 1.14 1.14 0 0 1-.243-.39Zm9.091-1.585v.522c0 .256-.039.47-.117.641a.862.862 0 0 1-.322.387.877.877 0 0 1-.47.126.883.883 0 0 1-.47-.126.87.87 0 0 1-.32-.387 1.55 1.55 0 0 1-.117-.641v-.522c0-.258.039-.471.117-.641a.87.87 0 0 1 .32-.387.868.868 0 0 1 .47-.129c.177 0 .333.043.47.129a.862.862 0 0 1 .322.387c.078.17.117.383.117.641Zm.803.519v-.513c0-.377-.069-.701-.205-.973a1.46 1.46 0 0 0-.59-.63c-.253-.146-.559-.22-.916-.22-.356 0-.662.074-.92.22a1.441 1.441 0 0 0-.589.628c-.137.271-.205.596-.205.975v.513c0 .375.068.699.205.973.137.271.333.48.589.626.258.145.564.217.92.217.357 0 .663-.072.917-.217.256-.146.452-.355.589-.626.136-.274.205-.598.205-.973Zm1.29-.935v2.675h-.746v-3.999h.662l1.752 2.66h.032v-2.66h.75v4h-.656l-1.761-2.676h-.032Z"/>
                    //   </svg></button>`;
                    return $rowData;
                },
                visible: true,
                targets: 2,
                className: "text-center",
            },
        ],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: "current" }).nodes();
            var last = null;

            $(rows)
                .find(".permission-btn")
                .on("click", function (e) {
                    e.preventDefault();
                    var tr = $(this).closest("tr");
                    var rowData = dtjson.row(tr).data();
                    settingPermissionMenu(rowData);
                });
        },
    });
}

function setDataMenu(rowData) {
    $("#modal-edit").modal("show");
    $("#form-mid").val(rowData.id);
    $("#form-header").val(rowData.header_menu);
    $("#form-menu").val(rowData.menu_name);
    // loadRoleMenu(rowData);
}

function settingPermissionMenu(rowData) {
    $("#base-form").empty();
    loadRoleMenu(rowData);
}

let ArrCheckPermission;
function loadRoleMenu(rowData) {
    $.ajax({
        url: baseURL + "/getRoleMenuAccess",
        type: "POST",
        data: JSON.stringify(rowData),
        dataType: "json",
        contentType: "application/json",
        beforeSend: function () {
            // Swal.fire({
            //     title: "Loading",
            //     text: "Please wait...",
            //     showConfirmButton: false, // Menyembunyikan tombol OK
            // });
        },
        complete: function () {
            // swal.close();
        },
        success: function (response) {
            // console.log(response);
            // Handle response sukses
            if (response.code == 0) {
                // swal("Saved !", response.info, "success").then(function () {
                //     location.reload();
                // });
                let data = response.data;
                ArrCheckPermission = data;
                loadRole(rowData);
            } else {
                sweetAlert("Oops...", response.info, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            // Handle error response
            console.log("ERROR");
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
}

function loadRole(rowData) {
    $.ajax({
        url: baseURL + "/getRole",
        type: "POST",
        // data: { role_id: rowData.id },
        dataType: "json",
        contentType: "application/json",
        beforeSend: function () {
            Swal.fire({
                title: "Loading",
                text: "Please wait...",
                showConfirmButton: false, // Menyembunyikan tombol OK
            });
        },
        complete: function () {
            swal.close();
        },
        success: function (response) {
            // console.log(response);
            // Handle response sukses
            if (response.code == 0) {
                // swal("Saved !", response.info, "success").then(function () {
                //     location.reload();
                // });
                let data = response.data;
                el = "";

                // console.log(ArrCheckPermission);
                // console.log(data);
                data.forEach(function (item) {
                    var correspondingRole = ArrCheckPermission.find(function (
                        role
                    ) {
                        return role.role_id === item.id;
                    });

                    // Jika ditemukan peran yang sesuai dan i_view adalah 1, maka isChecked pada correspondingRole menjadi 1, jika tidak, isChecked menjadi 0
                    if (correspondingRole && correspondingRole.i_view === 1) {
                        item.isChecked = 1;
                    } else {
                        item.isChecked = 0;
                    }

                    el += `
                    <div class="mb-3 row text-center data-setting-permission">
                        <label class="col-sm-3 col-form-label">${
                            item.role_name
                        }</label>

                        <div class="col-sm-9">
                            <div class="form-check">
                                <input class="mid" type="hidden" value="${btoa(
                                    rowData.id
                                )}">
                                <input class="rid" type="hidden" value="${btoa(
                                    item.id
                                )}">
                                
                                <label class="form-check-label" for="flexCheckDefault">
                                <input class="form-check-input"  type="checkbox" value="" ${
                                    item.isChecked === 1 ? "checked" : ""
                                }>
                                Active
                                </label>
                            </div>
                        </div>
                    </div>
                    `;
                });

                $("#base-form").html(el);
                $("#modal-data").modal("show");
            } else {
                sweetAlert("Oops...", response.info, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            // Handle error response
            console.log("ERROR");
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
}

function savePermission() {
    var dataArray = [];

    $(".data-setting-permission").each(function () {
        var rid = $(this).find(".rid").val();
        var mid = $(this).find(".mid").val();
        var isChecked = $(this).find(".form-check-input").is(":checked");
        if (isChecked) {
            isChecked = 1;
        } else {
            isChecked = 0;
        }
        var dataObject = {
            rid: atob(rid),
            mid: atob(mid),
            is_active: isChecked,
        };

        dataArray.push(dataObject);
    });

    $.ajax({
        url: baseURL + "/saveUserAccessRole",
        type: "POST",
        data: JSON.stringify(dataArray),
        dataType: "json",
        contentType: "application/json",
        beforeSend: function () {
            Swal.fire({
                title: "Loading",
                text: "Please wait...",
                showConfirmButton: false, // Menyembunyikan tombol OK
            });
        },
        complete: function () {
            // swal.close();
        },
        success: function (response) {
            console.log(response);
            // Handle response sukses
            if (response.code == 0) {
                swal("Saved !", response.info, "success").then(function () {
                    location.reload();
                });
            } else {
                sweetAlert("Oops...", response.info, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            // Handle error response
            console.log("ERROR");
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
}

function updateDataMenu() {
    mid=$("#form-mid").val();
    headname=$("#form-header").val();
    menuname =$("#form-menu").val();

    data={mid:mid, nhead:headname , nmenu: menuname }

    console.log(data);
    $.ajax({
        url: baseURL + "/updateMenuAccessName",
        type: "POST",
        data: JSON.stringify(data),
        dataType: "json",
        contentType: "application/json",
        beforeSend: function () {
            Swal.fire({
                title: "Loading",
                text: "Please wait...",
                showConfirmButton: false, // Menyembunyikan tombol OK
            });
        },
        complete: function () {
            // swal.close();
        },
        success: function (response) {
            console.log(response);
            // Handle response sukses
            if (response.code == 0) {
                swal("Saved !", response.info, "success").then(function () {
                    location.reload();
                });
            } else {
                sweetAlert("Oops...", response.info, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            // Handle error response
            console.log("ERROR");
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
}

function saveConfirm(params) {
    swal({
        title: "Are you sure to save ?",
        text: "Please Check Back !!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, do it !!",
        cancelButtonText: "No, cancel it !!",
        closeOnConfirm: !1,
        closeOnCancel: !1,
    }).then(function (e) {
        console.log(e);
        if (e.value) {
            if(params == 1){
                savePermission()
            }else if(params == 2){
                updateDataMenu()
            }
        } else {
            swal("Cancelled !!", "Okey, Cancelled !!", "ERROR");
        }
    });
}

// async function loadRole() {
//     try {
//         const response = await $.ajax({
//             url: baseUrl + "/getRole",
//             type: "POST",
//             dataType: "json",
//             beforeSend: function () {
//                 // Swal.fire({
//                 //     title: "Loading",
//                 //     text: "Please wait...",
//                 // });
//             },
//         });

//         const res = response.data.map(function (item) {
//             return {
//                 id: item.id,
//                 text: item.category_name,
//             };
//         });

//         $("#form-category").select2({
//             data: res,
//             placeholder: "Please choose an option",
//             dropdownParent: $("#modal-data"),
//         });
//     } catch (error) {
//         sweetAlert("Oops...", error.responseText, "ERROR");
//     }
// }
