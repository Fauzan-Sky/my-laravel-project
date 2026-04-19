<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nis',
        'nama_lengkap',
        'kelas',
        'password',
        'is_active',
        'role',
        'nomer_hp',
        'nama_kantin',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password'  => 'hashed',
        'is_active' => 'boolean',
    ];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'user_id');
    }

    public function isSiswa(): bool   { return $this->role === 'siswa'; }
    public function isPenjual(): bool { return $this->role === 'penjual'; }
    public function isAdmin(): bool   { return $this->role === 'admin'; }
}