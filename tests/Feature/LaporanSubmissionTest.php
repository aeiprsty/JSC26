<?php

namespace Tests\Feature;

use App\Models\Klaster;
use App\Models\Laporan;
use App\Enums\StatusKlaster;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LaporanSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_masyarakat_dapat_mengirim_laporan(): void
    {
        Storage::fake('public');

        $response = $this->post(route('laporan.store'), [
            'foto' => UploadedFile::fake()->image('tps-liar.jpg'),
            'deskripsi' => 'Terdapat tumpukan sampah di pinggir jalan.',
            'lat' => -1.6100000,
            'lng' => 103.6100000,
        ]);

        $response->assertCreated()
            ->assertJsonPath('message', 'Laporan berhasil dikirim.')
            ->assertJsonPath('data.status', 'menunggu');

        $this->assertDatabaseCount('laporan', 1);
        $this->assertDatabaseCount('klaster', 1);

        $laporan = Laporan::firstOrFail();

        $this->assertNotEmpty($laporan->kode_tiket);
        $this->assertNotNull($laporan->klaster_id);

        Storage::disk('public')->assertExists($laporan->foto);
    }

    public function test_laporan_di_lokasi_dekat_masuk_ke_klaster_yang_sama(): void
    {
        Storage::fake('public');

        $this->post(route('laporan.store'), [
            'foto' => UploadedFile::fake()->image('laporan-1.jpg'),
            'deskripsi' => 'Laporan pertama.',
            'lat' => -1.6100000,
            'lng' => 103.6100000,
        ])->assertCreated();

        $this->post(route('laporan.store'), [
            'foto' => UploadedFile::fake()->image('laporan-2.jpg'),
            'deskripsi' => 'Laporan kedua.',
            'lat' => -1.6101000,
            'lng' => 103.6100000,
        ])->assertCreated();

        $this->assertDatabaseCount('laporan', 2);
        $this->assertDatabaseCount('klaster', 1);

        $this->assertSame(
            Laporan::query()->value('klaster_id'),
            Laporan::query()->latest('id')->value('klaster_id')
        );
    }

    public function test_laporan_tanpa_foto_ditolak(): void
    {
        $response = $this->post(route('laporan.store'), [
            'deskripsi' => 'Laporan tanpa foto.',
            'lat' => -1.6100000,
            'lng' => 103.6100000,
        ]);

        $response->assertSessionHasErrors('foto');

        $this->assertDatabaseCount('laporan', 0);
        $this->assertDatabaseCount('klaster', 0);
    }

    
    public function test_laporan_di_luar_radius_50_meter_membuat_klaster_baru(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $this->post(route('laporan.store'), [
            'foto' => \Illuminate\Http\UploadedFile::fake()->image('laporan-1.jpg'),
            'deskripsi' => 'Laporan pertama.',
            'lat' => -1.6100000,
            'lng' => 103.6100000,
        ])->assertCreated();

        $this->post(route('laporan.store'), [
            'foto' => \Illuminate\Http\UploadedFile::fake()->image('laporan-2.jpg'),
            'deskripsi' => 'Laporan kedua yang berjauhan.',
            'lat' => -1.6120000,
            'lng' => 103.6100000,
        ])->assertCreated();

        $this->assertDatabaseCount('laporan', 2);
        $this->assertDatabaseCount('klaster', 2);

        $this->assertNotSame(
            \App\Models\Laporan::query()->orderBy('id')->first()->klaster_id,
            \App\Models\Laporan::query()->orderByDesc('id')->first()->klaster_id,
        );
    }

    public function test_klaster_selesai_tidak_dipakai_kembali(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $this->post(route('laporan.store'), [
            'foto' => \Illuminate\Http\UploadedFile::fake()->image('laporan-1.jpg'),
            'deskripsi' => 'Laporan pertama.',
            'lat' => -1.6100000,
            'lng' => 103.6100000,
        ])->assertCreated();

        $klaster = \App\Models\Klaster::query()->firstOrFail();

        $klaster->update([
            'status' => \App\Enums\StatusKlaster::Selesai,
        ]);

        $this->post(route('laporan.store'), [
            'foto' => \Illuminate\Http\UploadedFile::fake()->image('laporan-2.jpg'),
            'deskripsi' => 'Laporan baru di lokasi yang sama.',
            'lat' => -1.6100000,
            'lng' => 103.6100000,
        ])->assertCreated();

        $this->assertDatabaseCount('klaster', 2);

        $laporanTerbaru = \App\Models\Laporan::query()
            ->orderByDesc('id')
            ->firstOrFail();

        $this->assertNotSame(
            $klaster->id,
            $laporanTerbaru->klaster_id,
        );
    }

    public function test_klaster_ditolak_tidak_dipakai_kembali(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $this->post(route('laporan.store'), [
            'foto' => \Illuminate\Http\UploadedFile::fake()->image('laporan-1.jpg'),
            'deskripsi' => 'Laporan pertama.',
            'lat' => -1.6100000,
            'lng' => 103.6100000,
        ])->assertCreated();

        $klaster = \App\Models\Klaster::query()->firstOrFail();

        $klaster->update([
            'status' => \App\Enums\StatusKlaster::Ditolak,
        ]);

        $this->post(route('laporan.store'), [
            'foto' => \Illuminate\Http\UploadedFile::fake()->image('laporan-2.jpg'),
            'deskripsi' => 'Laporan baru di lokasi yang sama.',
            'lat' => -1.6100000,
            'lng' => 103.6100000,
        ])->assertCreated();

        $this->assertDatabaseCount('klaster', 2);

        $laporanTerbaru = \App\Models\Laporan::query()
            ->orderByDesc('id')
            ->firstOrFail();

        $this->assertNotSame(
            $klaster->id,
            $laporanTerbaru->klaster_id,
        );
    }

    
    public function test_laporan_ditolak_tetap_tersimpan_dan_lepas_dari_klaster(): void
    {
        Storage::fake('public');

        $this->post(route('laporan.store'), [
            'foto' => UploadedFile::fake()->image('laporan.jpg'),
            'deskripsi' => 'Tumpukan sampah di pinggir jalan.',
            'lat' => -1.6100000,
            'lng' => 103.6100000,
        ])->assertCreated();

        $laporan = Laporan::query()->firstOrFail();
        $kodeTiket = $laporan->kode_tiket;

        // Simulasikan hasil tindakan penolakan admin.
        $laporan->update([
            'status' => 'ditolak',
            'alasan_tolak' => 'Lokasi laporan tidak sesuai ketentuan.',
            'klaster_id' => null,
        ]);

        $this->assertDatabaseHas('laporan', [
            'id' => $laporan->id,
            'kode_tiket' => $kodeTiket,
            'status' => 'ditolak',
            'alasan_tolak' => 'Lokasi laporan tidak sesuai ketentuan.',
            'klaster_id' => null,
        ]);

        $this->assertDatabaseCount('laporan', 1);
        $this->assertDatabaseCount('klaster', 1);
    }

    public function test_laporan_yang_ditolak_tidak_berubah_saat_klaster_selesai(): void
    {
        Storage::fake('public');

        $this->post(route('laporan.store'), [
            'foto' => UploadedFile::fake()->image('laporan-1.jpg'),
            'deskripsi' => 'Laporan pertama.',
            'lat' => -1.6100000,
            'lng' => 103.6100000,
        ])->assertCreated();

        $this->post(route('laporan.store'), [
            'foto' => UploadedFile::fake()->image('laporan-2.jpg'),
            'deskripsi' => 'Laporan kedua.',
            'lat' => -1.6101000,
            'lng' => 103.6100000,
        ])->assertCreated();

        $laporan = Laporan::query()->orderBy('id')->firstOrFail();
        $laporanDitolak = Laporan::query()->orderByDesc('id')->firstOrFail();

        $laporanDitolak->update([
            'status' => 'ditolak',
            'alasan_tolak' => 'Laporan duplikat.',
            'klaster_id' => null,
        ]);

        // Simulasikan klaster selesai dikerjakan.
        $klaster = Klaster::query()->firstOrFail();
        $klaster->update(['status' => StatusKlaster::Selesai]);

        // Hanya laporan valid yang menjadi selesai.
        $laporan->update(['status' => 'selesai']);

        $this->assertDatabaseHas('laporan', [
            'id' => $laporan->id,
            'status' => 'selesai',
        ]);

        $this->assertDatabaseHas('laporan', [
            'id' => $laporanDitolak->id,
            'status' => 'ditolak',
            'alasan_tolak' => 'Laporan duplikat.',
            'klaster_id' => null,
        ]);
    }

    public function test_alasan_penolakan_dapat_disimpan_bersama_status_ditolak(): void
    {
        Storage::fake('public');

        $this->post(route('laporan.store'), [
            'foto' => UploadedFile::fake()->image('laporan.jpg'),
            'deskripsi' => 'Laporan untuk pengujian penolakan.',
            'lat' => -1.6100000,
            'lng' => 103.6100000,
        ])->assertCreated();

        $laporan = Laporan::query()->firstOrFail();

        $laporan->update([
            'status' => 'ditolak',
            'alasan_tolak' => 'Bukti foto tidak cukup jelas.',
            'klaster_id' => null,
        ]);

        $this->assertDatabaseHas('laporan', [
            'id' => $laporan->id,
            'status' => 'ditolak',
            'alasan_tolak' => 'Bukti foto tidak cukup jelas.',
        ]);
    }

}