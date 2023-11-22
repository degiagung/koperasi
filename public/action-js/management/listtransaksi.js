$(".datatable-basic").DataTable();
$(".select-search").select2();

let dtpr;
loadRole();
getListData();

function getListData() {
    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getlisttransaksi",
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
                render: function (data, type, row, meta) {
                    no = meta.row + meta.settings._iDisplayStart + 1;
                    return no ;
                },
            },
            {
                sClass:"tdwidth",render: function (data, type, row, meta) {
                    return "<a class='edit-btn' style='cursor:pointer'>"+row.name+"</a>";
                },
            },
            { sClass:"tdwidth",data: "email" },
            {
                render: function (data, type, row) {
                    // var $rowData = '<button class="btn btn-sm btn-icon isEdit i_update"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit font-medium-2 text-info"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>';
                    // $rowData += `<button class="btn btn-sm btn-icon delete-record i_delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash font-medium-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>`;
                    $rowData = row.role ; 
                    return $rowData;
                },
            },
            {
                render: function (data, type, row) {
                    $rowData = 'INACTIVE';
                    if (row.status == 10) {
                        $rowData = 'ACTIVE';
                    }else if (row.status == 20) {
                        $rowData = 'INACTIVE';
                    }else{
                        $rowData = 'DELETED';
                    }
                    return $rowData;
                },
            },
            {
                render: function (data, type, row) {
                    // var $rowData = `<button type="button" class="btn btn-primary btn-icon-sm mx-2 edit-btn"><i class="glyphicon glyphicon-pencil"></i></button>`;
                    // $rowData += `<button type="button" class="btn btn-danger btn-icon-sm delete-btn"><i class="glyphicon glyphicon-trash"></i></button>`;
                    // return $rowData;

                    content = `
                        <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a onClick="updatestatus('10','`+row.iduser+`','`+row.name+`')">Active</a></li>
                            <li><a onClick="updatestatus('20','`+row.iduser+`','`+row.name+`')">Inactive</a></li>
                            <li><a onClick="updatestatus('30','`+row.iduser+`','`+row.name+`')">Delete</a></li>
                        </ul>
                        </div>
                    `;
                    return content ;
                },
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
                    $('#titleview').html('Data User');
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
    console.log(isObject);
    $("#divpassword").hide();
    $("#form-email").val(rowData.email);
    $("#form-password").val();
    $("#form-name").val(rowData.name);
    $("#form-handphone").val(rowData.handphone);
    $("#form-noktp").val(rowData.no_ktp);
    $("#form-alamat").val(rowData.alamat);
    $("#form-role").val(rowData.role).trigger("change");

    let $el = $("input:radio[name=form-status]");

    $el.filter("[value=" + rowData.is_active + "]").prop("checked", true);

    $("#modal-data").modal("show");
}

$("#add-btn").on("click", function (e) {
    
    $("#divpassword").show();
    $('#titleview').html('Tambah User');

    e.preventDefault();

    isObject = {};
    isObject["id"] = null;
    $("#form-email").val("");
    $("#form-name").val("");
    $("#form-handphone").val("");
    $("#form-noktp").val("");
    $("#form-alamat").val("");
    $("#form-password").val("");
    $("#form-role").val("").trigger("change");
    // $("input:radio[name=form-status]").prop("checked", false);
    $("#modal-data").modal("show");
});

$("#save-btn").on("click", function (e) {
    e.preventDefault();
    checkValidation();
});


function checkValidation() {
    if (
        validationSwalFailed(
            (isObject["name"] = $("#form-name").val()),
            "Nama."
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["handphone"] = $("#form-handphone").val()),
            "Handphone"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["email"] = $("#form-email").val()),
            "Email"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["noktp"] = $("#form-noktp").val()),
            "No KTP"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["alamat"] = $("#form-alamat").val()),
            "Alamat"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["password"] = $("#form-password").val()),
            "Password"
        )
    )
    if (
        validationSwalFailed(
            (isObject["role"] = $("#form-role").val()),
            "Role"
        )
    )
        return false;
        isObject["role"] = $("#form-role").val();

    saveData();
}

function validationSwalFailed(param, isText) {
    // console.log(param);
    if (param == "" || param == null) {
        swal({
			icon: "warning",
			title: "Oops...",
			text: isText+' tidak boleh kosong',
		});

        return 1;
    }
}

