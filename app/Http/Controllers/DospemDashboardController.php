<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DospemDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Hanya Dosen Pembimbing yang boleh membuka dashboard.
        abort_unless($user && $user->role === 'dospem', 403);

        // Hanya pengajuan yang memilih dosen yang sedang login.
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
            ->orderBy('p.created_at', 'desc')
            ->get();

        $statusAdalah = function ($item, array $pilihan) {
            return in_array(strtolower(trim($item->status ?? '')), $pilihan, true);
        };

        // Pengajuan masuk hanya berisi pengajuan berstatus menunggu.
        $pengajuanMasuk = $pengajuan
            ->filter(fn ($item) => $statusAdalah($item, ['menunggu', 'pending']))
            ->values();

        // Belum ada tabel keputusan per dosen; jangan menganggap status global
        // sebagai bukti bahwa dosen yang login sudah melakukan review.
        $riwayat = collect();

        $statistics = [
            'total' => $pengajuan->count(),
            'pending' => $pengajuanMasuk->count(),
            'disetujui' => $pengajuan->filter(fn ($item) => $statusAdalah($item, ['acc', 'disetujui']))->count(),
            'revisi' => $pengajuan->filter(fn ($item) => $statusAdalah($item, ['revisi']))->count(),
            'ditolak' => $pengajuan->filter(fn ($item) => $statusAdalah($item, ['ditolak']))->count(),
        ];

        return view('dospem.dashboard', compact(
            'user',
            'pengajuan',
            'pengajuanMasuk',
            'riwayat',
            'statistics'
        ));
    }
    // HALAMAN PENGAJUAN MASUK DOSPEM
    public function pengajuanMasuk()
    {
        $user = Auth::user();

        // Hanya dosen pembimbing yang bisa mengakses
        abort_unless($user && $user->role === 'dospem', 403);

        // Ambil pengajuan yang memilih dosen ini
        $pengajuanMasuk = DB::table('pengajuan_judul as p')
            ->join('users as m', 'p.mahasiswa_id', '=', 'm.id')
            ->where(function ($query) use ($user) {
                $query->where('p.dospem_1_id', $user->id)
                      ->orWhere('p.dospem_2_id', $user->id);
            })
            ->whereIn('p.status', ['menunggu', 'Pending'])
            ->select(
                'p.*',
                'm.name as nama_mahasiswa',
                'm.npm as npm_mahasiswa'
            )
            ->orderBy('p.created_at', 'desc')
            ->get();

        return view('dospem.pengajuan.index', compact(
            'user',
            'pengajuanMasuk'
        ));
    }
}
