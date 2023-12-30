@extends('layout.default')
@push('after-style')
    @foreach ($cssFiles as $file)
        <link rel="stylesheet" href="{{ $file }}">
    @endforeach
@endpush
@section('content')
    <style>
        .bill{
            border: 2px solid black;
            font-size: 10px;
        }
        th{
            font-weight: 500 !important;
        }
        .bold{
            font-weight: bold !important;
        }
    </style>
    <section class="section dashboard">
        <div class="row">
            <h2>List Transaksi</h2>
            <br>
            
        </div><br>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-list" class="datatables">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Penghuni</th>
                                        <th>Handphone</th>
                                        <th>No Kamar</th>
                                        <th>Fasilitas</th>
                                        <th>Fasilitas Tambahan</th>
                                        <th>Masa Kos</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Nota</th>
                                        <th>Action</th>
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

        <div class="modal fade" id="modal-bill">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Nota</h5>
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
        <div class="modal fade" id="modal-update">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Status Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Bukti Transaksi</label>
                            <div class="col-sm-9">
                                <form role="form" class="" id="formbukti" method="post" type="post" enctype="multipart/form-data">
                                    <input id="form-bukti" name="form-bukti" accept="image/*" type="file" class="form-control">
                                </form>
                            </div>
                        </div>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-update">Simpan Bukti</button>
                </div>
                </div>
            </div>
        </div>
    <section
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


