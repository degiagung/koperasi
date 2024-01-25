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
            <h2>Pengajuan Pinjaman</h2>
            <br>
            @if ($role != 'anggota')
            <div class="col-lg-12">
                 <div class="card-filter">
                    <label style="font-size:18px;">Filter</label>
                    <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <label>Status Approve</label>
                                <select id="filter-approve" name="filter-keanggotaan" class="select2 ">
                                    <option value="">Semua Status</option>
                                    <option value="approve">Approved</option>
                                    <option value="reject">Rejected</option>
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
                    <hr>
                    <h5><b style="color:red;">UNTUK PENGAJUAN YANG TELAH DI SETUJUI ,SILAHKAN MENGHUBUNGI PIHAK KOPERASI UNTUK PENANDATANGANAN BERKAS DAN TRANSFER</b></h5>
                </div>
            </div>
            @endif
        </div><br>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header mt-2 flex-wrap d-flex justify-content-between">
                        <ul class="nav nav-tabs dzm-tabs" id="myTab-4" role="tablist">
                            @if ($role == 'anggota') 
                            <li class="nav-item" role="presentation">
                                <button type="button" id="add-btn" class="nav-link active btn-sgn">Ajukan</button>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-list" class="table table-bordered table-striped table-lgdatatables">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Status </th>
                                        <th>NRP</th>
                                        <th>Nama Anggota</th>
                                        <th>Tanggal Approve</th>
                                        <th>keanggotaan</th>
                                        <th>Total Limit</th>
                                        <th>Pengajuan Tenor & Pinjaman</th>
                                        <th>Total Pembayaran</th>
                                        <th>Sisa Limit</th>
                                        <th>Sisa Tenor & Pinjaman</th>
                                        <th>Surat Pengajuan</th>
                                        <th>Surat Perjanjian</th>
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
        <div class="modal fade" id="modal-approval" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">APPROVAL PINJAMAN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form">
                            <form>
                                <div class="mb-3 row">
                                    <label class="col-sm-5 col-form-label ">Status Approval</label>
                                    <div class="col-sm-7">
                                        <select class="select2add" id="form-statusapprove">
                                            <option value="approve">Approved</option>
                                            <option value="reject">Rejected</option>
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

        <div  id="modal-pengajuan" class="modal fade" style="overflow: scroll;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="panel-body" style="display:block;">
                            <div class="row">
                                
                                <div class="col-md-12" style="padding-bottom: 10px;">
                                    <div class="row">
                                        <div class="col-md-6" style="">
                                            <label>Tempat</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control tempatinput">
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="">
                                            <label>Tanggal</label>
                                            <div class="form-group">
                                                <input type="date" class="form-control tanggalinput">
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        
                        <div class="panel-body" id="print" style="display:block;padding-left: 200px;font-size: 4mm;padding-bottom: 150px;">
                            <h2><p style="text-align:center;font-weight: bold;font-size: 5mm;">
                                PRIMKOPAU GEMI MAKMUR<br>
                                BADAN HUKUM NOMOR 8020/BH/PAD/518-KOP/XII/2000<br>
                                JLN MUSTANG LANUD SULAIMAN BANDUNG <br>
                            </h2>

                            <div style="font-size: 4mm;">
                                <hr style="height:1mm;border:none;color:#333;background-color:#333;"/>
                                <br>
                                <p style="font-size: 4mm;">Yang bertanda tangan di bawah ini :</p>

                                <p style="margin-left: 15mm;padding: 10px;font-size: 4mm;">
                                Nama&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;: <b class="nama"></b><br>
                                No Anggota&emsp;&emsp;&emsp;&nbsp;  : <b class="noanggota"></b><br>
                                Pangkat/NRP&emsp;&emsp;&nbsp;&nbsp;&nbsp;  : <b class="pangkat"></b><br>
                                </p>

                                <p style="font-size: 4mm;"> Dengan ini mengajukan permohonan pinjaman uang dari PRIMKOPAU GEMI MAKMUR sebesar Rp  <b class="pinjaman"> </b><br>
                                <p style="font-size: 4mm;"> Keperluan : <b class="keperluan"> Pendidikan</b><br>
                                <p style="font-size: 4mm;"> Pinjaman akan saya lunasi dalam jangka : <b class="tenor"> 5 Bln</b><br>
                                <p style="font-size: 4mm;"> Demikian permohonan pinjaman yang saya ajukan, dengan harapan mendapatkan keputusan dari* PENGURUS *<br>
                                

                                <br><br>
                                <p style="font-size: 4mm;text-align:right;"><b class="tempattanggal"> </b></p><br><br>

                                <table style="width: 100%;font-size: 4mm;">
                                <table style="width: 100%;font-size: 4mm;">
                                    <tbody>
                                        <tr>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;">Mengetahui : </td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;">Mengetahui Istri/Suami</td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;">Pemohon</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;">Dansat/Kepala</td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"><u >Suhandono</u></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"><u >----------------</u></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"><u  class="nama">Handi Test</u></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;">Letdapas Nrp 526154</td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;" class="pangkatttd"></td>
                                        </tr>
                                    </tbody>

                                </table>

                                <br><br>
                                <p style="font-size: 4mm;"> Catatan untuk pengurus<br>
                                <p style="font-size: 4mm;"> Sisa pinjaman<br>
                                <p style="font-size: 4mm;text-align:center;"><b>PERTIMBANGAN PENGURUS</b></p><br><br>
                                
                                <p style="font-size: 4mm;"> Dengan ini kami Pengurus PRIMKOPAU GEMI MAKMUR<br>
                                <p style="font-size: 4mm;"> Mengabulkan / menangguhkan permohonan pinjaman tersebut diatas sebesar Rp <b class="pinjaman"> </b><br><br>
                                
                                
                                <p style="font-size: 4mm;"> Dengan ketentuan sebagai berikut :<br>
                                <p style="font-size: 4mm;"> 1. Simpanan angsuran dan jasa pinjaman dipotong gaji / non gaji<br>
                                <p style="font-size: 4mm;"> 2. Apabila tidak mengangsur sebanyak satu kali akan dikenakan denda 1 % dari saldo / sisa pinjaman<br>
                                <p style="font-size: 4mm;"> 3. Lampirkan Stroke gaji terakhir.<br><br>
                                <p style="font-size: 4mm;"> Kepada Bendahara mohon untuk penyelesaian<br>
                                
                                <p style="font-size: 4mm;text-align:right;"><b class="tempattanggal"></b></p><br><br>

                                <table style="width: 100%;font-size: 4mm;">
                                <table style="width: 100%;font-size: 4mm;">
                                    <tbody>
                                        <tr>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;">Mengetahui : </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;">Ka USP</td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;">an Pengurus Primkopau Gemi Makmur</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;">Ketua</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"><u >Neng MulyanMuryati</u></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"><u ></u></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"><u >Agung EP</u></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;">(NA. 1031)</td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;">(NA. 1640)</td>
                                        </tr>
                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="printDiv('print','Title')" class="btn btn-sgn" data-dismiss="modal" style="width: 10%;">Print</button>
                        <button type="button" class="btn btn-sgn" data-bs-dismiss="modal" style="width: 10%;">Back</button>
                    </div>
                </div>
            </div>
        </div>

        <div  id="modal-perjanjian" class="modal fade" style="overflow: scroll;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="panel-body" style="display:block;">
                            <div class="row">
                                
                                <div class="col-md-12" style="padding-bottom: 10px;">
                                    <div class="row">
                                        <div class="col-md-6" style="">
                                            <label>Tempat</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control pengajuantempatinput">
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="">
                                            <label>Tanggal</label>
                                            <div class="form-group">
                                                <input type="date" class="form-control pengajuantanggalinput">
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        
                        <div class="panel-body" id="print" style="display:block;padding-left: 200px;font-size: 4mm;padding-bottom: 150px;">
                            <h2><p style="text-align:center;font-weight: bold;font-size: 5mm;">
                                PRIMKOPAU GEMI MAKMUR<br>
                                BADAN HUKUM NOMOR 8020/BH/PAD/518-KOP/XII/2000<br>
                                JLN MUSTANG LANUD SULAIMAN BANDUNG <br>
                            </h2>

                            <div style="font-size: 4mm;">
                                <hr style="height:1mm;border:none;color:#333;background-color:#333;"/>
                                <br>
                                <p style="font-size: 7mm;text-align:center;"><b><u >SURAT PERJANJIAN PINJAMAN</U></b></p>
                                <p style="font-size: 4mm;text-align:center;">Nomor : SPP/&emsp;&emsp;/&emsp;&emsp;/20&emsp;&emsp;/KOPERASI</p>
                                
                                <p style="font-size: 4mm;">Yang bertanda tangan di bawah ini :</p>
                                <p style="font-size: 4mm;">
                                1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama /Pkt/Nrp : <b class="pengajuannama"></b><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sebagai Bendahara bertindak dan untuk atas nama "Primkopau Gemi Makmur" disebut sebagai pihak kesatu
                                </p>
                                <p style="font-size: 4mm;">
                                2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama /Pkt/Nrp : <b class="pengajuannama"></b><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Disebut sebagai pihak kedua.
                                </p>

                                <p style="font-size: 4mm;text-align:center;"><u>Pasal 1</u></p>
                                <p style="font-size: 4mm;">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pihak kedua mengaku bahwa perjanjian pinjaman ini sebagai tanda penerimaan pinjaman dari pihak kesatu atas.<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;dasar terkabulnya permohonan pinjaman barupa uang sebesar Rp.<b class="pengajuanpinjaman"></b><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;sanggup mengembalikan dalam jangka waktu <b class="pengajuantenor"> </b>bulan dengan jasa <b>2%</b> menurun dari sisa pinjaman.<br>
                                </p>

                                <p style="font-size: 4mm;text-align:center;"><u>Pasal 2</u></p>
                                <p style="font-size: 4mm;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pihak kedua memberikan jaminan berupa</p>
                                <p style="font-size: 4mm;">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sanggup dipotong gaji setiap bulan.<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Simpanan dikoperasi sebesar Rp <b class="pengajuanbayarsimpanan"></b><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Surat-surat berharga lainnya.<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;d.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Apabalia pindah tugas/mutasi. Sanggup melunasi pinjaman nya.<br>
                                </p>

                                <p style="font-size: 4mm;text-align:center;"><u>Pasal 4</u></p>
                                <p style="font-size: 4mm;">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Perjanjian ini berlaku sejak ditanda tangani bersama sampai dengan lunas pinjaman.</p>
                                </p>
                                
                                <p style="font-size: 4mm;text-align:center;padding-left:350px;"><b class="pengajuatempattanggal"></b></p><br><br>

                                <table style="width: 100%;font-size: 4mm;">
                                <table style="width: 100%;font-size: 4mm;">
                                    <tbody>
                                        <tr>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;">PIHAK KEDUA</td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;">PIHAK KESATU</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                            <td style="border: 1px solid #dddddd00 !important;"><br></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"><u ><b class="pengajuannama"></b></u></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"><u ></u></td>
                                            <td style="text-align:center;font-weight:bold;border: 1px solid #dddddd00 !important;"><u ><b>Mu'ti Azis</b></u></td>
                                        </tr>
                                    </tbody>

                                </table><br>
                                <p style="font-size: 4mm;">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telah dicatat dan dibayarkan<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pada Tanggal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b class="pengajuatempattanggal"></b><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Uang Sebesar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b class="pengajuanpinjaman"></b><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provisi&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 1% <b class="pengajuanprovisi"></b><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Materai&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b class="">Rp.10.000</b><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diterima&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b class="pengajuanditerima"></b><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Terbilang&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b class="pengajuanterbilang"></b><br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="printDiv('print','Title')" class="btn btn-sgn" data-dismiss="modal" style="width: 10%;">Print</button>
                        <button type="button" class="btn btn-sgn" data-bs-dismiss="modal" style="width: 10%;">Back</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-data" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">Pengajuan Pinjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form">
                            <form id="form">
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Limit Pinjaman </label>
                                    <div class="col-sm-9">
                                        <input id="form-limit" type="text" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Bunga Pinjaman </label>
                                    <div class="col-sm-9">
                                        <input id="form-bunga" type="text" class="form-control" readonly value="2% dari total pinjaman">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Jumlah Pinjaman </label>
                                    <div class="col-sm-9">
                                        <input id="form-pinjaman" type="text" class="form-control" onkeyup="convertrp('form-pinjaman')">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Tenor</label>
                                    <div class="col-sm-9">
                                        <select id="form-tenor" name="form-tenor" class="select2add">
                                            <option value="" disabled>Pilih Tenor</option>
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="12">12</option>
                                            <option value="20">20</option>
                                            <option value="24">24</option>
                                            <option value="36">36</option>
                                            <option value="48">48</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Keperluan</label>
                                    <div class="col-sm-9">
                                        <select id="form-keperluan" name="form-keperluan" class="select2add1">
                                            <option value="" disabled>Pilih Keperluan</option>
                                            <option value="pendidikan">Pendidikan</option>
                                            <option value="kesejahteraan">Kesejahteraan</option>
                                            <option value="produktif">Produktif</option>
                                            <option value=lain-lain">Lain-lain</option>
                                        </select>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="ajukan-btn" class="btn btn-primary">Ajukan</button>
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