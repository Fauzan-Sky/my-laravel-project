<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// ══════════════════════════════════════════════════════════
//  Kantin
// ══════════════════════════════════════════════════════════
class Kantin extends Model
{
    protected $table = 'kantin';

    protected $fillable = [
        'nama_kantin', 'lokasi', 'deskripsi', 'foto',
        'status_operasional', 'jam_buka', 'jam_tutup',
    ];

    protected $casts = [
        'jam_buka'   => 'string',
        'jam_tutup'  => 'string',
    ];

    public function penjual()
    {
        return $this->hasMany(Penjual::class, 'kantin_id');
    }

    public function menu()
    {
        return $this->hasMany(Menu::class, 'kantin_id');
    }

    public function slotWaktu()
    {
        return $this->hasMany(SlotWaktu::class, 'kantin_id');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'kantin_id');
    }

    public function isOpen(): bool
    {
        return $this->status_operasional === 'buka';
    }
}


// ══════════════════════════════════════════════════════════
//  Menu
// ══════════════════════════════════════════════════════════
class Menu extends Model
{
    protected $table = 'menu';

    protected $fillable = [
        'kantin_id', 'penjual_id', 'nama_menu', 'deskripsi',
        'harga', 'stok', 'kategori', 'foto', 'is_available',
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
}


// ══════════════════════════════════════════════════════════
//  SlotWaktu
// ══════════════════════════════════════════════════════════
class SlotWaktu extends Model
{
    protected $table = 'slot_waktu';

    protected $fillable = [
        'kantin_id', 'label_slot', 'jam_mulai',
        'jam_selesai', 'kapasitas_maks', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function kantin()
    {
        return $this->belongsTo(Kantin::class, 'kantin_id');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'slot_id');
    }

    public function slotBooking()
    {
        return $this->hasMany(SlotBooking::class, 'slot_id');
    }

    /** Cek apakah slot masih tersedia untuk tanggal tertentu */
    public function isFull(string $tanggal): bool
    {
        $terpakai = $this->slotBooking()
            ->where('tanggal', $tanggal)
            ->sum('jumlah_terpakai');

        return $terpakai >= $this->kapasitas_maks;
    }
}


// ══════════════════════════════════════════════════════════
//  Pesanan
// ══════════════════════════════════════════════════════════
class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'user_id', 'kantin_id', 'slot_id', 'nomor_antrean',
        'status', 'total_harga', 'catatan', 'tanggal_pesan', 'waktu_diambil',
    ];

    protected $casts = [
        'total_harga'   => 'decimal:2',
        'tanggal_pesan' => 'datetime',
        'waktu_diambil' => 'datetime',
    ];

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

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    public function slotBooking()
    {
        return $this->hasOne(SlotBooking::class, 'pesanan_id');
    }

    /** Generate nomor antrean berikutnya untuk kantin + slot + hari ini */
    public static function nextNomorAntrean(int $kantinId, int $slotId): int
    {
        $today = now()->toDateString();
        $last  = static::where('kantin_id', $kantinId)
            ->where('slot_id', $slotId)
            ->whereDate('tanggal_pesan', $today)
            ->max('nomor_antrean');

        return ($last ?? 0) + 1;
    }
}


// ══════════════════════════════════════════════════════════
//  DetailPesanan
// ══════════════════════════════════════════════════════════
class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';

    protected $fillable = [
        'pesanan_id', 'menu_id', 'jumlah',
        'harga_satuan', 'subtotal', 'catatan_item',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal'     => 'decimal:2',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}


// ══════════════════════════════════════════════════════════
//  SlotBooking
// ══════════════════════════════════════════════════════════
class SlotBooking extends Model
{
    protected $table = 'slot_booking';

    protected $fillable = [
        'slot_id', 'pesanan_id', 'tanggal', 'jumlah_terpakai',
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