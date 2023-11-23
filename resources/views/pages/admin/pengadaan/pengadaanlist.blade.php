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
                <div class="card-header mt-2 flex-wrap d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">Pengadaan</h4>
                        {{-- <p class="m-0 subtitle">Add <code>Patient</code> class with <code>datatables</code></p> --}}
                    </div>
                    <ul class="nav nav-tabs dzm-tabs" id="myTab-4" role="tablist">
                        {{-- <li class="nav-item" role="presentation">
                            <button type="button" id="add-btn" class="nav-link active">Add</button>
                        </li> --}}
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link " id="profile-tab-4" data-bs-toggle="tab"
                                data-bs-target="#leftPosition-html" type="button" role="tab" aria-selected="false"
                                tabindex="-1">HTML</button>
                        </li> --}}
                    </ul>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-list" class="datatables">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No Pengadaan</th>
                                    <th>Nama Request User</th>
                                    <th>Nama Supplier</th>
                                    <th>Status</th>
                                    <th>Total Harga</th>
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