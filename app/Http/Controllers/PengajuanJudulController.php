<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class PengajuanJudulController extends Controller
{
    // MENAMPILKAN DASHBOARD MAHASISWA & RIWAYAT PENGAJUAN
    public function index()
    {
        $user = Auth::user();

        abort_unless($user->role === 'mahasiswa', 403);

        $pengajuan = DB::table('pengajuan_judul')
            ->where('mahasiswa_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $statistics = [
            'total' => $pengajuan->count(),
            'pending' => $pengajuan->where('status', 'menunggu')->count(),
            'revisi' => $pengajuan->where('status', 'revisi')->count(),
            'ditolak' => $pengajuan->where('status', 'ditolak')->count(),
        ];

        return view('mahasiswa.dashboard', compact('user', 'pengajuan', 'statistics'));
    }

    public function create()
    {
        $user = Auth::user();

        abort_unless($user->role === 'mahasiswa', 403);

        $dosenList = User::whereIn('role', [
            'dosen',
            'dospem',
            'dosen_pembimbing',
        ])->orderBy('name')->get();

        return view('mahasiswa.pengajuan.create', compact('dosenList'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        abort_unless($user->role === 'mahasiswa', 403);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'abstrak' => 'required|string',
            'dospem_1_id' => 'required|different:dospem_2_id|exists:users,id',
            'dospem_2_id' => 'required|exists:users,id',
            'file_proposal' => 'required|file|mimes:pdf|max:5120',
        ]);

        $dospem1 = User::findOrFail($validated['dospem_1_id']);
        $dospem2 = User::findOrFail($validated['dospem_2_id']);

        // 1. Ambil nama asli file yang di-upload user
        $originalName = $request->file('file_proposal')->getClientOriginalName();
        
        // 2. Beri tambahan timestamp unik di depannya agar nama file di folder server tidak bentrok
        $fileName = time() . '_' . $originalName;

        // 3. Simpan file menggunakan storeAs ke folder storage/app/public/proposal
        $file = $request->file('file_proposal')->storeAs('proposal', $fileName, 'public');

        DB::table('pengajuan_judul')->insert([
            'mahasiswa_id' => $user->id,
            'judul' => $validated['judul'],
            'abstrak' => $validated['abstrak'],
            'file_proposal' => $file,
            'dospem_1_id' => $dospem1->id,
            'dospem_2_id' => $dospem2->id,
            'status' => 'menunggu',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('mahasiswa.riwayat')
            ->with('success', 'Pengajuan judul berhasil dikirim.');
    }

    // MENAMPILKAN HALAMAN RIWAYAT PENGAJUAN
    public function riwayat()
    {
        $user = Auth::user();

        abort_unless($user->role === 'mahasiswa', 403);

        $pengajuan = DB::table('pengajuan_judul')
            ->where('mahasiswa_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mahasiswa.riwayat', compact('user', 'pengajuan'));
    }
}