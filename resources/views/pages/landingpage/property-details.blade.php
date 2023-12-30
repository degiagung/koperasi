@extends('pages.landingpage.layouts')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="page-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          {{-- <span class="breadcrumb"><a href="#">Home</a>  /  S</span> --}}
          <h3>Detail Kamar</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="section best-deal">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="section-heading">
            <h6>| Penawaran Terbaik</h6>
            <h2>Find Your Best Deal Right Now!</h2>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="tabs-content">
            <div class="row">
                         
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="appartment" role="tabpanel" aria-labelledby="appartment-tab">
                  <div class="row">
                    <div class="icon-button">
                      <a onclick="modalbooking()" style="color:#fff;"><i class="fa fa-calendar"></i> BOOKING</a>
                    </div>
                    <div class="col-lg-5" style="margin-top: 15px;">
                      <div class="info-table">
                        <ul>
                          <li>No Kamar <span class ="valkamar" id="nokamar"></span></li>
                          <li>Lantai <span class ="valkamar" id="lantai"></span></li>
                          <li>Tipe Kamar <span class ="valkamar" id="tipe"></span></li>
                          <li>Harga Kamar <span class ="valkamar" id="harga"></span></li>
                          <li>Fasilitas Kos <span class ="valkamar" id="fasilitas" style="font-size: 12px;"></span></li>
                        </ul>
                        
                      </div>
                    </div>
                    <div class="col-lg-6" style="margin-top: 15px;padding:0px">
                      <div class="row fotokamar">
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-booking">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Booking</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <center>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Tanggal Kos</label>
                    <div class="col-sm-9">
                        <input id="form-tgl" name="form-tgl" type="date" class="form-control" min="{{ now()->toDateString('Y-m-d') }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Jml Bulan (*)</label>
                    <div class="col-sm-9">
                        <input id="form-bln" name="form-bln" type="number" class="form-control" min="1">
                    </div>
                </div>
            </center>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="savebooking()">Booking</button>
        </div>
        </div>
    </div>
  </div>

  <script> 
        @foreach ($varJs as $varjsi)
            {!! $varjsi !!}
        @endforeach
    </script>
    @foreach ($javascriptFiles as $file)
        <script src="{{ $file }}"></script>
    @endforeach
@endsection