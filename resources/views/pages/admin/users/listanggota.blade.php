@extends('layout.default')
@push('after-style')
    @foreach ($cssFiles as $file)
        <link rel="stylesheet" href="{{ $file }}">
    @endforeach
@endpush
@section('content')

    <section class="section dashboard">
         <div class="row">
            <h2>List Anggota</h2>
            <br>
            <div class="col-lg-12">
                 <div class="card-filter">
                    <label style="font-size:18px;">Filter</label>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Status Login</label>
                            <select id="filter-status" name="filter-status" class="select2 ">
                                <option value="">Semua Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
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
                        <div class="col-sm-2">
                            <button type="submit" id="filter-btn" class="btn btn-sgn" style="color:#e12a2a;width:100%;height:35px;font-size:14px;margin-top: 27px;"><i class="bi bi-search" style="font-size:12px;" ></i> Cari</button>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header mt-2 flex-wrap d-flex justify-content-between">
                        {{-- <div>
                            <h4 class="card-title">List User</h4>
                        </div> --}}
                        @if ($role == 'sekertaris koperasi' || $role == 'superadmin')
                            <ul class="nav nav-tabs dzm-tabs" id="myTab-4" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button type="button" id="add-btn" class="nav-link active btn-sgn">Add</button>
                                </li>
                            </ul>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-list" class="datatables">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Anggota</th>
                                        <th>Nama Anggota</th>
                                        <th>Pangkat Anggota</th>
                                        <th>NRP Anggota</th>
                                        <th>Tgl Berdinasi</th>
                                        <th>Handphone</th>
                                        <th>Keanggotaan</th>
                                        <th>Role User</th>
                                        <th>Status Login</th>
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
                            <form id="form">
                                <div class="forbdhara">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Limit Pinjaman</label>
                                        <div class="col-sm-9">
                                            <input id="form-limit" type="text" class="form-control" placeholder="Limit Pinjaman" onkeyup="convertrp('form-limit')">
                                        </div>
                                    </div>
                                </div>
                                <div class="forsekertaris">

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Kesatuan</label>
                                        <div class="col-sm-9">
                                            <select id="form-kesatuan" name="form-kesatuan" class="select2add">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-9">
                                            <input id="form-name" type="text" class="form-control" placeholder="Nama">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Pangkat</label>
                                        <div class="col-sm-9">
                                            <input id="form-pangkat" type="text" class="form-control" placeholder="Pangkat">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">nrp</label>
                                        <div class="col-sm-9">
                                            <input id="form-nrp" type="text" class="form-control" placeholder="NRP">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <textarea id="form-alamat" class="form-control" placeholder="Alamat"></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Handphone</label>
                                        <div class="col-sm-9">
                                            <input type="number" min='0' id="form-handphone" class="form-control" placeholder="Handphone">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Tgl Dinas</label>
                                        <div class="col-sm-9">
                                            <input type="date" id="form-tgldinas" class="form-control">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Gaji</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="form-gaji" class="form-control" onkeyup="convertrp('form-gaji')">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Keanggotaan</label>
                                        <div class="col-sm-9">
                                            <select id="form-status" name="form-status" class="select2add">
                                                <option value="">Semua Status</option>
                                                <option value="1">AKTIF</option>
                                                <option value="2">PINDAH</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Password</label>
                                        <div class="col-sm-9">
                                            <input id="form-password" type="password" class="form-control" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Role</label>
                                        <div class="col-sm-9">
                                            <select id="form-role">
    
                                            </select>
                                        </div>
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
    </section>
@endsection
@push('after-script')
    <script> 
    function handleEvt(e, pid) {
    if (e.keyCode === 13) {  // where 13 is the enter button
      var v = e.target.value;
      alert('it is working:' + v);
    }
}
        @foreach ($varJs as $varjsi)
            {!! $varjsi !!}
        @endforeach
    </script>        
    @foreach ($javascriptFiles as $file)
        <script src="{{ $file }}"></script>
    @endforeach
@endpush