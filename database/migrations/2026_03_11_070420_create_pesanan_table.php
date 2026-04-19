<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kantin_id')->constrained('kantin')->onDelete('cascade');
            $table->foreignId('slot_id')->constrained('slot_waktu')->onDelete('cascade');
            $table->integer('nomor_antrean');
            $table->enum('status', ['pending', 'processing', 'ready', 'picked'])->default('pending');
            $table->decimal('total_harga', 10, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_pesan')->useCurrent();
            $table->timestamp('waktu_diambil')->nullable();
            $table->timestamps();

            // Nomor antrean unik per kantin per slot per hari
            $table->unique(['kantin_id', 'slot_id', 'nomor_antrean', 'tanggal_pesan'], 'unique_antrean');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
