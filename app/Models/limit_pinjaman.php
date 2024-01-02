<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class limit_pinjaman extends Model
{
    use HasFactory;

    protected $table = "limit_pinjaman";
    protected $fillable = ['amount', 'user_id'];
}
