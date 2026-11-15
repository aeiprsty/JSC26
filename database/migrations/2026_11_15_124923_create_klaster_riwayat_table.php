<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klaster_riwayat', function (Blueprint $table) {
            $table->id();

            $table->foreignId('klaster_id')
                ->constrained('klaster')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('role')->nullable();
            $table->string('aktivitas');
            $table->string('status_sebelum')->nullable();
            $table->string('status_sesudah')->nullable();

            $table->foreignId('assigned_to_sebelum')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('assigned_to_sesudah')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->index(['klaster_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klaster_riwayat');
    }
};