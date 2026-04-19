<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlotBooking extends Model
{
    protected $table = 'slot_booking';

    protected $fillable = [
        'slot_id',
        'pesanan_id',
        'tanggal',
        'jumlah_terpakai',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function slot()
    {
        return $this->belongsTo(SlotWaktu::class, 'slot_id');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}