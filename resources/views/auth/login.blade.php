<!DOCTYPE html>
<html lang="en" class="h-100">
@include('includes.style')

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">
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

<body class="vh-100" style="background-image:url('images/bg.png'); background-position:center;">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
						{{-- <div class="row">
							<div class="text-center mb-3">
								<a href="index.html"><img src="{{asset('template/admin/images/logoapps.png')}}" alt=""></a>
							</div>
						</div> --}}
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<h4 class="text-center mb-4">Koperasi Primkopau Gemi Makmur</h4>
                                    <h4 class="text-center mb-4">Login</h4>
									<form action="{{ route('login') }}" method="POST" class=" dz-form pb-3">
										@csrf
									
										<div class="dz-separator-outer m-b5">
											<div class="dz-separator bg-primary style-liner"></div>
										</div>
										<p>Masukkan email dan password anda. </p>
										<div class="form-group mb-3">
											<input type="email"  name="email" id="email" class="form-control" placeholder="email@example.com">
										</div>
										<div class="form-group mb-3">
											<input type="password"  name="password" id="password" class="form-control" placeholder="password">
										</div>
										@if ($errors->has('email'))
											<div class="form-group mb-3">
												<span class="badge bg-danger mb-2">{{ $errors->first('email') }}</span>
											</div>
										@endif
										<div class="form-group text-center mb-6 forget-main">
											<button type="submit" class="btn btn-success">Masuk</button>
											{{-- <span class="form-check d-inline-block">
												<input type="checkbox" class="form-check-input" id="check1" name="example1">
												<label class="form-check-label" for="check1">Remember me</label>
											</span> --}}
											<!-- <button class="nav-link m-auto btn tp-btn-light btn-primary forget-tab " id="nav-forget-tab" data-bs-toggle="tab" data-bs-target="#nav-forget" type="button" role="tab" aria-controls="nav-forget" aria-selected="false">Forget Password ?</button> 	 -->
										</div>
										<!-- <div class="dz-social ">
											<h5 class="form-title fs-20">Sign In With</h5>
											<ul class="dz-social-icon dz-border dz-social-icon-lg text-white">
												<li><a target="_blank" href="https://www.facebook.com/" class="fab fa-facebook-f btn-facebook"></a></li>
												<li><a target="_blank" href="https://www.google.com/" class="fab fa-google-plus-g btn-google-plus"></a></li>
												<li><a target="_blank" href="https://www.linkedin.com/" class="fab fa-linkedin-in btn-linkedin"></a></li>
												<li><a target="_blank" href="https://twitter.com/" class="fab fa-twitter btn-twitter"></a></li>
											</ul>
										</div> -->
									</form>
                                    {{-- <div class="new-account mt-3">
                                        <p>Not have an account? <a class="text-primary" href="{{route('sign-up')}}">Sign up</a></p>
                                    </div> --}}
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
</body>
</html>