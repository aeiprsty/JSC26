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
        Schema::create('klaster', function (Blueprint $table) {
            $table->id();
            $table->decimal('anchor_lat', 10, 7);
            $table->decimal('anchor_lng', 10, 7);
            $table->string('status')->default('menunggu_verifikasi')->index();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->text('alasan_tolak')->nullable();
            $table->string('foto_bukti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klaster_id')->constrained('klaster')->cascadeOnDelete();
            $table->string('kode_tiket')->unique();
            $table->string('foto');
            $table->text('deskripsi')->nullable();
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
            $table->timestamps();
        });
    }
};
