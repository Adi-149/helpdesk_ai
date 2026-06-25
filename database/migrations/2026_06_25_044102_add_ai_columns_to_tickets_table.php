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
        Schema::table('tickets', function (Blueprint $table) {
            $table->text('ai_summary')->nullable();
            $table->text('ai_causes')->nullable();
            $table->text('ai_recommendations')->nullable();
            $table->string('ai_confidence')->nullable();
            $table->text('resolution_summary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'ai_summary',
                'ai_causes',
                'ai_recommendations',
                'ai_confidence',
                'resolution_summary'
            ]);
        });
    }
};
