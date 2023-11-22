$(".datatable-basic").DataTable();
$(".select-search").select2();

let dtpr;
getListData();
function getListData() {
    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getlistmenu",
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
                sClass:"",render: function (data, type, row, meta) {
                    return "<a class='edit-btn' style='cursor:pointer'>"+row.access_code+"</a>";
                },
            },
            { sClass:"tdwidth",data: "access_name" },
            { sClass:"",data: "class" },
            { sClass:"",data: "icon" },
            {
                render: function (data, type, row) {
                    $rowData = `<button onClick="updatestatus('`+row.access_name+`','`+row.id+`')" type="button" class="btn btn-danger btn-icon-sm delete-btn"><i class="glyphicon glyphicon-trash"></i></button>`;
                    return $rowData;

                    // content = `
                    //     <div class="dropdown">
                    //     <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    //         <i class="fa fa-caret-down" aria-hidden="true"></i>
                    //     </button>
                    //     <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    //         <li><a onClick="updatestatus('10','`+row.iduser+`','`+row.name+`')">Active</a></li>
                    //         <li><a onClick="updatestatus('20','`+row.iduser+`','`+row.name+`')">Inactive</a></li>
                    //         <li><a onClick="updatestatus('30','`+row.iduser+`','`+row.name+`')">Delete</a></li>
                    //     </ul>
                    //     </div>
                    // `;
                    // return content ;
                },
            },
        ],
        columnDefs: [
        ],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: "current" }).nodes();
            var last = null;

            // $(rows)
            //     .find(".edit-btn")
            //     .on("click", function () {
            //         $('#titleview').html('Data User');
            //         var tr = $(this).closest("tr");
            //         var rowData = dtpr.row(tr).data();
            //         editdata(rowData);
            //     });
        },
    });
}

let isObject = {};

function editdata(rowData) {
    isObject = rowData;
    $("#form-menu").val(rowData.menu);
    $("#form-class").val(rowData.class);
    $("#form-icon").val(rowData.icon);
    $("#modal-data").modal("show");
}

$("#add-btn").on("click", function (e) {
    
    $("#divpassword").show();
    $('#titleview').html('Tambah User');

    e.preventDefault();

    isObject = {};
    isObject["id"] = null;
    $("#form-menu").val("");
    $("#form-class").val("");
    $("#form-icon").val("");
    $("#modal-data").modal("show");
});

$("#save-btn").on("click", function (e) {
    e.preventDefault();
    checkValidation();
});


function checkValidation() {
    if (
        validationSwalFailed(
            (isObject["menu"] = $("#form-menu").val()),
            "Nama Menu"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["class"] = $("#form-class").val()),
            "Class"
        )
    )
        return false;

    if (
        validationSwalFailed(
            (isObject["icon"] = $("#form-icon").val()),
            "Icon"
        )
    )
        return false;
    
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

function updatestatus(name,id) {

    swal({
        icon: "warning",
        title: "Yakin DELETE menu "+name+" ?",
        type: "warning",
		buttons: [
		'Batal',
		'Yakin'
		],
		dangerMode: true,
	}).then(function(isConfirm) {
		if (isConfirm) {
            $.ajax({
                url: baseURL + "/deleteMenu",
                type: "POST",
                data: JSON.stringify(
                    { 
                        id: id ,
                            
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
                            text: 'Gagal Delete',
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
}

function saveData() {
    
    $.ajax({
        url: baseURL + "/saveMenu",
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
                    text    : 'Gagal menambahkan menu',
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