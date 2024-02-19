
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
                        {{-- <form action="index.html">
                        @csrf --}}
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Name" name="name" id="form-name" aria-label="Name" aria-describedby="name" value="{{ old('name') }}">
                            @error('name')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="081xxxxxx" name="handphone" id="form-phone" aria-label="Phone" aria-describedby="phone" value="{{ old('phone') }}">
                            @error('phone')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="No Anggota" id="form-noanngota" >
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="NRP" id="form-nrp" >
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-pangkat" placeholder="Pangkat" id="form-pangkat" >
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" placeholder="Password" name="password" id="form-password" aria-label="Password" aria-describedby="password-addon">
                            @error('password')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- <div class="form-check form-check-info text-left">
                            <input class="form-check-input" type="checkbox" name="agreement" id="flexCheckDefault" checked>
                            <label class="form-check-label" for="flexCheckDefault">
                            I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                            </label>
                            @error('agreement')
                            <p class="text-danger text-xs mt-2">First, agree to the Terms and Conditions, then try register again.</p>
                            @enderror
                        </div> --}}
                        <div class="text-center">
                            <button type="submit" id="save-btn" class="btn bg-gradient-dark w-100 my-4 mb-2">Simpan</button>
                        </div>
                        <p class="text-sm mt-3 mb-0">Sudah Punya Akun? <a href="{{ route('login') }}" class="text-dark font-weight-bolder">Masuk</a></p>
                        {{-- </form> --}}
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
    
    