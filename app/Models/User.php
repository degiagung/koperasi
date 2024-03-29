<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'handphone',
        'password',
        'role_id',
        'is_active',
        'no_anggota',
        'pangkat',
        'nrp',
        'alamat',
        'handphone',
        'norek',
        'pemilik_rekening',
        'tgl_dinas',
        'gaji',
        'kesatuan',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('role_name', $roles)->exists();
    }
    
    public function roles()
    {
        return $this->hasMany(UsersRole::class, 'id', 'role_id');
    }
}
