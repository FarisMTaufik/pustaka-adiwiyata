<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('faris_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama kategori (Fiksi, Non-Fiksi, Modul Adiwiyata)
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('faris_categories');
    }
};
