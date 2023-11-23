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
                                <span class="text-muted">Total Item Obat</span>
                                <span class="badge badge-primary badge-pill item-obat-count">0</span>
                            </h4>
                            <ul class="list-group mb-3">
                                <div class="form-item-obat">
                                   
                                </div>
                                
                                {{-- <li class="list-group-item d-flex justify-content-between active">
                                    <div class="text-white">
                                        <h6 class="my-0 text-white">Promo code</h6>
                                        <small>EXAMPLECODE</small>
                                    </div>
                                    <span class="text-white">-$5</span>
                                </li> --}}
                                <div>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Total Harga (Rp)</span>
                                        <strong class="form-total-harga">0</strong>
                                    </li>
                                </div>
                            </ul>

                            {{-- <form>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Promo code">
                                    <button type="submit" class="input-group-text">Redeem</button>
                                </div>
                            </form> --}}
                        </div>
                        <div class="col-lg-8 order-lg-1">
                            <h4 class="mb-3">Form Pengadaan Obat</h4>

                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="firstName" class="form-label">Tanggal Pengadaan</label>
                                        <input type="text" class="form-control" id="form-tgl-pengadaan" placeholder="" value="" readonly>
                                        {{-- <div class="invalid-feedback">
                                            Valid first name is required.
                                        </div> --}}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastName" class="form-label">No Pengadaan</label>
                                        <input type="text" class="form-control" id="form-no-pengadaan" placeholder="" value="" readonly>
                                        {{-- <div class="invalid-feedback">
                                            Valid last name is required.
                                        </div> --}}
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="lastName" class="form-label">Status</label>
                                        <h4 id="form-status"><span class="badge bg-secondary my-1">New</span></h4>  
                                        {{-- <div class="invalid-feedback">
                                            Valid last name is required.
                                        </div> --}}
                                    </div>


                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Supplier</label>
                                    <input type="text" class="form-control" id="form-supplier" placeholder="" value="" readonly>         
                                </div>
                                <hr class="mb-3">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="username" class="form-label">Requested By</label>
                                        <input type="text" class="form-control" id="form-request" placeholder="" value="" readonly>              
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Approved By</label>
                                        <input type="text" class="form-control" id="form-approve" placeholder="" value="" readonly>    
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Accepted By</label>
                                        <input type="text" class="form-control" id="form-accept" placeholder="" value="" readonly>    
                                    </div>
                                </div>


                                <hr class="mb-4">
                                {{-- <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Pilih Obat</label>
                                        <select id="form-obat" class="form-control wide w-100">
                                        
                                        </select>      
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="lastName" class="form-label">Qty</label>
                                        <input type="text" class="form-control" id="form-qty" placeholder="" value="1" required="">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button class="btn btn-primary btn-block mt-4 add-obat">Tambah Obat</button>
                                    </div>
                                </div> --}}

                                <hr class="mb-4">
                                <button class="btn btn-primary btn-lg btn-block" id="save-btn" type="submit">Tambah Pengadaan</button>
                            
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