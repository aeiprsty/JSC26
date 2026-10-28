<?php

namespace Tests\Feature;

use App\Enums\StatusKlaster;
use App\Models\Klaster;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use App\Filament\Resources\KlasterResource\Pages\EditKlaster;
use Tests\TestCase;

class KlasterWorkflowTest extends TestCase
{
    use RefreshDatabase;


    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

    $user = User::factory()->create([
        'role' => 'operator'
    ]);

        $this->actingAs($user);
    }


    public function test_halaman_edit_klaster_dapat_dibuka_admin(): void
    {
        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::MenungguVerifikasi,
        ]);

        $this->get(route(
            'filament.admin.resources.klasters.edit',
            ['record' => $klaster->id]
        ))->assertSuccessful();
    }

    public function test_klaster_selesai_memerlukan_foto_bukti(): void
    {
        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::DalamProses,
        ]);

        Livewire::test(EditKlaster::class, [
            'record' => $klaster->getRouteKey(),
        ])
            ->fillForm([
                'status' => StatusKlaster::Selesai->value,
                'foto_bukti' => [],
            ])
            ->call('save')
            ->assertHasErrors(['data.foto_bukti']);

        $this->assertDatabaseHas('klaster', [
            'id' => $klaster->id,
            'status' => StatusKlaster::DalamProses->value,
        ]);
    }

    public function test_penyelesaian_klaster_menyelesaikan_laporan_valid_saja(): void
    {
        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::DalamProses,
        ]);

        $laporanValid = Laporan::create([
            'klaster_id' => $klaster->id,
            'kode_tiket' => 'TPS-VALID001',
            'foto' => 'laporan/valid.jpg',
            'deskripsi' => 'Laporan valid.',
            'lat' => -1.6100000,
            'lng' => 103.6100000,
            'status' => 'dalam_proses',
        ]);

        $laporanDitolak = Laporan::create([
            'klaster_id' => null,
            'kode_tiket' => 'TPS-TOLAK001',
            'foto' => 'laporan/ditolak.jpg',
            'deskripsi' => 'Laporan ditolak.',
            'lat' => -1.6101000,
            'lng' => 103.6100000,
            'status' => 'ditolak',
            'alasan_tolak' => 'Laporan duplikat.',
        ]);

        $fotoBukti = UploadedFile::fake()->image('bukti.jpg');
        
        Livewire::test(EditKlaster::class, [
            'record' => $klaster->getRouteKey(),
        ])
            ->fillForm([
                'status' => StatusKlaster::Selesai->value,
                'foto_bukti' => [$fotoBukti],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('klaster', [
            'id' => $klaster->id,
            'status' => StatusKlaster::Selesai->value,
        ]);

        $this->assertDatabaseHas('laporan', [
            'id' => $laporanValid->id,
            'status' => 'selesai',
        ]);

        $this->assertDatabaseHas('laporan', [
            'id' => $laporanDitolak->id,
            'status' => 'ditolak',
            'alasan_tolak' => 'Laporan duplikat.',
        ]);
    }
}