function updatestatus(status,iduser,name) {
    if (status == 10) {
        statusn = 'ACTIVE';
    }else if (status == 20) {
        statusn = 'INACTIVE';
    }else{
        statusn = 'DELETED';
    }
    swal({
        icon: "warning",
        title: "Yakin untuk melakukan "+statusn+" pada user "+name+" ?",
        type: "warning",
		buttons: [
		'Batal',
		'Yakin'
		],
		dangerMode: true,
	}).then(function(isConfirm) {
		if (isConfirm) {
            $.ajax({
                url: baseURL + "/changestatususer",
                type: "POST",
                data: JSON.stringify(
                    { 
                        iduser: iduser ,
                        status: status 
                            
                    }
                ),
                dataType: "json",
                contentType: "application/json",
                beforeSend: function () {
                    swal({
                        title: "Dalam Proses ...",
                        text: 'Mohon ditunggu ya',
                    });
                },
                complete: function () {},
                success: function (response) {
                    // Handle response sukses
                    if (response.code == 0) {
                        swal({
                            icon: "success",
                            title: "Berhasil",
                            text: 'Data telah diperbaharui',
                        }).then(function () {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: "error",
                            title: "Opsss ...",
                            text: 'Gagal mengubah status',
                        });
                    }
                },
                error: function (xhr, status, error) {
                    swal({
                        icon: "error",
                        title: "Opsss ...",
                        text: xhr.responseText +' Error',
                    });
                },
            });
			
		} else {
			swal("Batal", "Permintaan dibatalkan", "error");
		}
    });

    
    // swal({
    //     title: "Yakin untuk melakukan "+statusn+" pada user "+name+" ?",
    //     text: "Mohon dicek terlebih dahulu",
    //     type: "warning",
    //     showCancelButton: !0,
    //     confirmButtonColor: "#DD6B55",
    //     confirmButtonText: "YAKIN",
    //     cancelButtonText: "Batalkan",
    //     closeOnConfirm: !1,
    //     closeOnCancel: !1,
    // }).then(function (e) {
    //     console.log(e);
    //     if (e.value) {
    //         $.ajax({
    //             url: baseURL + "/changestatususer",
    //             type: "POST",
    //             data: JSON.stringify(
    //                 { 
    //                     iduser: iduser ,
    //                     status: status 
                         
    //                 }
    //             ),
    //             dataType: "json",
    //             contentType: "application/json",
    //             beforeSend: function () {
    //                 Swal.fire({
    //                     title: "Loading",
    //                     text: "Please wait...",
    //                 });
    //             },
    //             complete: function () {},
    //             success: function (response) {
    //                 // Handle response sukses
    //                 if (response.code == 0) {
    //                     swal({
    //                         icon: "success",
    //                         title: "Berhasil",
    //                         text: 'Data telah diperbaharui',
    //                     });
    //                 } else {
    //                     swal({
    //                         icon: "error",
    //                         title: "Opsss ...",
    //                         text: 'Gagal mengubah status',
    //                     });
    //                 }
    //             },
    //             error: function (xhr, status, error) {
    //                 swal({
    //                     icon: "error",
    //                     title: "Opsss ...",
    //                     text: xhr.responseText +' Error',
    //                 });
    //             },
    //         });
    //     } else {
    //         swal(
    //             "Dibatalkan !!",
    //             "Permintaan telah dibatalkan !!",
    //             "error"
    //         );
    //     }
    // });
}

function saveData() {
    
    $.ajax({
        url: baseURL + "/saveUser",
        type: "POST",
        data: JSON.stringify(isObject),
        dataType: "json",
        contentType: "application/json",
        beforeSend: function () {
            swal({
                title: "Loading",
                text: "Please wait...",
            });
        },
        complete: function () {},
        success: function (response) {
            // Handle response sukses
            if (response.code == '0') {
                swal({
                    icon    : "success",
                    title   : 'Berhasil',
                    text    : 'Menyimpan data',
                }).then(function () {
                    location.reload();
                });
                // Reset form
            } else {
                swal({
                    icon    : "error",
                    title   : 'Oops...',
                    text    : 'Gagal menambahkan user',
                });
            }
        },
        error: function (xhr, status, error) {
            // Handle error response
            swal({
                icon    : "error",
                title   : 'Oops...',
                text    : xhr.responseText,
            });
        },
    });
}

async function loadRole() {
    try {
       
        $.ajax({
            type		: 'POST',
            dataType	: 'json',
            url			: baseURL + '/getrole',
            success: function(response){
                data = response.data;
                $('#form-role').empty();
                let opt = '';
    
                for (var i = 0; i < data.length; i++) {
                    opt += '<option value="'+data[i].role+'">'+data[i].role+'</option>';
                }
    
                $('#form-role').append(opt);
            }
        });

        
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "error");
    }
}