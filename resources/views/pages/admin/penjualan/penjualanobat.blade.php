@extends('layout.default')
@push('after-style')
    @foreach ($cssFiles as $file)
        <link rel="stylesheet" href="{{ $file }}">
    @endforeach
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 order-lg-2 mb-4">
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">List Obat</span>
                                <span class="badge badge-primary badge-pill">3</span>
                            </h4>
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <h6 class="my-0">Product name</h6>
                                        <small class="text-muted">Brief description</small>
                                    </div>
                                    <span class="text-muted">$12</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between active">
                                    <div class="text-white">
                                        <h6 class="my-0 text-white">Promo code</h6>
                                        <small>EXAMPLECODE</small>
                                    </div>
                                    <span class="text-white">-$5</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total (Rp)</span>
                                    <strong>$20</strong>
                                </li>
                            </ul>

                            {{-- <form>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Promo code">
                                    <button type="submit" class="input-group-text">Redeem</button>
                                </div>
                            </form> --}}
                        </div>
                        <div class="col-lg-8 order-lg-1">
                            <h4 class="mb-3">Form Tebus Obat</h4>
                            <form class="needs-validation" novalidate="">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstName" class="form-label">Tanggal Pengadaan</label>
                                        <input type="date" class="form-control" id="firstName" placeholder="" value="" required="">
                                        {{-- <div class="invalid-feedback">
                                            Valid first name is required.
                                        </div> --}}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastName" class="form-label">No Transaksi</label>
                                        <input type="text" class="form-control" id="lastName" placeholder="" value="Otomatis"disabled>
                                        {{-- <div class="invalid-feedback">
                                            Valid last name is required.
                                        </div> --}}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Request By</label>
                                    <div class="input-group">
                                        <span class="input-group-text">@</span>
                                        <input type="text" class="form-control" id="username" placeholder="Username" required="">                                 
                                    </div>
                                </div>

                                
                                <div class="mb-3">
                                    <label class="form-label">Supplier</label>
                        
                                    <select class="default-select form-control wide w-100">
                                        <option selected="">Choose...</option>
                                        <option value="1">United States</option>
                                    </select>
                                </div>

                                <hr class="mb-4">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Pilih Obat</label>
                                        <select class="default-select form-control wide w-100">
                                            <option selected="">Choose...</option>
                                            <option value="1">United States</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="lastName" class="form-label">Qty</label>
                                        <input type="text" class="form-control" id="lastName" placeholder="" value="" required="">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button class="btn btn-primary btn-block mt-4" type="submit">Tambah Obat</button>
                                    </div>
                                </div>

                                <hr class="mb-4">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Tambah Pengadaan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-data" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="basic-form">
                        <form>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Nama Obat</label>
                                <div class="col-sm-9">
                                    <input id="form-name" type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Harga Beli</label>
                                <div class="col-sm-9">
                                    <input id="form-harga-beli" type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Harga Jual</label>
                                <div class="col-sm-9">
                                    <input id="form-harga-jual" type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Stok Minimum</label>
                                <div class="col-sm-9">
                                    <input id="form-stok-minimum" type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Satuan</label>
                                <div class="col-sm-9">
                                    <select id="form-satuan">

                                    </select>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="save-btn" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
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