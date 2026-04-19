<?php

// ══════════════════════════════════════════════════════════
//  FILE: config/auth.php
//  Tambahkan guards & providers berikut ke file auth.php
//  yang sudah ada di project Laravel kamu.
// ══════════════════════════════════════════════════════════

return [

    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        // Guard default — untuk Siswa
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        // Guard untuk Penjual
        'penjual' => [
            'driver'   => 'session',
            'provider' => 'penjual',
        ],

        // Guard untuk Admin
        'admin' => [
            'driver'   => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        // Provider Siswa
        'users' => [
            'driver' => 'eloquent',
            'model'  => App\Models\User::class,
        ],

        // Provider Penjual
        'penjual' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Penjual::class,
        ],

        // Provider Admin
        'admins' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
        'penjual' => [
            'provider' => 'penjual',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
        'admins' => [
            'provider' => 'admins',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];