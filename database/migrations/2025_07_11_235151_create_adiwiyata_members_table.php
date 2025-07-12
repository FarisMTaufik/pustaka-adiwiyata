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
        Schema::create('faris_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key ke tabel users bawaan Laravel
            $table->string('member_id_number')->unique()->nullable(); // NIS/NIP
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('role')->default('member'); // 'member' (siswa/guru), 'admin' (pustakawan) - ini opsional, bisa juga hanya di tabel users
            $table->integer('total_points')->default(0); // Poin literasi Adiwiyata
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('faris_members');
    }
};
