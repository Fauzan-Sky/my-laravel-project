<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('slot_waktu', function (Blueprint $table) {
            if (!Schema::hasColumn('slot_waktu', 'kantin_id')) {
                $table->unsignedBigInteger('kantin_id')->nullable()->after('id');
                $table->foreign('kantin_id')
                    ->references('id')
                    ->on('kantin')  // ← ganti ke 'kantin' singular
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('slot_waktu', function (Blueprint $table) {
            if (Schema::hasColumn('slot_waktu', 'kantin_id')) {
                $table->dropForeign(['kantin_id']);
                $table->dropColumn('kantin_id');
            }
        });
    }
};