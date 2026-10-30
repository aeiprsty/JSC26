<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klasters', function (Blueprint $table) { // <-- Ubah jadi 'klasters'
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

    public function down(): void
    {
        Schema::dropIfExists('klasters');
    }
};