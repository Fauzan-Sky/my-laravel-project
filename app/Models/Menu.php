<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    protected $fillable = [
        'kantin_id',
        'penjual_id',
        'nama_menu',
        'deskripsi',
        'harga',
        'stok',
        'kategori',
        'foto',
        'is_available',
    ];

    protected $casts = [
        'harga'        => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function kantin()
    {
        return $this->belongsTo(Kantin::class, 'kantin_id');
    }

    public function penjual()
    {
        return $this->belongsTo(Penjual::class, 'penjual_id');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'menu_id');
    }

    public function getIsStokKritisAttribute(): bool
    {
        return $this->stok <= 5;
    }
}