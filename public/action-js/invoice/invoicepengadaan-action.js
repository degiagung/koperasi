

let dtpr;

$(document).ready(function () {
    isObject['no_pengadaan'] = no_pengadaan
    getInvoice(isObject);
});


let isObject = {};
function getInvoice() {
    
    $.ajax({
        url: baseURL + "/getInvoicePengadaan",
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
        complete: function () {swal.close()},
        success: function (response) {
            // Handle response sukses
            if (response.code == 0) {
                
                const datax = response.data
                el ='';
                datax.forEach(element => {
                    el += `
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <div class="d-flex flex-row bd-highlight mb-3">
                                <h6 class="my-1">${element.nama_obat}</h6>
                            </div>
            
                            <small class="text-muted item-qty-obat">${element.qty_request}</small>
                            <small class="text-muted ">${element.nama_satuan}</small>
                        </div>
                        <span class="text-muted item-harga my-1">${element.harga_item}</span>
                    </li>`;
                });

                $(".form-item-obat").append(el);
                $("#form-tgl-pengadaan").val(datax[0].tanggal);
                $("#form-no-pengadaan").val(datax[0].no_pengadaan);
                $("#form-supplier").val(datax[0].nama_supplier);
                $("#form-request").val(datax[0].nama_req);
                $("#form-accept").val(datax[0].nama_acc);
                $("#form-approve").val(datax[0].nama_approve);

                $dataxData="";
                if(datax[0].status == 10) {
                    $dataxData = `<span class="badge badge-success">Selesai</span>`;
                }else if (datax[0].status == 20) {
                    $dataxData = `<span class="badge badge-dark">Request</span>`;
                }else if (datax[0].status == 30) {
                    $dataxData = `<span class="badge badge-info">Approved Gudang</span>`;
                }else if (datax[0].status == 40) {
                    $dataxData = `<span class="badge badge-secondary">Send By Gudang</span>`;
                }
                
                $("#form-status").html($dataxData);

                $(".form-total-harga").html(datax[0].total_harga);

                $(".item-obat-count").html(datax.length);
                

                // $("#save-btn").hide();

                $("#save-btn").attr("status",datax[0].status);
                if (datax[0].status == 20 && role_id == 8) {
                    $("#save-btn").attr("status",30);
                    $("#save-btn").html("Approve (Gudang)");
                }else if (datax[0].status == 30 && role_id == 8) {
                    $("#save-btn").attr("status",40);
                    $("#save-btn").html("Send (Gudang)");
                }else{
                    $("#save-btn").remove();
                }
                // else if (datax[0].status == 40  && role_id == 6) {
                //     $("#save-btn").attr("status",10);
                //     $("#save-btn").html("Accept (Checker)");
                // }

                
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



$("#save-btn").on("click", function (e) {
    e.preventDefault();
    isObject['status'] = $(this).attr('status')
    saveData();
});



function saveData() {
    
    $.ajax({
        url: baseURL + "/saveStatusRequestPengadaan",
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

