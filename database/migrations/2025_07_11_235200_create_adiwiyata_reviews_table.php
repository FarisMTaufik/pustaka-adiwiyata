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
        Schema::create('faris_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('faris_books')->onDelete('cascade'); // Foreign key ke tabel buku
            $table->foreignId('member_id')->constrained('faris_members')->onDelete('cascade'); // Foreign key ke tabel anggota
            $table->integer('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('faris_reviews');
    }
};
