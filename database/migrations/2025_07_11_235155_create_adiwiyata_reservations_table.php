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
        Schema::create('faris_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('faris_books')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('faris_members')->onDelete('cascade');
            $table->date('reservation_date');
            $table->date('expiration_date')->nullable(); // Tanggal kadaluarsa reservasi jika tidak diambil
            $table->string('status')->default('pending'); // 'pending', 'ready_for_pickup', 'cancelled', 'fulfilled'
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('faris_reservations');
    }
};
