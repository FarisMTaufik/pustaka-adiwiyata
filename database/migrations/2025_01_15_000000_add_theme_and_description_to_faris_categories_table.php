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
        Schema::table('faris_categories', function (Blueprint $table) {
            $table->string('theme')->nullable()->after('name');
            $table->text('description')->nullable()->after('theme');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faris_categories', function (Blueprint $table) {
            $table->dropColumn(['theme', 'description']);
        });
    }
};
