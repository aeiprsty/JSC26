<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('edukasis', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['video', 'artikel']);
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori', 100);
            $table->text('ringkasan')->nullable();
            $table->longText('isi')->nullable();
            $table->string('gambar')->nullable();
            $table->string('url_video')->nullable();
            $table->string('durasi', 20)->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['jenis', 'status']);
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('edukasis');
    }
};