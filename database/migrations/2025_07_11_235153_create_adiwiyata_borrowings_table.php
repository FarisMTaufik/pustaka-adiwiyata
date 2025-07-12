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
        Schema::create('faris_borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('faris_books')->onDelete('cascade'); // Foreign key ke tabel buku
            $table->foreignId('member_id')->constrained('faris_members')->onDelete('cascade'); // Foreign key ke tabel anggota
            $table->date('borrow_date');
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->decimal('fine_amount', 8, 2)->default(0.00); // Denda
            $table->string('status')->default('borrowed'); // 'borrowed', 'returned', 'overdue'
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('faris_borrowings');
    }
};
