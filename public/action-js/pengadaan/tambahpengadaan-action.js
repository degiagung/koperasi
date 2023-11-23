

let dtpr;

$(document).ready(function () {

    $("#form-tgl-pengadaan").val(tgl_pengadaan);
    $("#form-no-pengadaan").val(no_pengadaan);
    
    LoadUser();
    LoadObat();
    LoadSupplier();
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

let c = 0;


function countTotalHarga() {
    totalHarga = 0;

    $(".form-item-obat li").each(function () {

        let harga = parseFloat($(this).find('.item-harga').text());
        
        totalHarga += harga;
    });

    return totalHarga;
}

function removeItemObat(id) {
    $(`#item${id}`).remove();

    getTotal = countTotalHarga();

    $(".form-total-harga").html(getTotal);
}


$(".add-obat").on("click", function (e) {
    e.preventDefault();

    var selectedidobat      = $("#form-obat").val();
    counter                 = c++;
    
    var obatAlreadyExists = false;

    $('li[id^="item"]').each(function(index) {
        // Dapatkan nilai dari elemen-elemen terkait
        let idObat = $(this).find('.item-id-obat').val();
        if(idObat == selectedidobat){
            obatAlreadyExists = true;
            sweetAlert("Oops...","Obat ini sudah ada.", "error");
            return false;
        }
    });

    if(!obatAlreadyExists) {
        var selectedobat    = $("#form-obat").find("option:selected").text();

        var getqty          = $("#form-qty").val();
    
        var dataobat        = selectedobat.split('/')
        var subharga        = getqty * dataobat[1];
        
        el = `
            <li id="item${counter}" class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <div class="d-flex flex-row bd-highlight mb-3">
                        <span class="badge badge-danger badge-sm my-1 me-1" onclick="removeItemObat(${counter})">x</span>
                        <input class="item-id-obat" type="hidden" value="${selectedidobat}">
                        <h6 class="my-1">${dataobat[0]}</h6>
                    </div>
    
                    <small class="text-muted item-qty-obat">${getqty}</small>
                    <small class="text-muted ">${dataobat[2]}</small>
                </div>
                <span class="text-muted item-harga my-1">${subharga}</span>
            </li>`;
    
        $(".form-item-obat").append(el);
    
        $(".item-obat-count").html($(".form-item-obat").length);
    
        getTotal = countTotalHarga();
    
        $(".form-total-harga").html(getTotal);
    
        //focus animation
        $(`#item${counter}`).addClass("border border-success");
    
        setTimeout(function() {
            $(`#item${counter}`).removeClass("border border-success");
            $(`#item${counter}`).focus();
        }, 1000);
    
    }
});

$("#save-btn").on("click", function (e) {
    e.preventDefault();
    let dataObat = [];

    $('li[id^="item"]').each(function(index) {
        // Dapatkan nilai dari elemen-elemen terkait
        let idObat = $(this).find('.item-id-obat').val();
        let namaObat = $(this).find('h6').text();
        let jumlah = $(this).find('.text-muted.item-qty-obat').text();
        let harga = $(this).find('.text-muted.item-harga').text();
    
        // Buat objek obat
        let obat = {
            id: idObat,
            nama: namaObat,
            jumlah: jumlah,
            harga: harga
        };
    
        // Push objek obat ke dalam array dataObat
        dataObat.push(obat);
    });

    checkValidation(dataObat);
});


function checkValidation(dataObat) {
   
    // console.log($el);
    if (
        validationSwalFailed(
            (dataObat.length),
            "Item obat tidak boleh kosong."
        )
    )
        return false;

    if (
        validationSwalFailed(
            (isObject["request_user_id"] = $("#form-request").val()),
            "Request By tidak boleh kosong."
        )
    )
        return false;
    
    if (
        validationSwalFailed(
            (isObject["id_supplier"] = $("#form-supplier").val()),
            "Supplier tidak boleh kosong."
        )
    )
        return false;

    isObject["obat_obatan"] = dataObat;
    isObject["total_harga"] =  $(".form-total-harga").text();
    // console.log(isObject);
    saveData();
}


function saveData() {
    
    $.ajax({
        url: baseURL + "/savePengadaan",
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

async function LoadUser() {
    try {
        const response = await $.ajax({
            url: baseURL + "/getUserList",
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
                text: item.name,
            };
        });

        $("#form-request").select2({
            data: res,
            placeholder: "Please choose an option",
            // dropdownParent: $("#modal-data"),
        });
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "error");
    }
}

async function LoadSupplier() {
    try {
        const response = await $.ajax({
            url: baseURL + "/getSupplierList",
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
                text: item.nama_supplier,
            };
        });

        $("#form-supplier").select2({
            data: res,
            placeholder: "Please choose an option",
            // dropdownParent: $("#modal-data"),
        });
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "error");
    }
}

async function LoadObat() {
    try {
        const response = await $.ajax({
            url: baseURL + "/getObatList",
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
                text: item.nama_obat+'/'+item.harga_beli+'/'+item.nama_satuan,
            };
        });

        $("#form-obat").select2({
            data: res,
            placeholder: "Please choose an option",
            // dropdownParent: $("#modal-data"),
        });
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "error");
    }
}