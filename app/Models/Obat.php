<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;
    protected $table = "obat";
    protected $fillable = ['nama_obat','id_satuan','harga_beli' ,'harga_jual' ,'stok','min_stok'];
}
