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
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->foreignId('menu_id')->constrained('menu')->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->decimal('harga_satuan', 10, 2);        // snapshot harga saat pesan
            $table->decimal('subtotal', 10, 2);
            $table->text('catatan_item')->nullable();
            $table->timestamps();
        });

        Schema::create('slot_booking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slot_id')->constrained('slot_waktu')->onDelete('cascade');
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('jumlah_terpakai')->default(1);
            $table->timestamps();

            $table->unique(['slot_id', 'pesanan_id', 'tanggal'], 'unique_slot_booking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot_booking');
        Schema::dropIfExists('detail_pesanan');
    }
};
