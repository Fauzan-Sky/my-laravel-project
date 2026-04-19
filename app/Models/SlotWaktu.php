<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SlotWaktu extends Model
{
    protected $table = 'slot_waktu';

    protected $fillable = [
        'label_slot',
        'jam_mulai',
        'jam_selesai',
        'quota',
        'booked_count',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'slot_id');
    }

    public function slotBooking()
    {
        return $this->hasMany(SlotBooking::class, 'slot_id');
    }

    // Sisa kuota
    public function getSisaKuotaAttribute(): int
    {
        return $this->quota - $this->booked_count;
    }

    // Status real-time
    public function getStatusAttribute(): string
    {
        $now = Carbon::now()->format('H:i:s');
        if (!$this->is_active)              return 'nonaktif';
        if ($now < $this->jam_mulai)        return 'menunggu';
        if ($now > $this->jam_selesai)      return 'selesai';
        if ($this->booked_count >= $this->quota) return 'penuh';
        return 'berlangsung';
    }

    // Badge untuk view
    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'berlangsung' => ['label' => 'Berlangsung', 'class' => 'badge-success'],
            'menunggu'    => ['label' => 'Menunggu',    'class' => 'badge-info'],
            'penuh'       => ['label' => 'Penuh',       'class' => 'badge-danger'],
            'selesai'     => ['label' => 'Selesai',     'class' => 'badge-gray'],
            default       => ['label' => 'Nonaktif',    'class' => 'badge-gray'],
        };
    }
}