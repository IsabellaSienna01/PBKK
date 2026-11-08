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
        Schema::create('ide_agents', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('judul_ide', 150);
            $table->text('deskripsi');
            $table->string('status', 30)->default('Menunggu Review');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ide_agents');
    }
};
