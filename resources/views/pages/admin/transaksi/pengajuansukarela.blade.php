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
            <h2>Simpan Sukarela</h2>
            <br>
            <div class="col-lg-12">
                 <div class="card-filter">
                    <label style="font-size:18px;">Filter</label>
                    <hr>
                        <div class="row">
                            @if ($role != 'anggota')

                                {{-- <div class="col-sm-3">
                                    <label>Status Approve</label>
                                    <select id="filter-approve" name="filter-keanggotaan" class="select2 ">
                                        <option value="">Semua Status</option>
                                        <option value="approve">Approved</option>
                                        <option value="reject">Rejected</option>
                                    </select>
                                </div> --}}
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
                                    <label>Jenis Pengajuan</label>
                                    <select id="filter-jenis" name="filter-jenis" class="select2 ">
                                        <option value="">Semua Jenis</option>
                                        <option value="manual">Transfer</option>
                                        <option value="potong gaji">Potong Dari Gaji</option>
                                    </select>
                                </div>
                            @endif
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
                        <ul class="nav nav-tabs dzm-tabs" id="myTab-4" role="tablist">
                            @if ($role == 'anggota' || $role == 'bendahara koperasi' || $role == 'superadmin')
                                @if ($role == 'anggota')
                                    <li class="nav-item" role="presentation">
                                        <button type="button" id="add-btn" class="nav-link active btn-sgn">Pengajuan Potong Dari Gaji</button>
                                    </li>
                                @endif
                                <li class="nav-item" role="presentation" style="margin-left :15px;">
                                    <button type="button" id="add-btn-manual" class="nav-link active btn-sgn">Pengajuan Transfer/Tunai</button>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table id="table-list" class="table table-bordered table-striped table-lgdatatables">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        {{-- <th>Status </th> --}}
                                        <th>Metode Pembayaran</th>
                                        <th>NRP</th>
                                        <th>Nama Anggota</th>
                                        <th>keanggotaan</th>
                                        <th>Tanggal Transaksi</th>
                                        {{-- <th>Tanggal Approve</th> --}}
                                        <th>Jumlah</th>
                                        <th>Bulan Awal</th>
                                        <th>Durasi Bulan</th>
                                        <th>Bukti Transaksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-approval" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">APPROVAL</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form">
                            <form>
                                <div class="mb-3 row">
                                    <label class="col-sm-5 col-form-label ">Status Approval</label>
                                    <div class="col-sm-7">
                                        <select class="select2add" id="form-statusapprove">
                                            <option value="approve">Approved</option>
                                            <option value="reject">Rejected</option>
                                        </select>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sgn light" onClick="approval() ">Simpan</button>
                    </div>
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

        <div class="modal fade" id="modal-data" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">Potong Dari Gaji</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form">
                            <form id="form">
                                
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Simpanan Sukarela </label>
                                    <div class="col-sm-9">
                                        <input id="form-simpanan" type="text" class="form-control" onkeyup="convertrp('form-simpanan')">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Bulan Mulai</label>
                                    <div class="col-sm-9">
                                        <input id="form-bulan" type="month" class="form-control" min="{{ date('Y-m'); }}">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Jumlah Bulan</label>
                                    <div class="col-sm-9">
                                        <input id="form-durasi" type="number" min='1' class="form-control">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="ajukan-btn" class="btn btn-primary">Ajukan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-data-manual" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">Transfer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form">
                                
                            <div class="mb-3 row divnabung">
                                <label class="col-sm-3 col-form-label">Anggota </label>
                                <div class="col-sm-9">
                                    <select id="form-anggota"class="form-control" >
                                        <option value="">Pilih Anggota</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Simpanan Sukarela </label>
                                <div class="col-sm-9">
                                    <input id="form-simpananmanual" type="text" class="form-control" onkeyup="convertrp('form-simpananmanual')">
                                </div>
                            </div>
                                <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Bukti Transaksi</label>
                                <div class="col-sm-9">
                                    <form role="form" class="" id="formbuktimanual" method="post" type="post" enctype="multipart/form-data">
                                        <input class="form-control" name="buktimanual" id="form-buktimanual" type="file" value="" multiple style="opacity:1;"/>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="ajukanmanual-btn" class="btn btn-primary">Ajukan</button>
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