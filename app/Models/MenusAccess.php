<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenusAccess extends Model
{
    use HasFactory;
    protected $table = "menus_access";
    protected $fillable = ['method', 'param_type', 'url', 'parameter'];
}
