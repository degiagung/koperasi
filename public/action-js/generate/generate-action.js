function saveGenerate() {
    $.ajax({
        url: baseURL + "/generate",
        type: "POST",
        data: { uid: 1 },
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
                // Reset form
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
