
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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klaster_id')
                ->nullable()
                ->constrained('klaster')
                ->nullOnDelete();

            $table->string('kode_tiket')->unique();
            $table->string('foto');
            $table->text('deskripsi')->nullable();
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
            $table->string('status')->default('menunggu');
            $table->text('alasan_tolak')->nullable();
            $table->timestamps();
        });

        Schema::dropIfExists('laporans');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};