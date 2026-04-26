<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total_harga',
        'catatan',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke item order
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}