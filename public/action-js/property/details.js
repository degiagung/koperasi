$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
cekdatakamar();
fotokamar();
var csrfToken = $('meta[name="csrf-token"]').attr("content");
function modalbooking(){
    $("#modal-booking").modal('show')
}

var isObject = {};
function savebooking() {
    let jmlbulan    = $("#form-bln").val() ; 
    if($("#form-tgl").val() == ''){
        swal('Tanggal tidak boleh kosong','','warning');
        return false ;
    }
    if(jmlbulan <= 0){
        swal('Jumlah Bulan minimal 1 bulan','','warning');
        return false ;
    }
    isObject['tanggal'] = $("#form-tgl").val(); 
    isObject['bulan'] = $("#form-bln").val(); 
    isObject['idkamar'] = idkamar; 
    $.ajax({
        url: baseURL + "/saveBooking",
        type: "POST",
        data: JSON.stringify(isObject),
        dataType: "json", 
        contentType: "application/json",
        headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        beforeSend: function () {
            swal({
                title: "Loading",
                text: "Please wait...",
            });
        },
        complete: function () {
            $("#modal-booking").modal("hide");
        },
        success: function (response) {
            // Handle response sukses
            if (response.code == 0) {
                swal("Berhasil !", 'Berhasil disimpan', "success");
            } else {
                swal("Oops...", response.info, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            swal("Oops...", "ERROR", "ERROR");
        },
    });
}

function cekdatakamar(){
    $(".valkamar").empty();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: baseURL + '/cekdatakamar',
        data: {
            id    : idkamar,

        },
        success: function(result){
            if (result['data']){
                data = result['data'] ;
                $("#nokamar").html(data[0]['no_kamar']);
                $("#lantai").html(data[0]['lantai']);
                $("#tipe").html(data[0]['tipe']);
                $("#harga").html(data[0]['harga']+' / Bulan');
                $("#fasilitas").html(data[0]['faskos']);
                isObject['tipe'] = data[0]['idtipe'];
            
            }
            else{
                swal('Data Kamar tidak tersedia','','warning');
            }
        }
    });
}

function fotokamar(){
    $(".fotokamar").empty();
    $.ajax({
    type: 'POST',
    dataType: 'json',
    url: baseURL + '/getfotokamar',
    data: {
        id    : idkamar,

    }, success: function(result){
        var content = '';
        console.log(result)
        $.each(result.data, function(i,e){
            file = baseURL+e['alamat'].replaceAll('../public','')+e['file'];

            content += `
                <div class="col-lg-5">
                    <img src="`+file+`" style="width:300px;height: 150px;margin-top: 10px;" alt="">
                </div>
            `;
                
        });
        $(".fotokamar").append(content);
    }
    });
}