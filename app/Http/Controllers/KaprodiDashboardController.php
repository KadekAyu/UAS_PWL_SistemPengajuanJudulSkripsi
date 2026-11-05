<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class KaprodiDashboardController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->role === 'kaprodi', 403);

        $baseQuery = DB::table('pengajuan_judul as pengajuan')
            ->join('users as mahasiswa', 'mahasiswa.id', '=', 'pengajuan.mahasiswa_id')
            ->join('users as dospem_1', 'dospem_1.id', '=', 'pengajuan.dospem_1_id')
            ->join('users as dospem_2', 'dospem_2.id', '=', 'pengajuan.dospem_2_id');

        $approvalStatuses = ['ACC Dospem', 'ACC Dosen', 'Menunggu Persetujuan Kaprodi'];

        $statistics = [
            'total' => DB::table('pengajuan_judul')->count(),
            'menunggu' => DB::table('pengajuan_judul')->whereIn('status', $approvalStatuses)->count(),
            'disahkan' => DB::table('pengajuan_judul')->where('status', 'ACC Final')->count(),
            'ditolak' => DB::table('pengajuan_judul')->where('status', 'Ditolak')->count(),
        ];

        $menungguPengesahan = (clone $baseQuery)
            ->whereIn('pengajuan.status', $approvalStatuses)
            ->select([
                'pengajuan.id',
                'pengajuan.judul',
                'pengajuan.abstrak',
                'pengajuan.file_proposal',
                'pengajuan.status',
                'pengajuan.created_at',
                'mahasiswa.name as nama_mahasiswa',
                'mahasiswa.npm',
                'dospem_1.id as dospem_1_id',
                'dospem_1.name as nama_dospem_1',
                'dospem_2.id as dospem_2_id',
                'dospem_2.name as nama_dospem_2',
            ])
            ->latest('pengajuan.updated_at')
            ->get();

        $riwayat = (clone $baseQuery)
            ->leftJoin('surat_pengesahan as surat', 'surat.pengajuan_id', '=', 'pengajuan.id')
            ->whereIn('pengajuan.status', ['ACC Final', 'Ditolak'])
            ->select([
                'pengajuan.id',
                'pengajuan.judul',
                'pengajuan.status',
                'pengajuan.updated_at',
                'mahasiswa.name as nama_mahasiswa',
                'mahasiswa.npm',
                'surat.nomor_sk',
            ])
            ->latest('pengajuan.updated_at')
            ->limit(8)
            ->get();

        return view('kaprodi.dashboard', compact('statistics', 'menungguPengesahan', 'riwayat'));
    }

    public function sahkan(Request $request, int $pengajuan): RedirectResponse
    {
        abort_unless($request->user()->role === 'kaprodi', 403);

        $validated = $request->validate([
            'dospem_final_id' => ['required', 'integer'],
        ]);

        DB::transaction(function () use ($validated, $pengajuan, $request): void {
            $data = DB::table('pengajuan_judul')
                ->where('id', $pengajuan)
                ->lockForUpdate()
                ->first();

            abort_if($data === null, 404);
            abort_unless(
                in_array($data->status, ['ACC Dospem', 'ACC Dosen', 'Menunggu Persetujuan Kaprodi'], true),
                422,
                'Pengajuan ini belum siap disahkan.'
            );
            abort_unless(
                in_array((int) $validated['dospem_final_id'], [(int) $data->dospem_1_id, (int) $data->dospem_2_id], true),
                422,
                'Dospem final harus dipilih dari dosen yang diusulkan.'
            );

            $nomorSk = sprintf('SK/%s/%06d', now()->format('Y'), $data->id);

            DB::table('pengajuan_judul')
                ->where('id', $data->id)
                ->update([
                    'dospem_final_id' => $validated['dospem_final_id'],
                    'status' => 'ACC Final',
                    'updated_at' => now(),
                ]);

            DB::table('surat_pengesahan')->updateOrInsert(
                ['pengajuan_id' => $data->id],
                [
                    'kaprodi_id' => $request->user()->id,
                    'dospem_1_id' => $data->dospem_1_id,
                    'dospem_2_id' => $data->dospem_2_id,
                    'nomor_sk' => $nomorSk,
                    'tanggal_disetujui' => now()->toDateString(),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        });

        return redirect()
            ->route('kaprodi.dashboard')
            ->with('success', 'Judul berhasil disahkan dan nomor SK telah dibuat.');
    }
}
