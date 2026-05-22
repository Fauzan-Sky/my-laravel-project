<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'kantin_id',
        'slot_id',
        'nomor_antrean',
        'status',
        'total_harga',
        'catatan',
        'tanggal_pesan',
        'waktu_diambil',
        'deadline_ambil', // ✅ Tambah ini
    ];

    protected $casts = [
        'total_harga'   => 'decimal:2',
        'tanggal_pesan' => 'datetime',
        'waktu_diambil' => 'datetime',
        'deadline_ambil' => 'datetime', // ✅ Tambah ini
    ];

    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'pending'    => ['label' => 'Menunggu',   'class' => 'badge-warning'],
            'processing' => ['label' => 'Diproses',   'class' => 'badge-info'],
            'ready'      => ['label' => 'Siap Ambil', 'class' => 'badge-success'],
            'picked'     => ['label' => 'Selesai',    'class' => 'badge-gray'],
            default      => ['label' => 'Batal',      'class' => 'badge-danger'],
        };
    }

    // ✅ Tambah helper method
    public function isExpired(): bool
    {
        return $this->deadline_ambil && now()->greaterThan($this->deadline_ambil);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kantin()
    {
        return $this->belongsTo(Kantin::class, 'kantin_id');
    }

    public function slot()
    {
        return $this->belongsTo(SlotWaktu::class, 'slot_id');
    }

    public function detail()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    public function slotBooking()
    {
        return $this->hasOne(SlotBooking::class, 'pesanan_id');
    }
}