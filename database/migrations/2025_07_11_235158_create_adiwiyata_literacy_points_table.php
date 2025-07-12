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
        Schema::create('faris_literacy_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('faris_members')->onDelete('cascade'); // Foreign key ke tabel anggota
            $table->string('activity_type'); // "Peminjaman Buku", "Ulasan Buku", "Kontribusi Adiwiyata"
            $table->integer('points');
            $table->unsignedBigInteger('reference_id')->nullable(); // Bisa merujuk ke borrowing_id atau review_id
            $table->string('description')->nullable(); // Deskripsi aktivitas
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('faris_literacy_points');
    }
};
