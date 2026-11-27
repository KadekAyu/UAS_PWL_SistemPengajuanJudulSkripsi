<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class KaprodiLegacyApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_kaprodi_can_assign_a_final_supervisor_and_approve_a_legacy_submission(): void
    {
        $kaprodi = User::create([
            'name' => 'Kaprodi',
            'email' => 'kaprodi@example.test',
            'password' => 'secret',
            'role' => 'kaprodi',
        ]);
        $mahasiswa = User::create([
            'name' => 'Rizky',
            'npm' => '2417051009',
            'email' => 'mahasiswa@example.test',
            'password' => 'secret',
            'role' => 'mahasiswa',
        ]);
        $dosen = User::create([
            'name' => 'Dosen Pembimbing',
            'email' => 'dosen@example.test',
            'password' => 'secret',
            'role' => 'dospem',
        ]);

        $pengajuanId = DB::table('pengajuan_judul')->insertGetId([
            'mahasiswa_id' => $mahasiswa->id,
            'judul' => 'Judul Skripsi',
            'abstrak' => 'Abstrak',
            'file_proposal' => 'proposal.pdf',
            'dospem_1_id' => $dosen->id,
            'dospem_2_id' => $dosen->id,
            'status' => 'disetujui',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($kaprodi)
            ->get(route('kaprodi.pengajuan.index'))
            ->assertOk()
            ->assertSee('Rizky')
            ->assertSee('disetujui');

        $this->get(route('kaprodi.pengajuan.show', $pengajuanId))
            ->assertOk()
            ->assertSee('Tunjuk Dosen Final')
            ->assertDontSee('Dosen final:');

        $this->post(route('kaprodi.pengajuan.sahkan', $pengajuanId))
            ->assertUnprocessable();

        $this->assertDatabaseHas('pengajuan_judul', [
            'id' => $pengajuanId,
            'status' => 'disetujui',
            'dospem_final_id' => null,
        ]);

        $this->post(route('kaprodi.pengajuan.tunjuk-dospem', $pengajuanId), [
            'dospem_final_id' => $dosen->id,
        ])->assertRedirect(route('kaprodi.dashboard'));

        $this->assertDatabaseHas('pengajuan_judul', [
            'id' => $pengajuanId,
            'status' => 'disetujui',
            'dospem_final_id' => $dosen->id,
        ]);

        $this->post(route('kaprodi.pengajuan.tunjuk-dospem', $pengajuanId), [
            'dospem_final_id' => $dosen->id,
        ])->assertUnprocessable();

        $this->get(route('kaprodi.pengajuan.show', $pengajuanId))
            ->assertOk()
            ->assertSee('Sahkan Judul');

        $this->post(route('kaprodi.pengajuan.sahkan', $pengajuanId))
            ->assertRedirect(route('kaprodi.dashboard'));

        $this->assertDatabaseHas('pengajuan_judul', [
            'id' => $pengajuanId,
            'status' => 'ACC Final',
        ]);

        $this->assertDatabaseHas('surat_pengesahan', [
            'pengajuan_id' => $pengajuanId,
            'kaprodi_id' => $kaprodi->id,
            'nomor_sk' => sprintf('SK/%s/%06d', now()->format('Y'), $pengajuanId),
        ]);
    }
}
