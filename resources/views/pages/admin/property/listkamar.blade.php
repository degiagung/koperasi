@extends('layout.default')
@push('after-style')
    @foreach ($cssFiles as $file)
        <link rel="stylesheet" href="{{ $file }}">
    @endforeach
@endpush
@section('content')

    <section class="section dashboard">
        <div class="row">
            <h2>List Kamar</h2>
            <br>
            <div class="col-lg-12">
                 <div class="card-filter">
                    <label style="font-size:18px;">Filter</label>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Status Kamar</label>
                            <select id="filter-status" name="filter-status" class="select2 ">
                                <option value="">Semua Status</option>
                                <option value="1">Terisi</option>
                                <option value="2">Kosong</option>
                                <option value="3">Booking</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label>Kondisi Fasilitas</label>
                            <select id="filter-kondisi" name="filter-kondisi" class="select2 ">
                                <option value="">Semua Kondisi</option>
                                <option value="1">Baik</option>
                                <option value="2">Perbaikan</option>
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
                    <div class="card-header mt-2 flex-wrap d-flex justify-content-between divutkpmilik" style="display:none !important;">
                        {{-- <div>
                            <h4 class="card-title">List Kamar</h4>
                        </div> --}}
                        <ul class="nav nav-tabs dzm-tabs" id="myTab-4" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button type="button" id="add-btn" class="nav-link active btn-sgn">Add</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-list" class="table datatables table-bordered table-lg">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Kamar</th>
                                        <th>lantai</th>
                                        <th>Fasilitas</th>
                                        <th>Status</th>
                                        <th>Masa Kos</th>
                                        <th>Durasi</th>
                                        <th>Penghuni</th>
                                        <th>Kondisi</th>
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
                        <h5 class="modal-title">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="basic-form">
                            <div class="mb-3 row fotokamar" style-"display:none;">
                                {{-- <div class="col-sm-3 fotosampul">
                                    
                                </div> --}}
                                <div class="col-sm-3 fotolainnya">
                                    <label>Foto Lainnya</label>
                                    <img src="../template/admin/images/ttd.jpg" style="width:100px;height:50px;" alt="">
                                </div>
                                <div class="col-sm-3">
                                    <label>Foto Lainnya</label>
                                    <img src="../template/admin/images/ttd.jpg" style="width:100px;height:50px;" alt="">
                                </div>
                                <div class="col-sm-3">
                                    <label>Foto Lainnya</label>
                                    <img src="../template/admin/images/ttd.jpg" style="width:100px;height:50px;" alt="">
                                </div>
                            </div>
                            <div class="mb-3 row perbaikan" style="display:none">
                                <label class="col-sm-3 col-form-label">Perbaikan</label>
                                <div class="col-sm-9">
                                    <select class="select2add" name="states[]" multiple="multiple" id="form-fasilitas-perbaikan" name="form-fasilitas-perbaikan"> 

                                    </select>
                                </div>
                            </div>
                            <div class="divutkpmilik" style="display:none">

                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">no kamar (*)</label>
                                    <div class="col-sm-9">
                                        <input id="form-no" name="form-no" type="text" class="form-control" placeholder="No Kamar">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Lantai (*)</label>
                                    <div class="col-sm-9">
                                        <input id="form-lantai" name="form-lantai" type="number" class="form-control" placeholder="Lantai">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Tipe Kamar (*)</label>
                                    <div class="col-sm-9">
                                        <select id="form-tipekamar" name="form-tipekamar">
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Harga Sewa (*)</label>
                                    <div class="col-sm-9">
                                        <input id="form-harga" name="form-harga" type="number" class="form-control" placeholder="Harga">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Fasilitas Dari Kos (*)</label>
                                    <div class="col-sm-9">
                                        <select class="select2add" name="states[]" multiple="multiple" id="form-fasilitas" name="form-fasilitas"> 

                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Foto Sampul (*)</label>
                                    <div class="col-sm-9">
                                        <form role="form" class="" id="formsample" method="post" type="post" enctype="multipart/form-data">
                                            <input id="form-sampul" name="form-sampul" accept="image/*" type="file" class="form-control" name="foto-sampul">
                                        </form>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Foto Lainnya</label>
                                    <div class="col-sm-9">
                                        <form role="form" class="" id="formfilelainnya" method="post" type="post" enctype="multipart/form-data">
                                            <input class="form-control" name="filelainnya[]" id="form-lainnya" type="file" value="" multiple style="opacity:1;"/>
                                        </form>
                                        </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Penghuni</label>
                                    <div class="col-sm-9">
                                        <select id="form-penghuni" name="form-penghuni" class="select2add">
    
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="durasi" style="display: none">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Fasilitas Dari Penghuni</label>
                                        <div class="col-sm-9">
                                            <select class="select2add" name="states[]" multiple="multiple" id="form-fasilitas-penghuni" name="form-fasilitas">
        
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row" >
                                        <label class="col-sm-3 col-form-label">Tanggal Kos</label>
                                        <div class="col-sm-9">
                                            {{-- <input type="text" class="form-control daterange-time" name="datetimes" id="form-durasi">  --}}
                                            <input type="date" class="form-control" name="datetimes" id="form-durasi"> 
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Jml Bulan (*)</label>
                                        <div class="col-sm-9">
                                            <input id="form-bln" name="form-bln" type="number" class="form-control" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="save-btn" class="btn btn-primary">Save</button>
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