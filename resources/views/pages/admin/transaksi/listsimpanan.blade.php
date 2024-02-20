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
            <h2>Simpanan Anggota</h2>
            <br>
            <div class="col-lg-12">
                 <div class="card-filter">
                    <label style="font-size:18px;">Filter</label>
                    <hr>
                        <div class="row">
                            
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
        </div><Simpanan Anggota
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header mt-2 flex-wrap d-flex justify-content-between">
                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            {{-- @if ($role == 'anggota')
                                <table id="table-list" class="datatables">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tgl Transaksi</th>
                                            <th>Nominal</th>
                                            <th>Keterangan</th>
                                            <th>Bukti Transaksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            @else --}}
                                <table id="table-list" class="table table-bordered datatables">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NRP</th>
                                            <th>Nama Anggota</th>
                                            <th>Tanggal Dinas</th>
                                            <th>keanggotaan</th>
                                            <th>Simpanan Pokok</th>
                                            <th>Simpanan Wajib</th>
                                            <th>Simpanan Sukarela</th>
                                            <th>Total Simpan</th>
                                            <th>Penarikan</th>
                                            <th>Saldo</th>
                                            {{-- <th>Bukti</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            {{-- @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-data" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">Data View</h5>
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
                                    <label class="col-sm-3 col-form-label">Simpanan Wajib</label>
                                    <div class="col-sm-9">
                                        <input readonly id="form-smwajib" type="text" class="form-control" >
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Simpanan Pokok</label>
                                    <div class="col-sm-9">
                                        <input readonly id="form-smpokok" type="text" class="form-control" >
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Penarikan</label>
                                    <div class="col-sm-9">
                                        <input readonly id="form-tarik" type="text" class="form-control" >
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Tgl Penarikan Terakhir</label>
                                    <div class="col-sm-9">
                                        <input readonly id="form-tgltarik" type="text" class="form-control" >
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Saldo Akhir</label>
                                    <div class="col-sm-9">
                                        <input readonly id="form-saldo" type="text" class="form-control" >
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
        <div class="modal fade" id="modal-detail-sukarela" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">Detail Sukarela</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="table-detail-sukarela" class="table table-bordered table-striped table-lgdatatables">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis</th>
                                    <th>Nominal</th>
                                    <th>tgl Transaksi</th>
                                    <th>tgl awal potong gaji</th>
                                    <th>durasi potong gaji</th>
                                    <th>Nota</th>
                                </tr>
                            </thead>
                            {{-- <tfoot>
                                <td>Total</td>
                                <td class="totaldetailsimpanan"></td>
                                <td></td>
                            </tfoot> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-detail" style="display: none;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">Bukti Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="table-list" class="table table-bordered table-striped datatables">
                            <thead>
                                <tr>
                                    <th>Tgl Transaksi</th>
                                    <th>Simpanan Ke</th>
                                    <th>Nominal</th>
                                    <th>Bukti</th>
                                    <th>Nota</th>
                                </tr>
                            </thead>
                            <tbody id="detailbukti">

                            </tbody>
                            <tfoot>
                                <td>Total</td>
                                <td class="totalbukti"></td>
                                <td></td>
                            </tfoot>
                        </table>
                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sgn light" onClick="approval() ">Simpan</button>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-bukti" style="display: none;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">Bukti Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <button type="submit" onclick="showbill('pokok')">Lihat Nota</button>
                        </center><br>
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
        <div class="modal fade modal-upload" id="modal-upload" style="display: none;" aria-hidden="true">
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
        <div class="modal fade" id="modal-bill">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">NOTA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="divbill">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btndownloadsert">Download PDF</button>
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