@extends('layout.default')
@push('after-style')
    @foreach ($cssFiles as $file)
        <link rel="stylesheet" href="{{ $file }}">
    @endforeach
@endpush
@section('content')
    <style>
        #table-list{
            white-space: nowrap;
        }
    </style>
    <section class="section dashboard">
         <div class="row">
            <h2>Pinjaman Anggota</h2>
            <br>
            <div class="col-lg-12">
                 <div class="card-filter">
                    <label style="font-size:18px;">Filter</label>
                    <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <label>Status Pinjaman</label>
                                <select id="filter-status" name="filter-keanggotaan" class="select2 ">
                                    <option value="">Semua Status</option>
                                    <option value="1">LUNAS</option>
                                    <option value="2">BELUM LUNAS</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Status Keanggotaan</label>
                                <select id="filter-keanggotaan" name="filter-keanggotaan" class="select2 ">
                                    <option value="">Semua Kondisi</option>
                                    <option value="<= current_date and us.status != '2'">AKTIF</option>
                                    <option value="> current_date">PENSIUN</option>
                                    <option value="pindah">PINDAH</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Tahun Transaksi</label>
                                <select  class="select2" id="filter-tahun"></select>
                            </div>
                            <div class="col-sm-3">
                                <label>Bulan Transaksi</label>
                                <select  class="select2" id="filter-bulan"></select>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" id="filter-btn" class="btn btn-sgn" style="color:#e12a2a;width:100%;height:35px;font-size:14px;margin-top: 27px;"><i class="bi bi-search" style="font-size:12px;" ></i> Cari</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header mt-2 flex-wrap d-flex justify-content-between">
                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if ($role != 'anggota')
                                <table id="table-list" class="table table-bordered table-striped table-lgdatatables">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Status </th>
                                            <th>NRP</th>
                                            <th>Nama Anggota</th>
                                            <th>Tanggal Dinas</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>keanggotaan</th>
                                            <th>Total Limit</th>
                                            <th>Pengajuan Tenor & Pinjaman</th>
                                            <th>Total Pembayaran</th>
                                            <th>Sisa Limit</th>
                                            <th>Sisa Tenor & Pinjaman</th>
                                            <th>Bukti Cicilan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            @endif
                            @if ($role == 'anggota')
                                <table id="table-list" class="table table-bordered table-striped table-lgdatatables">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Status</th>
                                            <th>Tgl Pinjam</th>
                                            <th>Tgl Pembayaran</th>
                                            <th>Nominal</th>
                                            <th>Tenor</th>
                                            <th>Cicilan Ke</th>
                                            <th>Bukti Cicilan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-data" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">Data Pinjaman Terbaru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form">
                            <form>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">NRP</label>
                                    <div class="col-sm-9">
                                        <input readonly id="form-nrp" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input readonly id="form-name" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Tgl Dinas</label>
                                    <div class="col-sm-9">
                                        <input readonly id="form-tgldinas" type="text" class="form-control" >
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Keanggotaan</label>
                                    <div class="col-sm-9">
                                        <input readonly id="form-keanggotaan" type="text" class="form-control" >
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Total Limit</label>
                                    <div class="col-sm-9">
                                        <input readonly id="form-limit" type="text" class="form-control" >
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Sisa Limit</label>
                                    <div class="col-sm-9">
                                        <input readonly id="form-totallimit" type="text" class="form-control" >
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Pengajuan Tenor & Pinjaman</label>
                                    <div class="col-sm-9">
                                        <input readonly id="form-pinjaman" type="text" class="form-control" >
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Sisa Tenor & Pinjaman</label>
                                    <div class="col-sm-9">
                                        <input readonly id="form-sisatenor" type="text" class="form-control" >
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Tgl Pinjaman</label>
                                    <div class="col-sm-9">
                                        <input readonly id="form-tgltarik" type="text" class="form-control" >
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Tanggal Angsuran Terbaru</label>
                                    <div class="col-sm-9">
                                        <input readonly id="form-tglbayar" type="text" class="form-control" >
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-payment" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">UPDATE PINJAMAN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form">
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label ">Status Pinjaman</label>
                                <div class="col-sm-7">
                                    <select class="select2add" id="form-statuslunas">
                                        <option value="lunas">Lunas</option>
                                    </select>

                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">Kwitansi</label>
                                <div class="col-sm-7">
                                    <form role="form" class="" id="formbukti" method="post" type="post" enctype="multipart/form-data">
                                        <input class="form-control" name="bukti" id="form-bukti" type="file" value="" multiple style="opacity:1;"/>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sgn light" onClick="approval() ">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-detail" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">Bukti Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="table-list" class="table table-bordered table-striped table-lgdatatables">
                            <thead>
                                <tr>
                                    <th>Tenor</th>
                                    <th>Nominal</th>
                                    <th>Cicilan Ke</th>
                                    <th>Bukti Cicilan</th>
                                </tr>
                            </thead>
                            <tbody id="detailbukti">

                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sgn light" onClick="approval() ">Simpan</button>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-bukti" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">Bukti Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form buktidiv">
                            
                        </div>
                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sgn light" onClick="approval() ">Simpan</button>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-upload" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">Upload Bukti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form">
                                
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Bukti Transaksi</label>
                                <div class="col-sm-9">
                                    <form role="form" class="" id="formbukti" method="post" type="post" enctype="multipart/form-data">
                                        <input class="form-control" name="bukti" id="form-bukti" type="file" value="" multiple style="opacity:1;"/>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="simpanbukti-btn" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('after-script')
    <script> 
        @foreach ($varJs as $varjsi)
            {!! $varjsi !!}
        @endforeach
    </script>        
    @foreach ($javascriptFiles as $file)
        <script src="{{ $file }}"></script>
    @endforeach
@endpush