<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kantin extends Model
{
    use HasFactory;

    protected $table = 'kantin';

    protected $fillable = [
        'nama_kantinn',
        'lokasi',
        'deskripsi',
        'foto',
        'status_operasional',
        'jam_buka',
        'jam_tutup',
    ];

    protected $casts = [
        'status_operasional' => 'string',
        'jam_buka'           => 'string',
        'jam_tutup'          => 'string',
    ];

    protected $attributes = [
        'status_operasional' => 'buka',
    ];

    // Accessor: $kantin->nama_kantin (tanpa double n)
    public function getNamaKantinAttribute(): string
    {
        return $this->nama_kantinn ?? '';
    }

    // Accessor: $kantin->status_label → "Buka" / "Tutup"
    public function getStatusLabelAttribute(): string
    {
        return $this->status_operasional === 'buka' ? 'Buka' : 'Tutup';
    }

    // Accessor: $kantin->is_open → true/false
    public function getIsOpenAttribute(): bool
    {
        return $this->status_operasional === 'buka';
    }

    // Relasi
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