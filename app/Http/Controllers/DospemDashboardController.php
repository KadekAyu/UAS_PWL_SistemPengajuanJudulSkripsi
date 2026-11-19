<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DospemDashboardController extends Controller
{
    // =====================================
    // DASHBOARD DOSEN PEMBIMBING
    // =====================================
    public function index()
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'dospem', 403);

        // Ambil seluruh pengajuan yang memilih dosen ini.
        $pengajuan = DB::table('pengajuan_judul as p')
            ->join('users as m', 'p.mahasiswa_id', '=', 'm.id')
            ->where(function ($query) use ($user) {
                $query->where('p.dospem_1_id', $user->id)
                      ->orWhere('p.dospem_2_id', $user->id);
            })
            ->select(
                'p.*',
                'm.name as nama_mahasiswa',
                'm.npm as npm_mahasiswa'
            )
            ->orderByDesc('p.created_at')
            ->get();

        // Membantu pengecekan status tanpa membedakan huruf besar/kecil.
        $statusAdalah = function ($item, array $pilihan) {
            return in_array(
                strtolower(trim($item->status ?? '')),
                $pilihan,
                true
            );
        };

        // Pengajuan yang masih menunggu pemeriksaan.
        $pengajuanMasuk = $pengajuan
            ->filter(fn ($item) =>
                $statusAdalah($item, ['menunggu', 'pending'])
            )
            ->values();

        // Riwayat review per dosen belum diimplementasikan.
        // Tidak menggunakan status global sebagai bukti review dosen.
        $riwayat = collect();

        // Statistik dashboard.
        $statistics = [
            'total' => $pengajuan->count(),

            'pending' => $pengajuanMasuk->count(),

            'disetujui' => $pengajuan
                ->filter(fn ($item) =>
                    $statusAdalah($item, ['acc', 'disetujui'])
                )->count(),

            'revisi' => $pengajuan
                ->filter(fn ($item) =>
                    $statusAdalah($item, ['revisi'])
                )->count(),

            'ditolak' => $pengajuan
                ->filter(fn ($item) =>
                    $statusAdalah($item, ['ditolak'])
                )->count(),
        ];

        return view('dospem.dashboard', compact(
            'user',
            'pengajuan',
            'pengajuanMasuk',
            'riwayat',
            'statistics'
        ));
    }

    // =====================================
    // HALAMAN PENGAJUAN MASUK
    // =====================================
    public function pengajuanMasuk()
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'dospem', 403);

        $pengajuanMasuk = DB::table('pengajuan_judul as p')
            ->join('users as m', 'p.mahasiswa_id', '=', 'm.id')
            ->where(function ($query) use ($user) {
                $query->where('p.dospem_1_id', $user->id)
                      ->orWhere('p.dospem_2_id', $user->id);
            })
            ->whereIn('p.status', [
                'menunggu',
                'Menunggu',
                'pending',
                'Pending'
            ])
            ->select(
                'p.*',
                'm.name as nama_mahasiswa',
                'm.npm as npm_mahasiswa'
            )
            ->orderByDesc('p.created_at')
            ->get();

        return view('dospem.pengajuan.index', compact(
            'user',
            'pengajuanMasuk'
        ));
    }

    // =====================================
    // HALAMAN DETAIL PENGAJUAN
    // =====================================
    public function detail($id)
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'dospem', 403);

        // Hanya dapat melihat pengajuan yang memilih
        // dosen login sebagai Dospem 1 atau Dospem 2.
        $pengajuan = DB::table('pengajuan_judul as p')
            ->join('users as m', 'p.mahasiswa_id', '=', 'm.id')
            ->leftJoin('users as d1', 'p.dospem_1_id', '=', 'd1.id')
            ->leftJoin('users as d2', 'p.dospem_2_id', '=', 'd2.id')
            ->where('p.id', $id)
            ->where(function ($query) use ($user) {
                $query->where('p.dospem_1_id', $user->id)
                      ->orWhere('p.dospem_2_id', $user->id);
            })
            ->select(
                'p.*',
                'm.name as nama_mahasiswa',
                'm.npm as npm_mahasiswa',
                'm.email as email_mahasiswa',
                'd1.name as nama_dospem_1',
                'd2.name as nama_dospem_2'
            )
            ->first();

        // Pengajuan tidak ditemukan atau bukan milik dosen login.
        abort_unless($pengajuan, 404);

        // Cek ketersediaan PDF di penyimpanan project baru.
        $proposalTersedia = !empty($pengajuan->file_proposal)
            && Storage::disk('public')->exists(
                $pengajuan->file_proposal
            );

        return view('dospem.pengajuan.detail', compact(
            'user',
            'pengajuan',
            'proposalTersedia'
        ));
    }

    // =====================================
    // MELIHAT PROPOSAL PDF
    // =====================================
    public function proposal($id)
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'dospem', 403);

        // Pastikan pengajuan memang ditujukan kepada dosen login.
        $pengajuan = DB::table('pengajuan_judul')
            ->where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where('dospem_1_id', $user->id)
                      ->orWhere('dospem_2_id', $user->id);
            })
            ->first();

        abort_unless($pengajuan, 404);

        $path = $pengajuan->file_proposal;

        abort_unless(
            $path && Storage::disk('public')->exists($path),
            404,
            'File proposal tidak ditemukan.'
        );

        return Storage::disk('public')->response(
            $path,
            'Proposal-Pengajuan-' . $pengajuan->id . '.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }

    // =====================================
    // HALAMAN RIWAYAT REVIEW DOSPEM
    // =====================================
    public function riwayatReview()
    {
        $user = Auth::user();

        // Hanya Dosen Pembimbing yang dapat mengakses.
        abort_unless($user && $user->role === 'dospem', 403);

        // Backend penyimpanan keputusan review belum dibuat.
        // Untuk tahap UI, tampilkan daftar kosong terlebih dahulu.
        $riwayat = collect();

        return view('dospem.riwayat', compact(
            'user',
            'riwayat'
        ));
    }

    
    // =====================================
    // HALAMAN PROFIL DOSEN PEMBIMBING
    // =====================================
    public function profil()
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'dospem', 403);

        return view('dospem.profil', compact('user'));
    }

}