
$.ajaxSetup({
headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
},
});

$("#save-btn").on("click", function (e) {
    e.preventDefault();
    checkValidation();
});

let isObject={}

function saveData() {
    url = baseURL + "/signup";

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: baseURL + '/createaccount',
        data: JSON.stringify(isObject),
        contentType: "application/json",
        beforeSend: function () {
            swal("Loading","Mohon Ditunggu ....");
        },
        complete: function () {},
        success: function (response) {
            // Handle response sukses
            console.log(response)
            if (response.code == '0') {
                swal("Berhasil", '' , "success").then(function () {
                    // location.href(baseURL);
                    window.location.href = baseURL ;
                });
                // Reset form
            } else {
                swal("Oops...",  response.message , "error");
            }
        },
        error: function (xhr, status, error) {
            // Handle error response
            // console.log(xhr.responseText);
            swal("Oops...",  response.message , "error");
        },
    });
}

function checkValidation() {
    // console.log($el);
    if (
        validationSwalFailed(
            (isObject["name"] = $("#form-name").val()),
            "Nama"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["handphone"] = $("#form-phone").val()),
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
            (isObject["password"] = $("#form-password").val()),
            "Password"
        )
    )
        return false;
    // isObject["desc"] = $("#form-desc").val();

    saveData();
}

function validationSwalFailed(param, isText) {
    // console.log(param);
    if (param == "" || param == null) {
        swal("Oops...", isText+' tidak boleh kosong', "warning");

        return 1;
    }
}