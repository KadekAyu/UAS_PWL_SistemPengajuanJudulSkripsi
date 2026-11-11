<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class PengajuanJudulController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        abort_unless($user->role === 'mahasiswa', 403);

        $dosenPembimbing = User::whereIn('role', [
            'dosen',
            'dospem',
            'dosen_pembimbing',
        ])->orderBy('name')->get();

        return view('mahasiswa.pengajuan.create', compact('dosenPembimbing'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        abort_unless($user->role === 'mahasiswa', 403);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'abstrak' => 'required|string',
            'dospem_1_id' => 'required|different:dospem_2_id|exists:user,id',
            'dospem_2_id' => 'required|exists:user,id',
            'file_proposal' => 'required|file|mimes:pdf|max:5120',
        ]);

        $dospem1 = User::findOrFail($validated['dospem_1_id']);
        $dospem2 = User::findOrFail($validated['dospem_2_id']);

        $file = $request->file('file_proposal')
            ->store('proposal', 'public');

        DB::table('pengajuan_judul')->insert([
            'user_id' => $user->id,
            'nama_mahasiswa' => $user->name,
            'npm' => $user->npm,
            'judul' => $validated['judul'],
            'abstrak' => $validated['abstrak'],
            'dospem_1_id' => $dospem1->id,
            'dospem_2_id' => $dospem2->id,
            'nama_dospem_1' => $dospem1->name,
            'nama_dospem_2' => $dospem2->name,
            'file_proposal' => $file,
            'status' => 'menunggu',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('mahasiswa.dashboard')
            ->with('success', 'Pengajuan judul berhasil dikirim.');
    }
}