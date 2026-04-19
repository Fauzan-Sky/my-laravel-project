<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kantin extends Model
{
    protected $table = 'kantin';

    protected $fillable = [
        'nama_kantinn', // sesuai kolom asli di DB
        'lokasi',
        'deskripsi',
        'foto',
        'status_operasional',
        'jam_buka',
        'jam_tutup',
    ];

    protected $casts = [
        'status_operasional' => 'string',
    ];

    // Accessor biar bisa pakai $kantin->nama_kantin tanpa typo
    public function getNamaKantinAttribute(): string
    {
        return $this->nama_kantinn ?? '';
    }

    public function penjual()
    {
        return $this->hasMany(Penjual::class, 'kantin_id');
    }

    public function menu()
    {
        return $this->hasMany(Menu::class, 'kantin_id');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'kantin_id');
    }
}