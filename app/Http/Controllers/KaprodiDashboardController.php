<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class KaprodiDashboardController extends Controller
{
    public function pengajuanMasuk(Request $request): View
    {
        abort_unless($request->user()->role === 'kaprodi', 403);

        $pengajuanMasuk = DB::table('pengajuan_judul as pengajuan')
            ->join('users as mahasiswa', 'mahasiswa.id', '=', 'pengajuan.mahasiswa_id')
            ->join('users as dospem_1', 'dospem_1.id', '=', 'pengajuan.dospem_1_id')
            ->join('users as dospem_2', 'dospem_2.id', '=', 'pengajuan.dospem_2_id')
            ->whereRaw('LOWER(pengajuan.status) = ?', ['disetujui'])
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

        return view('kaprodi.pengajuan.index', compact('pengajuanMasuk'));
    }

    public function show(Request $request, int $pengajuan): View
    {
        abort_unless($request->user()->role === 'kaprodi', 403);

        $detail = DB::table('pengajuan_judul as pengajuan')
            ->join('users as mahasiswa', 'mahasiswa.id', '=', 'pengajuan.mahasiswa_id')
            ->join('users as dospem_1', 'dospem_1.id', '=', 'pengajuan.dospem_1_id')
            ->join('users as dospem_2', 'dospem_2.id', '=', 'pengajuan.dospem_2_id')
            ->leftJoin('surat_pengesahan as surat', 'surat.pengajuan_id', '=', 'pengajuan.id')
            ->where('pengajuan.id', $pengajuan)
            ->select([
                'pengajuan.id',
                'pengajuan.judul',
                'pengajuan.abstrak',
                'pengajuan.file_proposal',
                'pengajuan.status',
                'pengajuan.created_at',
                'pengajuan.updated_at',
                'mahasiswa.name as nama_mahasiswa',
                'mahasiswa.npm',
                'dospem_1.name as nama_dospem_1',
                'dospem_2.name as nama_dospem_2',
                'surat.nomor_sk',
                'surat.tanggal_disetujui',
            ])
            ->first();

        abort_if($detail === null, 404);

        return view('kaprodi.pengajuan.show', compact('detail'));
    }

    public function riwayatKeputusan(Request $request): View
    {
        abort_unless($request->user()->role === 'kaprodi', 403);

        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        $baseQuery = DB::table('pengajuan_judul as pengajuan')
            ->join('users as mahasiswa', 'mahasiswa.id', '=', 'pengajuan.mahasiswa_id')
            ->join('users as dospem_1', 'dospem_1.id', '=', 'pengajuan.dospem_1_id')
            ->join('users as dospem_2', 'dospem_2.id', '=', 'pengajuan.dospem_2_id')
            ->leftJoin('surat_pengesahan as surat', 'surat.pengajuan_id', '=', 'pengajuan.id')
            ->whereRaw('LOWER(pengajuan.status) = ?', ['acc final']);

        if (!empty($validated['q'])) {
            $keyword = $validated['q'];

            $baseQuery->where(function ($query) use ($keyword): void {
                $query->where('mahasiswa.name', 'like', '%' . $keyword . '%')
                    ->orWhere('mahasiswa.npm', 'like', '%' . $keyword . '%')
                    ->orWhere('pengajuan.judul', 'like', '%' . $keyword . '%')
                    ->orWhere('surat.nomor_sk', 'like', '%' . $keyword . '%');
            });
        }

        $riwayat = $baseQuery
            ->select([
                'pengajuan.id',
                'pengajuan.judul',
                'pengajuan.status',
                'pengajuan.updated_at',
                'mahasiswa.name as nama_mahasiswa',
                'mahasiswa.npm',
                'dospem_1.name as nama_dospem_1',
                'dospem_2.name as nama_dospem_2',
                'surat.nomor_sk',
                'surat.tanggal_disetujui',
            ])
            ->latest('pengajuan.updated_at')
            ->paginate(10)
            ->withQueryString();

        return view('kaprodi.riwayat', compact('riwayat'));
    }

    public function index(Request $request): View
    {
        abort_unless($request->user()->role === 'kaprodi', 403);

        $baseQuery = DB::table('pengajuan_judul as pengajuan')
            ->join('users as mahasiswa', 'mahasiswa.id', '=', 'pengajuan.mahasiswa_id')
            ->join('users as dospem_1', 'dospem_1.id', '=', 'pengajuan.dospem_1_id')
            ->join('users as dospem_2', 'dospem_2.id', '=', 'pengajuan.dospem_2_id');

        $menungguCount = DB::table('pengajuan_judul')
            ->whereRaw('LOWER(status) = ?', ['disetujui'])
            ->count();

        $disahkanCount = DB::table('pengajuan_judul')
            ->whereRaw('LOWER(status) = ?', ['acc final'])
            ->count();

        $statistics = [
            'menunggu' => $menungguCount,
            'disahkan' => $disahkanCount,
            'total_diproses' => $menungguCount + $disahkanCount,
        ];

        $menungguPengesahan = (clone $baseQuery)
            ->whereRaw('LOWER(pengajuan.status) = ?', ['disetujui'])
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
            ->whereRaw('LOWER(pengajuan.status) = ?', ['acc final'])
            ->select([
                'pengajuan.id',
                'pengajuan.judul',
                'pengajuan.status',
                'pengajuan.updated_at',
                'mahasiswa.name as nama_mahasiswa',
                'mahasiswa.npm',
                'dospem_1.name as nama_dospem_1',
                'dospem_2.name as nama_dospem_2',
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

        DB::transaction(function () use ($pengajuan, $request): void {
            $data = DB::table('pengajuan_judul')
                ->where('id', $pengajuan)
                ->lockForUpdate()
                ->first();

            abort_if($data === null, 404);
            abort_unless(
                strtolower((string) $data->status) === 'disetujui',
                422,
                'Pengajuan ini belum disetujui kedua dosen pembimbing.'
            );

            $nomorSk = sprintf('SK/%s/%06d', now()->format('Y'), $data->id);

            DB::table('pengajuan_judul')
                ->where('id', $data->id)
                ->update([
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