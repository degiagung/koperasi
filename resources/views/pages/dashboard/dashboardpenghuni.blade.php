<section class="section dashboard">
        <div class="row">
            <h2>Dashboard Monitoring Kamar</h2>
            <br>
            @if (Str::lower($role) == 'penjaga' || Str::lower($role) == 'superadmin')
                <div class="col-lg-12">
                    <div class="card-filter">
                        <label style="font-size:18px;">Filter</label>
                        <hr>
                        <div class="row">

                            <div class="col-sm-3">
                                <label>Sisa Hari Sewa</label>
                                <select id="filter-sisa" name="filter-sisa" class="select2 ">
                                    <option value="">Semua Waktu</option>
                                    <option value="<= 7"> <= 7 Hari</option>
                                    <option value="= 0"> 1 Hari</option>
                                    <option value="<= -1"> Telat</option>
                                    <option value="<= -7"> Telat >=7 Hari </option>
                                </select>
                            </div>
                            {{-- <div class="col-sm-3">
                                <label>Status Bayar</label>
                                <select id="filter-status" name="filter-status" class="select2 ">
                                    <option value="">Semua Status</option>
                                    <option value="0">Belum Bayar</option>
                                    <option value="1">Sudah Bayar</option>
                                </select>
                            </div> --}}
                            <div class="col-sm-2">
                                <button type="submit" id="filter-btn" class="btn btn-sgn" style="color:#e12a2a;width:100%;height:35px;font-size:14px;margin-top: 27px;"><i class="bi bi-search" style="font-size:12px;" ></i> Cari</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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
                                        <th>No Kamar</th>
                                        <th>lantai</th>
                                        <th>Fasilitas</th>
                                        <th>Status</th>
                                        <th>Masa Kos</th>
                                        <th>Durasi</th>
                                        <th>Penghuni</th>
                                        <th>Tagihan (Bulan)</th>
                                        <th>Tagihan (Rp)</th>
                                        <th>Status Bayar</th>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Pembayaran</h5>
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
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Jml Bulan (*)</label>
                            <div class="col-sm-9">
                                <input id="form-bln" name="form-bln" type="number" class="form-control" min="1">
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