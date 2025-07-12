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
        Schema::create('faris_books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('isbn')->unique()->nullable();
            $table->integer('publication_year')->nullable();
            $table->integer('quantity'); // Total stok buku
            $table->integer('available_quantity'); // Jumlah buku yang tersedia untuk dipinjam
            $table->foreignId('category_id')->constrained('faris_categories')->onDelete('cascade'); // Foreign key ke tabel kategori
            $table->string('theme')->nullable(); // Tema Adiwiyata (Konservasi, Daur Ulang, dll.)
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable(); // Path gambar sampul buku
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('faris_books');
    }
};
