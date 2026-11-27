<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class KaprodiDashboardController extends Controller
{
    // =====================================
    // HALAMAN PENGAJUAN MASUK
    // =====================================
    public function pengajuanMasuk(Request $request): View
    {
        abort_unless($request->user()->role === 'kaprodi', 403);

        // Pengajuan baru dan pengajuan yang sudah ACC Dospem.
        $approvalStatuses = [
            'menunggu',
            'ACC Dospem',
            'ACC Dosen',
            'disetujui',
        ];

        $pengajuanMasuk = DB::table('pengajuan_judul as pengajuan')
            ->join('users as mahasiswa', 'mahasiswa.id', '=', 'pengajuan.mahasiswa_id')
            ->join('users as dospem_1', 'dospem_1.id', '=', 'pengajuan.dospem_1_id')
            ->join('users as dospem_2', 'dospem_2.id', '=', 'pengajuan.dospem_2_id')
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

        // Daftar seluruh dosen yang dapat ditunjuk Kaprodi.
        $daftarDosen = DB::table('users')
            ->where('role', 'dospem')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('kaprodi.pengajuan.index', compact(
            'pengajuanMasuk',
            'daftarDosen'
        ));
    }

    // =====================================
    // DETAIL PENGAJUAN
    // =====================================
    public function show(Request $request, int $pengajuan): View
    {
        abort_unless($request->user()->role === 'kaprodi', 403);

        $detail = DB::table('pengajuan_judul as pengajuan')
            ->join('users as mahasiswa', 'mahasiswa.id', '=', 'pengajuan.mahasiswa_id')
            ->join('users as dospem_1', 'dospem_1.id', '=', 'pengajuan.dospem_1_id')
            ->join('users as dospem_2', 'dospem_2.id', '=', 'pengajuan.dospem_2_id')
            ->leftJoin(
                'surat_pengesahan as surat',
                'surat.pengajuan_id',
                '=',
                'pengajuan.id'
            )
            ->leftJoin('users as dospem_final', 'dospem_final.id', '=', 'pengajuan.dospem_final_id')
            ->where('pengajuan.id', $pengajuan)
            ->select([
                'pengajuan.id',
                'pengajuan.judul',
                'pengajuan.abstrak',
                'pengajuan.file_proposal',
                'pengajuan.status',
                'pengajuan.dospem_final_id',
                'pengajuan.created_at',
                'pengajuan.updated_at',
                'mahasiswa.name as nama_mahasiswa',
                'mahasiswa.npm',
                'dospem_1.name as nama_dospem_1',
                'dospem_2.name as nama_dospem_2',
                'dospem_final.name as nama_dospem_final',
                'surat.nomor_sk',
                'surat.tanggal_disetujui',
            ])
            ->first();

        abort_if($detail === null, 404);

        $daftarDosen = DB::table('users')
            ->where('role', 'dospem')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('kaprodi.pengajuan.show', compact('detail', 'daftarDosen'));
    }

    // =====================================
    // RIWAYAT KEPUTUSAN KAPRODI
    // =====================================
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
            ->leftJoin(
                'surat_pengesahan as surat',
                'surat.pengajuan_id',
                '=',
                'pengajuan.id'
            )
            ->where('pengajuan.status', 'ACC Final');

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

    // =====================================
    // DASHBOARD KAPRODI
    // =====================================
    public function index(Request $request): View
    {
        abort_unless($request->user()->role === 'kaprodi', 403);

        $baseQuery = DB::table('pengajuan_judul as pengajuan')
            ->join('users as mahasiswa', 'mahasiswa.id', '=', 'pengajuan.mahasiswa_id')
            ->join('users as dospem_1', 'dospem_1.id', '=', 'pengajuan.dospem_1_id')
            ->join('users as dospem_2', 'dospem_2.id', '=', 'pengajuan.dospem_2_id');

        $approvalStatuses = [
            'menunggu',
            'ACC Dospem',
            'ACC Dosen',
            'disetujui',
        ];

        $menungguCount = DB::table('pengajuan_judul')
            ->whereIn('status', $approvalStatuses)
            ->count();

        $disahkanCount = DB::table('pengajuan_judul')
            ->where('status', 'ACC Final')
            ->count();

        $statistics = [
            'menunggu' => $menungguCount,
            'disahkan' => $disahkanCount,
            'total_diproses' => $menungguCount + $disahkanCount,
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
            ->leftJoin(
                'surat_pengesahan as surat',
                'surat.pengajuan_id',
                '=',
                'pengajuan.id'
            )
            ->where('pengajuan.status', 'ACC Final')
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

        return view('kaprodi.dashboard', compact(
            'statistics',
            'menungguPengesahan',
            'riwayat'
        ));
    }

    // =====================================
    // TAHAP 1: KAPRODI MENUNJUK DOSPEM
    // =====================================
    public function tunjukDospem(
        Request $request,
        int $pengajuan
    ): RedirectResponse {
        abort_unless($request->user()->role === 'kaprodi', 403);

        $validated = $request->validate([
            'dospem_final_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where('role', 'dospem'),
            ],
        ]);

        $message = DB::transaction(function () use ($pengajuan, $validated): string {
            $data = DB::table('pengajuan_judul')
                ->where('id', $pengajuan)
                ->lockForUpdate()
                ->first();

            abort_if($data === null, 404);

            abort_unless(
                in_array($data->status, ['menunggu', 'disetujui'], true),
                422,
                'Pengajuan ini tidak dapat menerima penunjukan dosen.'
            );

            $isLegacyApproval = $data->status === 'disetujui';

            abort_unless(
                !$isLegacyApproval || $data->dospem_final_id === null,
                422,
                'Dosen final untuk pengajuan lama sudah ditunjuk.'
            );

            DB::table('pengajuan_judul')
                ->where('id', $pengajuan)
                ->update([
                    'dospem_final_id' => $validated['dospem_final_id'],
                    'status' => $isLegacyApproval
                        ? $data->status
                        : 'Menunggu Review Dospem',
                    'updated_at' => now(),
                ]);

            return $isLegacyApproval
                ? 'Dosen final berhasil ditunjuk. Pengajuan lama siap disahkan.'
                : 'Dosen berhasil ditunjuk. Pengajuan diteruskan ke dosen pembimbing.';
        });

        return redirect()
            ->route('kaprodi.dashboard')
            ->with('success', $message);
    }

    // =====================================
    // TAHAP 2: KAPRODI MENGESAHKAN JUDUL
    // SETELAH DOSPEM MEMBERIKAN ACC
    // =====================================
    public function sahkan(
        Request $request,
        int $pengajuan
    ): RedirectResponse {
        abort_unless($request->user()->role === 'kaprodi', 403);

        DB::transaction(function () use ($pengajuan, $request): void {
            $data = DB::table('pengajuan_judul')
                ->where('id', $pengajuan)
                ->lockForUpdate()
                ->first();

            abort_if($data === null, 404);

            // Hanya pengajuan yang sudah ACC Dospem yang dapat disahkan.
            abort_unless(
                in_array($data->status, [
                    'ACC Dospem',
                    'ACC Dosen',
                    'disetujui',
                ], true),
                422,
                'Pengajuan ini belum mendapatkan ACC dari dosen pembimbing.'
            );

            // Dosen harus sudah ditunjuk Kaprodi.
            abort_unless(
                $data->dospem_final_id !== null,
                422,
                'Dosen pembimbing belum ditunjuk oleh Kaprodi.'
            );

            $now = now();
            $nomorSk = sprintf(
                'SK/%s/%06d',
                $now->format('Y'),
                $data->id
            );

            DB::table('pengajuan_judul')
                ->where('id', $data->id)
                ->update([
                    'status' => 'ACC Final',
                    'updated_at' => $now,
                ]);

            DB::table('surat_pengesahan')->updateOrInsert(
                ['pengajuan_id' => $data->id],
                [
                    'kaprodi_id' => $request->user()->id,
                    'dospem_1_id' => $data->dospem_1_id,
                    'dospem_2_id' => $data->dospem_2_id,
                    'nomor_sk' => $nomorSk,
                    'tanggal_disetujui' => $now->toDateString(),
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        });

        return redirect()
            ->route('kaprodi.dashboard')
            ->with(
                'success',
                'Judul berhasil disahkan dan nomor SK telah dibuat.'
            );
    }
}