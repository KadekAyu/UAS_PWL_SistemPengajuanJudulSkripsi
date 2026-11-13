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

        $originalName = $request->file('file_proposal')->getClientOriginalName();
        $fileName = time() . '_' . $originalName;
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

    // MENAMPILKAN HALAMAN DETAIL PENGAJUAN JUDUL
    public function show($id)
    {
        $user = Auth::user();

        abort_unless($user->role === 'mahasiswa', 403);

        $pengajuan = DB::table('pengajuan_judul')
            ->leftJoin('users as dospem1', 'pengajuan_judul.dospem_1_id', '=', 'dospem1.id')
            ->leftJoin('users as dospem2', 'pengajuan_judul.dospem_2_id', '=', 'dospem2.id')
            ->select(
                'pengajuan_judul.*',
                'dospem1.name as dospem_1_nama',
                'dospem2.name as dospem_2_nama'
            )
            ->where('pengajuan_judul.id', $id)
            ->where('pengajuan_judul.mahasiswa_id', $user->id)
            ->first();

        if (!$pengajuan) {
            abort(404);
        }

        return view('mahasiswa.pengajuan.detail', compact('user', 'pengajuan'));
    }

    // ==========================================
    // FUNGSI EDIT & UPDATE REVISI
    // ==========================================

    public function edit($id)
    {
        $user = Auth::user();
        abort_unless($user->role === 'mahasiswa', 403);

        $pengajuan = DB::table('pengajuan_judul')
            ->leftJoin('users as dospem1', 'pengajuan_judul.dospem_1_id', '=', 'dospem1.id')
            ->leftJoin('users as dospem2', 'pengajuan_judul.dospem_2_id', '=', 'dospem2.id')
            ->select(
                'pengajuan_judul.*',
                'dospem1.name as dospem_1_nama',
                'dospem2.name as dospem_2_nama'
            )
            ->where('pengajuan_judul.id', $id)
            ->where('mahasiswa_id', $user->id)
            ->first();

        if (!$pengajuan || $pengajuan->status !== 'revisi') {
            abort(403, 'Pengajuan tidak dapat direvisi.');
        }

        return view('mahasiswa.pengajuan.edit', compact('user', 'pengajuan'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        abort_unless($user->role === 'mahasiswa', 403);

        $pengajuan = DB::table('pengajuan_judul')
            ->where('id', $id)
            ->where('mahasiswa_id', $user->id)
            ->first();

        if (!$pengajuan || $pengajuan->status !== 'revisi') {
            abort(403);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'abstrak' => 'required|string',
            'dospem_1_id' => 'required|exists:users,id',
            'dospem_2_id' => 'required|exists:users,id',
            'file_proposal' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $filePath = $pengajuan->file_proposal;

        if ($request->hasFile('file_proposal')) {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            $originalName = $request->file('file_proposal')->getClientOriginalName();
            $fileName = time() . '_' . $originalName;
            $filePath = $request->file('file_proposal')->storeAs('proposal', $fileName, 'public');
        }

        DB::table('pengajuan_judul')->where('id', $id)->update([
            'judul' => $validated['judul'],
            'abstrak' => $validated['abstrak'],
            'dospem_1_id' => $validated['dospem_1_id'],
            'dospem_2_id' => $validated['dospem_2_id'],
            'file_proposal' => $filePath,
            'status' => 'menunggu',
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('mahasiswa.pengajuan.show', $id)
            ->with('success', 'Revisi pengajuan berhasil dikirim dan menunggu tinjauan dosen.');
    }

    // ==========================================
    // FUNGSI PROFIL MAHASISWA
    // ==========================================

    public function profil()
    {
        $user = Auth::user();
        abort_unless($user->role === 'mahasiswa', 403);

        return view('mahasiswa.profil', compact('user'));
    }
}