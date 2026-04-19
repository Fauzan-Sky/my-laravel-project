<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Penjual extends Authenticatable
{
    use Notifiable;

    protected $guard = 'penjual';

    protected $table = 'penjual';

    protected $fillable = [
        'kantin_id',
        'nama',
        'email',
        'password',
        'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password'  => 'hashed',
        'is_active' => 'boolean',
    ];

    public function kantin()
    {
        return $this->belongsTo(Kantin::class, 'kantin_id');
    }

    public function menu()
    {
        return $this->hasMany(Menu::class, 'penjual_id');
    }
}