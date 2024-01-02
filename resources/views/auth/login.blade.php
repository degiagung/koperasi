@extends('layouts.user_type.guest')

@section('content')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Selamat Datang kembali</h3>
                </div>
                <div class="card-body">
                  <form role="form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <label>NRP</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" name="nrp" id="nrp" placeholder="No Anggota" aria-label="NRP" aria-describedby="nrp-addon">
                      {{-- @error('no_anggota')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror --}}
                    </div>
                    <label>Password</label>
                    <div class="mb-3">
                      <input type="password" class="form-control" name="password" id="password" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                      {{-- @error('password')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror --}}
                    </div>
                    @if ($errors->has('errormessage'))
                      <div class="form-group mb-3">
                        <span class="badge bg-danger mb-2">{{ $errors->first('errormessage') }}</span>
                      </div>
                    @endif
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>
                </div>
                {{-- <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Belum punya akun?
                    <a href="{{ route('sign-up') }}" class="text-info text-gradient font-weight-bold">Sign up</a>
                  </p>
                </div> --}}
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('../assets/img/loginbg.jpg')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection
