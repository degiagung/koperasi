
@extends('layouts.user_type.guest')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <main class="main-content  mt-0">
        <section class="min-vh-100 mb-8">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 mx-3 border-radius-lg" style="background-image: url('../assets/img/registerbg.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 text-center mx-auto">
                <h1 class="text-white mb-2 mt-5">Selamat Datang!</h1>
                <p class="text-lead text-white">Silahkan mengisi data berikut.</p>
                </div>
            </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10">
            <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                <div class="card z-index-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <label>Tanggal Huni</label>
                            <input type="date" class="form-control" placeholder="Tanggal" name="tanggal" id="form-tanggal" aria-label="Tanggal" aria-describedby="tanggal">
                        </div>
                        <div class="mb-3">
                            <label>Jumlah Bulan / Durasi</label>
                            <input type="number" min="0" max="12" class="form-control" placeholder="Jumlah Bulan" name="jmlbulan" id="form-bulan" aria-label="Jumlah Bulan" aria-describedby="jmlbulan">
                        </div>
                        <div class="text-center">
                            <button type="submit" id="save-btn" class="btn bg-gradient-dark w-100 my-4 mb-2">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </section>
    </main>

<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->

    @include('includes.script')
    <script> 
        @foreach ($varJs as $varjsi)
            {!! $varjsi !!}
        @endforeach
    </script>
    @foreach ($javascriptFiles as $file)
        <script src="{{ $file }}"></script>
    @endforeach
@endsection
    
    