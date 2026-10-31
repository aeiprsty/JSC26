<?php

namespace Tests\Feature;

use App\Enums\StatusKlaster;
use App\Filament\Resources\KlasterResource\Pages\EditKlaster;
use App\Models\Klaster;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;
use App\Filament\Resources\LaporanResource\Pages\ListLaporans;
use App\Filament\Resources\KlasterResource\Pages\ListKlasters;

class KlasterWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'operator',
            'is_active' => true,
        ]);

        $this->actingAs($user);
    }

    private function loginAsKomandoLapangan(): User
    {
        return $this->loginAsRole('komando_lapangan');
    }

    public function test_halaman_edit_klaster_dapat_dibuka_komando_lapangan(): void
    {
        $komando = $this->loginAsKomandoLapangan();

        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::DalamProses,
            'assigned_to' => $komando->id,
        ]);

        $this->get(route(
            'filament.admin.resources.klasters.edit',
            ['record' => $klaster->id]
        ))->assertSuccessful();
    }

    public function test_klaster_selesai_memerlukan_foto_bukti(): void
    {
        $komando = $this->loginAsKomandoLapangan();

        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::DalamProses,
            'assigned_to' => $komando->id,
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
        $komando = $this->loginAsKomandoLapangan();

        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::DalamProses,
            'assigned_to' => $komando->id,
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

    private function loginAsRole(string $role): User
    {
        $user = User::factory()->create([
            'role' => $role,
            'is_active' => true,
        ]);

        $this->actingAs($user);

        return $user;
    }

    public function test_kabid_dapat_membuka_klaster_terverifikasi(): void
    {
        $this->loginAsRole('kabid');

        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::Terverifikasi,
        ]);

        $this->get(route(
            'filament.admin.resources.klasters.edit',
            ['record' => $klaster->id]
        ))->assertSuccessful();
    }

    public function test_subkoordinator_dapat_membuka_klaster_disposisi(): void
    {
        $this->loginAsRole('subkoordinator');

        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::Disposisi,
        ]);

        $this->get(route(
            'filament.admin.resources.klasters.edit',
            ['record' => $klaster->id]
        ))->assertSuccessful();
    }

    public function test_operator_tidak_dapat_membuka_halaman_edit_klaster(): void
    {
        $this->loginAsRole('operator');

        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::Terverifikasi,
        ]);

        $this->get(route(
            'filament.admin.resources.klasters.edit',
            ['record' => $klaster->id]
        ))->assertForbidden();
    }

    public function test_komando_lapangan_tidak_dapat_membuka_klaster_petugas_lain(): void
    {
        $komando = $this->loginAsKomandoLapangan();

        $petugasLain = User::factory()->create([
            'role' => 'komando_lapangan',
        ]);

        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::DalamProses,
            'assigned_to' => $petugasLain->id,
        ]);

        $this->get(route(
            'filament.admin.resources.klasters.edit',
            ['record' => $klaster->id]
        ))->assertNotFound();
    }

    public function test_komando_lapangan_dapat_membuka_klaster_tugasnya(): void
    {
        $komando = $this->loginAsKomandoLapangan();

        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::DalamProses,
            'assigned_to' => $komando->id,
        ]);

        $this->get(route(
            'filament.admin.resources.klasters.edit',
            ['record' => $klaster->id]
        ))->assertSuccessful();
    }

    
    public function test_kabid_tidak_dapat_mengganti_petugas(): void
    {
        $kabid = $this->loginAsRole('kabid');

        $petugasAwal = User::factory()->create([
            'role' => 'komando_lapangan',
        ]);

        $petugasBaru = User::factory()->create([
            'role' => 'komando_lapangan',
        ]);

        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::Terverifikasi,
            'assigned_to' => $petugasAwal->id,
        ]);

        Livewire::test(EditKlaster::class, [
            'record' => $klaster->getRouteKey(),
        ])
            ->fillForm([
                'status' => StatusKlaster::Disposisi->value,
                'assigned_to' => $petugasBaru->id,
            ])
            ->call('save')
            ->assertHasErrors(['data.assigned_to']);

        $this->assertDatabaseHas('klaster', [
            'id' => $klaster->id,
            'status' => StatusKlaster::Terverifikasi->value,
            'assigned_to' => $petugasAwal->id,
        ]);
    }

    public function test_subkoordinator_hanya_dapat_memilih_komando_lapangan(): void
    {
        $this->loginAsRole('subkoordinator');

        $operator = User::factory()->create([
            'role' => 'operator',
        ]);

        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::Disposisi,
        ]);

        Livewire::test(EditKlaster::class, [
            'record' => $klaster->getRouteKey(),
        ])
            ->fillForm([
                'status' => StatusKlaster::Ditugaskan->value,
                'assigned_to' => $operator->id,
            ])
            ->call('save')
            ->assertHasErrors(['data.assigned_to']);

        $this->assertDatabaseHas('klaster', [
            'id' => $klaster->id,
            'status' => StatusKlaster::Disposisi->value,
            'assigned_to' => null,
        ]);
    }

    public function test_komando_lapangan_tidak_dapat_mengalihkan_penugasan(): void
    {
        $komando = $this->loginAsKomandoLapangan();

        $petugasLain = User::factory()->create([
            'role' => 'komando_lapangan',
        ]);

        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::Ditugaskan,
            'assigned_to' => $komando->id,
        ]);

        Livewire::test(EditKlaster::class, [
            'record' => $klaster->getRouteKey(),
        ])
            ->fillForm([
                'status' => StatusKlaster::DalamProses->value,
                'assigned_to' => $petugasLain->id,
            ])
            ->call('save')
            ->assertHasErrors(['data.assigned_to']);

        $this->assertDatabaseHas('klaster', [
            'id' => $klaster->id,
            'status' => StatusKlaster::Ditugaskan->value,
            'assigned_to' => $komando->id,
        ]);
    }

    public function test_kabid_tidak_dapat_melompati_tahapan_status(): void
    {
        $this->loginAsRole('kabid');

        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::Terverifikasi,
        ]);

        Livewire::test(EditKlaster::class, [
            'record' => $klaster->getRouteKey(),
        ])
            ->fillForm([
                'status' => StatusKlaster::Ditugaskan->value,
            ])
            ->call('save')
            ->assertHasErrors(['data.status']);

        $this->assertDatabaseHas('klaster', [
            'id' => $klaster->id,
            'status' => StatusKlaster::Terverifikasi->value,
        ]);
    }
    
    public function test_alur_lengkap_klaster_dari_operator_sampai_selesai(): void
    {
        // 1. Operator memverifikasi laporan.
        $this->loginAsRole('operator');

        $klaster = Klaster::create([
            'anchor_lat' => -1.6100000,
            'anchor_lng' => 103.6100000,
            'status' => StatusKlaster::MenungguVerifikasi,
        ]);

        $laporan = Laporan::create([
            'klaster_id' => $klaster->id,
            'kode_tiket' => 'TPS-E2E0001',
            'foto' => 'laporan/e2e.jpg',
            'deskripsi' => 'Tumpukan sampah di pinggir jalan.',
            'lat' => -1.6100000,
            'lng' => 103.6100000,
            'status' => 'menunggu',
        ]);

        Livewire::test(ListLaporans::class)
            ->callTableAction('verifikasi', $laporan);

        $this->assertDatabaseHas('laporan', [
            'id' => $laporan->id,
            'status' => 'terverifikasi',
        ]);

        // Operator memverifikasi klaster.
        Livewire::test(ListKlasters::class)
            ->callTableAction('verifikasi', $klaster);

        $this->assertDatabaseHas('klaster', [
            'id' => $klaster->id,
            'status' => StatusKlaster::Terverifikasi->value,
        ]);

        // 2. Kabid memberikan disposisi.
        $this->loginAsRole('kabid');

        Livewire::test(EditKlaster::class, [
            'record' => $klaster->getRouteKey(),
        ])
            ->fillForm([
                'status' => StatusKlaster::Disposisi->value,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        // 3. Subkoordinator menetapkan petugas.
        $this->loginAsRole('subkoordinator');

        $komando = User::factory()->create([
            'role' => 'komando_lapangan',
        ]);

        Livewire::test(EditKlaster::class, [
            'record' => $klaster->getRouteKey(),
        ])
            ->fillForm([
                'status' => StatusKlaster::Ditugaskan->value,
                'assigned_to' => $komando->id,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('klaster', [
            'id' => $klaster->id,
            'status' => StatusKlaster::Ditugaskan->value,
            'assigned_to' => $komando->id,
        ]);

        // 4. Komando Lapangan memulai pekerjaan.
        $this->actingAs($komando);

        Livewire::test(EditKlaster::class, [
            'record' => $klaster->getRouteKey(),
        ])
            ->fillForm([
                'status' => StatusKlaster::DalamProses->value,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        // Komando menyelesaikan pekerjaan dan mengunggah foto.
        $fotoBukti = UploadedFile::fake()->image('bukti-e2e.jpg');

        Livewire::test(EditKlaster::class, [
            'record' => $klaster->getRouteKey(),
        ])
            ->fillForm([
                'status' => StatusKlaster::Selesai->value,
                'foto_bukti' => [$fotoBukti],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        // 5. Memastikan hasil akhir.
        $this->assertDatabaseHas('klaster', [
            'id' => $klaster->id,
            'status' => StatusKlaster::Selesai->value,
            'assigned_to' => $komando->id,
        ]);

        $this->assertDatabaseHas('laporan', [
            'id' => $laporan->id,
            'status' => 'selesai',
        ]);
    }
}