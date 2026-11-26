<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DospemDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'dospem', 403);

        $pengajuan = DB::table('pengajuan_judul as p')
            ->join('users as mahasiswa', 'p.mahasiswa_id', '=', 'mahasiswa.id')
            ->leftJoin('users as dospem1', 'p.dospem_1_id', '=', 'dospem1.id')
            ->leftJoin('users as dospem2', 'p.dospem_2_id', '=', 'dospem2.id')
            ->where(function ($query) use ($user) {
                $query->where('p.dospem_1_id', $user->id)
                    ->orWhere('p.dospem_2_id', $user->id);
            })
            ->select(
                'p.*',
                'mahasiswa.name as nama_mahasiswa',
                'mahasiswa.npm',
                'dospem1.name as nama_dospem_1',
                'dospem2.name as nama_dospem_2'
            )
            ->latest('p.created_at')
            ->get();

        $totalPengajuan = $pengajuan->count();

        $pengajuanMenunggu = $pengajuan->whereIn('status', [
            'Menunggu',
            'Pending',
            'menunggu',
            'Menunggu Persetujuan Dospem',
        ])->count();

        $pengajuanDisetujui = $pengajuan->whereIn('status', [
            'ACC Dospem',
            'ACC Dosen',
            'Menunggu Persetujuan Kaprodi',
            'ACC Final',
            'disetujui',
        ])->count();

        $pengajuanDitolak = $pengajuan->whereIn('status', [
            'Ditolak',
            'ditolak',
        ])->count();

        $pengajuanMasuk = $pengajuan->whereIn('status', [
            'Menunggu',
            'Pending',
            'menunggu',
            'Menunggu Persetujuan Dospem',
        ]);

        $riwayat = collect();

        return view('dospem.dashboard', compact(
            'user',
            'pengajuan',
            'totalPengajuan',
            'pengajuanMenunggu',
            'pengajuanDisetujui',
            'pengajuanDitolak',
            'pengajuanMasuk',
            'riwayat'
        ));
    }

    public function pengajuanMasuk()
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'dospem', 403);

        $pengajuanMasuk = DB::table('pengajuan_judul as p')
            ->join('users as mahasiswa', 'p.mahasiswa_id', '=', 'mahasiswa.id')
            ->leftJoin('users as dospem1', 'p.dospem_1_id', '=', 'dospem1.id')
            ->leftJoin('users as dospem2', 'p.dospem_2_id', '=', 'dospem2.id')
            ->where(function ($query) use ($user) {
                $query->where('p.dospem_1_id', $user->id)
                    ->orWhere('p.dospem_2_id', $user->id);
            })
            ->whereIn('p.status', [
                'Menunggu',
                'Pending',
                'menunggu',
                'Menunggu Persetujuan Dospem',
            ])
            ->select(
                'p.*',
                'mahasiswa.name as nama_mahasiswa',
                'mahasiswa.npm',
                'dospem1.name as nama_dospem_1',
                'dospem2.name as nama_dospem_2'
            )
            ->latest('p.created_at')
            ->get();

        return view('dospem.pengajuan.index', compact(
            'user',
            'pengajuanMasuk'
        ));
    }

    public function detail($id)
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'dospem', 403);

        $pengajuan = DB::table('pengajuan_judul as p')
            ->join('users as mahasiswa', 'p.mahasiswa_id', '=', 'mahasiswa.id')
            ->leftJoin('users as dospem1', 'p.dospem_1_id', '=', 'dospem1.id')
            ->leftJoin('users as dospem2', 'p.dospem_2_id', '=', 'dospem2.id')
            ->where('p.id', $id)
            ->where(function ($query) use ($user) {
                $query->where('p.dospem_1_id', $user->id)
                    ->orWhere('p.dospem_2_id', $user->id);
            })
            ->select(
                'p.*',
                'mahasiswa.name as nama_mahasiswa',
                'mahasiswa.npm',
                'mahasiswa.email',
                'dospem1.name as nama_dospem_1',
                'dospem2.name as nama_dospem_2'
            )
            ->first();

        abort_unless($pengajuan, 404);

        $proposalTersedia = $pengajuan->file_proposal
            && Storage::disk('public')->exists($pengajuan->file_proposal);

        $catatanRevisi = DB::table('catatan_revisi as cr')
            ->join('users as dosen', 'cr.dosen_id', '=', 'dosen.id')
            ->where('cr.pengajuan_id', $id)
            ->select(
                'cr.*',
                'dosen.name as nama_dosen'
            )
            ->latest('cr.created_at')
            ->get();

        return view('dospem.pengajuan.detail', compact(
            'user',
            'pengajuan',
            'proposalTersedia',
            'catatanRevisi'
        ));
    }

    public function review(Request $request, $id)
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'dospem', 403);

        $validated = $request->validate([
            'status' => 'required|in:ACC,Revisi,Ditolak',
            'catatan' => [
                'nullable',
                'string',
                'required_if:status,Revisi,Ditolak',
            ],
        ], [
            'status.required' => 'Silakan pilih keputusan review.',
            'status.in' => 'Keputusan review tidak valid.',
            'catatan.required_if' => 'Catatan wajib diisi untuk keputusan revisi atau penolakan.',
            'catatan.string' => 'Catatan review harus berupa teks.',
        ]);

        $pengajuan = DB::table('pengajuan_judul')
            ->where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where('dospem_1_id', $user->id)
                    ->orWhere('dospem_2_id', $user->id);
            })
            ->first();

        abort_unless($pengajuan, 404);

        // Petakan keputusan review ke nilai status yang sesuai di alur aplikasi
        $statusPengajuan = match ($validated['status']) {
            'ACC' => 'disetujui',
            'Revisi' => 'revisi',
            'Ditolak' => 'ditolak',
        };

        $now = now();

        DB::transaction(function () use ($id, $user, $validated, $statusPengajuan, $now) {
            DB::table('catatan_revisi')->insert([
                'pengajuan_id' => $id,
                'dosen_id' => $user->id,
                'catatan' => $validated['catatan'] ?? '-',
                'status' => $validated['status'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('pengajuan_judul')
                ->where('id', $id)
                ->update([
                    'status' => $statusPengajuan,
                    'updated_at' => $now,
                ]);
        });

        return redirect()
            ->route('dospem.pengajuan.detail', $id)
            ->with('success', 'Catatan dan keputusan review berhasil dikirim kepada mahasiswa.');
    }

    public function proposal($id)
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'dospem', 403);

        $pengajuan = DB::table('pengajuan_judul')
            ->where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where('dospem_1_id', $user->id)
                    ->orWhere('dospem_2_id', $user->id);
            })
            ->first();

        abort_unless($pengajuan, 404);

        $proposalPath = $pengajuan->file_proposal;

        abort_unless(
            $proposalPath && Storage::disk('public')->exists($proposalPath),
            404
        );

        return response()->file(
            Storage::disk('public')->path($proposalPath),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Proposal-Pengajuan-' . $pengajuan->id . '.pdf"',
            ]
        );
    }

    public function riwayatReview()
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'dospem', 403);

        $riwayat = DB::table('catatan_revisi as cr')
            ->join('pengajuan_judul as p', 'cr.pengajuan_id', '=', 'p.id')
            ->join('users as mahasiswa', 'p.mahasiswa_id', '=', 'mahasiswa.id')
            ->where('cr.dosen_id', $user->id)
            ->select(
                'cr.*',
                'p.judul',
                'mahasiswa.name as nama_mahasiswa',
                'mahasiswa.npm'
            )
            ->latest('cr.updated_at')
            ->get();

        return view('dospem.riwayat', compact('user', 'riwayat'));
    }

    public function mahasiswaBimbingan()
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'dospem', 403);

        $mahasiswaBimbingan = DB::table('pengajuan_judul as p')
            ->join('users as mahasiswa', 'p.mahasiswa_id', '=', 'mahasiswa.id')
            ->leftJoin('surat_pengesahan as sp', 'p.id', '=', 'sp.pengajuan_id')
            ->where(function ($query) use ($user) {
                $query->where('p.dospem_1_id', $user->id)
                    ->orWhere('p.dospem_2_id', $user->id);
            })
            ->whereIn('p.status', ['ACC Final', 'disetujui'])
            ->select(
                'p.*',
                'mahasiswa.name as nama_mahasiswa',
                'mahasiswa.npm',
                'mahasiswa.email',
                'sp.nomor_sk'
            )
            ->latest('p.updated_at')
            ->get()
            ->map(function ($item) use ($user) {
                $item->posisi_dospem = $item->dospem_1_id == $user->id
                    ? 'Dosen Pembimbing 1'
                    : 'Dosen Pembimbing 2';

                return $item;
            });

        return view('dospem.mahasiswa-bimbingan', compact(
            'user',
            'mahasiswaBimbingan'
        ));
    }

    public function profil()
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'dospem', 403);

        return view('dospem.profil', compact('user'));
    }
}