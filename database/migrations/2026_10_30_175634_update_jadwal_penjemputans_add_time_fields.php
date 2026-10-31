<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_penjemputans', function (Blueprint $table) {
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('jam_operasional', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_penjemputans', function (Blueprint $table) {
            $table->dropColumn(['jam_mulai', 'jam_selesai']);
            $table->string('jam_operasional', 50)->nullable(false)->change();
        });
    }
};