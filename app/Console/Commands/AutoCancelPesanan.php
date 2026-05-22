<?php

namespace App\Console\Commands;

use App\Models\Pesanan;
use Illuminate\Console\Command;

class AutoCancelPesanan extends Command
{
    protected $signature = 'pesanan:auto-cancel';
    protected $description = 'Auto-cancel pesanan ready yang sudah melewati deadline_ambil (15 menit)';

    public function handle()
    {
        $expired = Pesanan::where('status', 'ready')
            ->whereNotNull('deadline_ambil')
            ->where('deadline_ambil', '<', now())
            ->get();

        $count = $expired->count();

        foreach ($expired as $pesanan) {
            $pesanan->update(['status' => 'cancelled']);
            $this->info("Pesanan #{$pesanan->id} (Antrean: {$pesanan->nomor_antrean}) → cancelled");
        }

        $this->info("Selesai. {$count} pesanan di-cancel.");

        return Command::SUCCESS;
    }
}