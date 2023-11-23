<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pengadaan extends Model
{
    use HasFactory;
    protected $table = "pengadaan";
    protected $fillable = ['tanggal','no_pengadaan','request_user_id','approve_user_id','accept_user_id','id_supplier','status','total_harga'];

    public static function generateNoPengadaan($paramDate)
    {
        $prefix = 'PO';
        $paramx=Carbon::createFromFormat('Y-m-d H:i:s', $paramDate)->format('dmY');
        $date=$paramx;

        $lastBooking = Pengadaan::selectRaw("*, DATE_FORMAT(tanggal, '%d%m%Y') AS formatted_booking_date")
        ->whereRaw("DATE_FORMAT(tanggal, '%d%m%Y') = ?", [Carbon::parse($paramDate)->format('dmY')])
        ->orderBy('no_pengadaan', 'desc')
        ->first();
     
        if ($lastBooking) {
                $lastNumber = explode('/', $lastBooking->no_pengadaan);
                $lastSerial = (int)end($lastNumber);
                $newSerial = $lastSerial + 1;
          
        } else {
            $newSerial = 1;
        }
    
        $no_pengadaan = $prefix . '/' . $date . '/' . str_pad($newSerial, 5, '0', STR_PAD_LEFT);
    
        return $no_pengadaan;
    }

}


