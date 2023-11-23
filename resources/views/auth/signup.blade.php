<!DOCTYPE html>
<html lang="en" class="h-100">
@include('includes.style')

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Yashadmin:Sales Management System Admin Bootstrap 5 Template">
	<meta property="og:title" content="Yashadmin:Sales Management System Admin Bootstrap 5 Template">
	<meta property="og:description" content="Yashadmin:Sales Management System Admin Bootstrap 5 Template">
	<meta property="og:image" content="https:/yashadmin.dexignzone.com/xhtml/social-image.png">
	<meta name="format-detection" content="telephone=no">
	
	<!-- PAGE TITLE HERE -->
	<title>POINTCUT</title>
	
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <link href="./css/style.css" rel="stylesheet">

</head>

<body class="vh-100" style="background-image:url('images/bg.png'); background-position:center;>
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="index.html"><img src="{{asset('template/admin/images/logoapps.png')}}" alt=""></a>
									</div>
                                    <h4 class="text-center mb-4">Sign up your account</h4>
                                    <form action="index.html">
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Name</strong></label>
                                            <input type="text" id="form-name" class="form-control" placeholder="Name">
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Phone</strong></label>
                                            <input type="number" id="form-phone" class="form-control" placeholder="08***" value="">
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" id="form-email" class="form-control" placeholder="hello@example.com">
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" id="form-password" class="form-control" placeholder="Example123" value="">
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" id="save-btn" class="btn btn-primary btn-block">Sign me up</button>
                                        </div>

                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Already have an account? <a class="text-primary" href="{{route('login')}}">Sign in</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--**********************************
	Scripts
***********************************-->
<!-- Required vendors -->
<script src="./vendor/global/global.min.js"></script>
<script src="./js/custom.js"></script>
<script src="./js/deznav-init.js"></script>
@include('includes.script')
<script>
    
var baseUrl = window.location.origin;

$("#save-btn").on("click", function (e) {
    e.preventDefault();
    checkValidation();
});

let isObject={}

function saveData() {
    console.log(isObject);
    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    url = baseUrl + "/ajax-createcustomer";

    $.ajax({
        url: url,
        type: "POST",
        data: JSON.stringify(isObject),
        dataType: "json",
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": csrfToken, // Sertakan CSRF token dalam headers permintaan
        },
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
                    location.href(baseUrl+"/login");
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

function checkValidation() {
    // console.log($el);
    if (
        validationSwalFailed(
            (isObject["name"] = $("#form-name").val()),
            "Full Name field cannot be empty."
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["phone"] = $("#form-phone").val()),
            "Phone field cannot be empty."
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
            (isObject["password"] = $("#form-password").val()),
            "Email field cannot be empty."
        )
    )
        return false;
    // isObject["desc"] = $("#form-desc").val();

    saveData();
}

function validationSwalFailed(param, isText) {
    // console.log(param);
    if (param == "" || param == null) {
        sweetAlert("Oops...", isText, "warning");

        return 1;
    }
}
</script>
</body>
</html>