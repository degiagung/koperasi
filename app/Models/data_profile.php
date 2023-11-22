<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_profile extends Model
{
    use HasFactory;
    protected $table     = "data_profile";
    protected $fillable = [
        'handphone',
        'iduser',
    ];
}
