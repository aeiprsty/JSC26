<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->json('rincian')->nullable();
            $table->string('ikon', 100)->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['status', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasis');
    }
};