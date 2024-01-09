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
                                <label>Status Keanggotaan</label>
                                <select id="filter-keanggotaan" name="filter-keanggotaan" class="select2 ">
                                    <option value="">Semua Kondisi</option>
                                    <option value="<= current_date and us.status != '2'">AKTIF</option>
                                    <option value="> current_date">PENSIUN</option>
                                    <option value="pindah">PINDAH</option>
                                </select>
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
                            <table id="table-list" class="datatables">
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