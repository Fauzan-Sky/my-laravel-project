<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;  // ← tambah ini

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Paginator::useBootstrap();  // ← tambah ini
    }
}