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
	<meta name="description" content="rba">
	<meta property="og:title" content="rba">
	<meta property="og:description" content="rba">
	<meta property="og:image" content="rba">
	<meta name="format-detection" content="telephone=no">
	
	<!-- PAGE TITLE HERE -->
	<title>Generate</title>
	
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="images/favicon.png">

    @foreach ($cssFiles as $file)
    <link rel="stylesheet" href="{{ $file }}">
    @endforeach

</head>

<body class="vh-100" style="background-image:url('images/bg.png'); background-position:center;"">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form text-center">
									{{-- <div class="text-center mb-3">
										<a href="index.html"><img src="{{asset('template/admin/images/logoapps.png')}}" alt=""></a>
									</div> --}}
                                    <h4 class="text-center mb-4">Generate Your Methods</h4>
                                    <img src="template/admin/images/analytics/developer_male.png" class="harry-img" alt=""><br>
									<span class="btn btn-primary" onclick="saveGenerate()">Generate</span>
                                    
                                    <div class="new-account mt-3">
                                        <p>@rb</p>
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
{{-- <script src="./vendor/global/global.min.js"></script>
<script src="./js/custom.js"></script>
<script src="./js/deznav-init.js"></script> --}}

@include('includes.script')

<script> 
@foreach ($varJs as $varjsi)
    {!! $varjsi !!}
@endforeach
</script>


@foreach ($javascriptFiles as $file)
    <script src="{{ $file }}"></script>
@endforeach

</body>
</html>