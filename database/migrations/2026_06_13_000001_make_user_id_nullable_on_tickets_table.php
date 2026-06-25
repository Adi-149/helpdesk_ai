<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Mengubah kolom user_id pada tabel tickets menjadi nullable
     * agar riwayat tiket tetap tersimpan saat user dihapus.
     */
    public function up(): void
    {
        $isSqlite = Schema::getConnection()->getDriverName() === 'sqlite';
        if ($isSqlite) {
            return;
        }

        Schema::table('tickets', function (Blueprint $table) {
            // Drop foreign key constraint lama
            $table->dropForeign(['user_id']);

            // Ubah kolom menjadi nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();

            // Buat ulang foreign key constraint dengan SET NULL
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $isSqlite = Schema::getConnection()->getDriverName() === 'sqlite';
        if ($isSqlite) {
            return;
        }

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->unsignedBigInteger('user_id')->nullable(false)->change();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }
};
