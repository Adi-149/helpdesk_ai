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
    Schema::create('tickets', function (Blueprint $table) {
        $table->id();
        
        $isSqlite = Schema::getConnection()->getDriverName() === 'sqlite';
        if ($isSqlite) {
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        } else {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        }
        
        $table->string('subject');
        $table->text('description');
        $table->string('category');
        $table->enum('priority', ['low','medium','high']);
        $table->enum('status', ['open','progress','resolved','closed'])->default('open');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
