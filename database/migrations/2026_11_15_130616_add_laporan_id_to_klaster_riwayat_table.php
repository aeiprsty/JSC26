<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('klaster_riwayat', function (Blueprint $table) {
            $table->foreignId('laporan_id')
                ->nullable()
                ->after('klaster_id')
                ->constrained('laporan')
                ->nullOnDelete();

            $table->foreignId('klaster_id')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('klaster_riwayat', function (Blueprint $table) {
            $table->dropConstrainedForeignId('laporan_id');

            $table->foreignId('klaster_id')
                ->nullable(false)
                ->change();
        });
    }
};
