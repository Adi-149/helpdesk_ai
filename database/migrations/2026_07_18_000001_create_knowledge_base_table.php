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
        Schema::create('knowledge_base', function (Blueprint $table) {
            $table->id();
            $table->enum('category', [
                'wifi', 'lokasi', 'perangkat', 'sop', 'faq',
                'kontak', 'unit_usaha', 'pendidikan', 'server', 'jaringan'
            ]);
            $table->string('title', 255);
            $table->text('keywords');
            $table->longText('content');
            $table->enum('access_level', ['user', 'teknisi', 'admin'])->default('user');
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('category');
            $table->index('access_level');
            $table->index('is_active');
            $table->fullText(['title', 'keywords', 'content']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_base');
    }
};
