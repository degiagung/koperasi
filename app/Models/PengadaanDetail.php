<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PengadaanDetail extends Model
{
    use HasFactory;
    protected $table = "pengadaan_detail";
    protected $fillable = ['id_pengadaan','id_obat','qty_request','qty_terima','harga_item'];


}


