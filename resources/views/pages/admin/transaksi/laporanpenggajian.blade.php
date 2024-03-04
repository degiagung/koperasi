@extends('layout.default')
@push('after-style')
    @foreach ($cssFiles as $file)
        <link rel="stylesheet" href="{{ $file }}">
    @endforeach
@endpush
@section('content')
    {{-- <style>
        #table-list{
            white-space: nowrap;
        }
        .ui-datepicker-calendar {
            display: none;
        }​
    </style> --}}
    <section class="section dashboard">
         <div class="row">
            <h2>Laporan Potongan Gaji</h2>
            <br>
                <div class="col-lg-12">
                    <div class="card-filter">
                        <label style="font-size:18px;">Filter</label>
                        <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>Tanggal Transaksi</label>
                                    <input type="month" id="periode" style="text-align:center;background:#ffffff" class="form-control from_date"  placeholder = 'MMYY (202011)'>
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
                            <table id="table-list" class="table table-bordered table-striped table-lgdatatables">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NRP</th>
                                        <th>Nama Anggota</th>
                                        <th>Cicilan Pinjaman Per Bulan</th>
                                        <th>Simpanan Wajib Per Bulan</th>
                                        <th>Simpanan Sukarela Per Bulan</th>
                                        <th>Total Potongsn</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    
                                </tfoot>
                            </table>
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
                            <form>
                                <div class="mb-3 row">
                                    <label class="col-sm-5 col-form-label ">Status Pinjaman</label>
                                    <div class="col-sm-7">
                                        <select class="select2add" id="form-statuslunas">
                                            <option value="belum lunas">Belum Lunas</option>
                                            <option value="lunas">Lunas</option>
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