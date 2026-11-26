<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\User;

class PengajuanJudulController extends Controller
{
    private const DOSEN_ROLES = [
        'dosen',
        'dospem',
        'dosen_pembimbing',
    ];

    // Mengembalikan true jika mahasiswa masih memiliki pengajuan yang belum berstatus ditolak
    private function hasUnrejectedSubmission(int $mahasiswaId): bool
    {
        return DB::table('pengajuan_judul')
            ->where('mahasiswa_id', $mahasiswaId)
            ->whereRaw('LOWER(status) != ?', ['ditolak'])
            ->exists();
    }

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

        return view('mahasiswa.dashboard', compact(
            'user',
            'pengajuan',
            'statistics'
        ));
    }

    // MENAMPILKAN FORM PENGAJUAN JUDUL
    public function create()
    {
        $user = Auth::user();

        abort_unless($user->role === 'mahasiswa', 403);

        $hasUnrejectedSubmission = $this->hasUnrejectedSubmission($user->id);

        $dosenList = User::whereIn('role', self::DOSEN_ROLES)
            ->orderBy('name')
            ->get();

        return view('mahasiswa.pengajuan.create', compact(
            'user',
            'dosenList',
            'hasUnrejectedSubmission'
        ));
    }

    // MENYIMPAN PENGAJUAN JUDUL BARU
    public function store(Request $request)
    {
        $user = Auth::user();

        abort_unless($user->role === 'mahasiswa', 403);

        if ($this->hasUnrejectedSubmission($user->id)) {
            return redirect()
                ->route('mahasiswa.riwayat')
                ->with('error', 'Pengajuan judul baru ditolak karena masih ada pengajuan yang belum berstatus ditolak.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'abstrak' => 'required|string',

            'dospem_1_id' => [
                'required',
                'different:dospem_2_id',
                Rule::exists('users', 'id')->whereIn('role', self::DOSEN_ROLES),
            ],

            'dospem_2_id' => [
                'required',
                'different:dospem_1_id',
                Rule::exists('users', 'id')->whereIn('role', self::DOSEN_ROLES),
            ],

            'file_proposal' => 'required|file|mimes:pdf|max:5120',
        ]);

        $originalName = $request->file('file_proposal')->getClientOriginalName();
        $fileName = time() . '_' . $originalName;

        $file = $request->file('file_proposal')
            ->storeAs('proposal', $fileName, 'public');

        DB::table('pengajuan_judul')->insert([
            'mahasiswa_id' => $user->id,
            'judul' => $validated['judul'],
            'abstrak' => $validated['abstrak'],
            'file_proposal' => $file,
            'dospem_1_id' => $validated['dospem_1_id'],
            'dospem_2_id' => $validated['dospem_2_id'],
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

        return view('mahasiswa.riwayat', compact(
            'user',
            'pengajuan'
        ));
    }

    // MENAMPILKAN DETAIL PENGAJUAN JUDUL
    public function show($id)
    {
        $user = Auth::user();

        abort_unless($user->role === 'mahasiswa', 403);

        $pengajuan = DB::table('pengajuan_judul')
            ->leftJoin(
                'users as dospem1',
                'pengajuan_judul.dospem_1_id',
                '=',
                'dospem1.id'
            )
            ->leftJoin(
                'users as dospem2',
                'pengajuan_judul.dospem_2_id',
                '=',
                'dospem2.id'
            )
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

        $catatanRevisi = DB::table('catatan_revisi')
            ->join(
                'users',
                'catatan_revisi.dosen_id',
                '=',
                'users.id'
            )
            ->select(
                'catatan_revisi.*',
                'users.name as nama_dosen'
            )
            ->where('catatan_revisi.pengajuan_id', $id)
            ->orderBy('catatan_revisi.created_at', 'desc')
            ->get();

        return view('mahasiswa.pengajuan.detail', compact(
            'user',
            'pengajuan',
            'catatanRevisi'
        ));
    }

    // MENAMPILKAN FORM EDIT / REVISI PENGAJUAN
    public function edit($id)
    {
        $user = Auth::user();

        abort_unless($user->role === 'mahasiswa', 403);

        $pengajuan = DB::table('pengajuan_judul')
            ->leftJoin(
                'users as dospem1',
                'pengajuan_judul.dospem_1_id',
                '=',
                'dospem1.id'
            )
            ->leftJoin(
                'users as dospem2',
                'pengajuan_judul.dospem_2_id',
                '=',
                'dospem2.id'
            )
            ->select(
                'pengajuan_judul.*',
                'dospem1.name as dospem_1_nama',
                'dospem2.name as dospem_2_nama'
            )
            ->where('pengajuan_judul.id', $id)
            ->where('pengajuan_judul.mahasiswa_id', $user->id)
            ->first();

        if (!$pengajuan || $pengajuan->status !== 'revisi') {
            abort(403, 'Pengajuan tidak dapat direvisi.');
        }

        // Mengambil daftar dosen untuk tampilan informasi Dospem 1 dan 2
        $daftarDosen = User::whereIn('role', self::DOSEN_ROLES)
            ->orderBy('name')
            ->get();

        return view('mahasiswa.pengajuan.edit', compact(
            'user',
            'pengajuan',
            'daftarDosen'
        ));
    }

    // MENYIMPAN PERUBAHAN / REVISI PENGAJUAN
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        abort_unless($user->role === 'mahasiswa', 403);

        $pengajuan = DB::table('pengajuan_judul')
            ->where('id', $id)
            ->where('mahasiswa_id', $user->id)
            ->first();

        if (!$pengajuan || $pengajuan->status !== 'revisi') {
            abort(403, 'Pengajuan tidak dapat diperbarui.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'abstrak' => 'required|string',
            'file_proposal' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        // Menggunakan file lama jika mahasiswa tidak mengunggah file baru
        $filePath = $pengajuan->file_proposal;

        if ($request->hasFile('file_proposal')) {
            $originalName = $request->file('file_proposal')->getClientOriginalName();
            $fileName = time() . '_' . $originalName;

            $newFilePath = $request->file('file_proposal')
                ->storeAs('proposal', $fileName, 'public');

            // Hapus file lama setelah file baru berhasil disimpan
            if ($newFilePath && $filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            $filePath = $newFilePath;
        }

        DB::table('pengajuan_judul')
            ->where('id', $id)
            ->update([
                'judul' => $validated['judul'],
                'abstrak' => $validated['abstrak'],
                'file_proposal' => $filePath,
                'dospem_1_id' => $pengajuan->dospem_1_id,
                'dospem_2_id' => $pengajuan->dospem_2_id,
                'status' => 'menunggu',
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('mahasiswa.pengajuan.show', $id)
            ->with(
                'success',
                'Revisi pengajuan berhasil dikirim dan menunggu tinjauan dosen.'
            );
    }

    // CETAK SURAT PENGESAHAN (HANYA SETELAH DISAHKAN KAPRODI)
    public function cetakSurat($id)
    {
        $user = Auth::user();

        abort_unless($user->role === 'mahasiswa', 403);

        $pengajuan = DB::table('pengajuan_judul')
            ->leftJoin(
                'users as dospem1',
                'pengajuan_judul.dospem_1_id',
                '=',
                'dospem1.id'
            )
            ->leftJoin(
                'users as dospem2',
                'pengajuan_judul.dospem_2_id',
                '=',
                'dospem2.id'
            )
            ->leftJoin(
                'users as dospem_final',
                'pengajuan_judul.dospem_final_id',
                '=',
                'dospem_final.id'
            )
            ->leftJoin(
                'surat_pengesahan as surat',
                'surat.pengajuan_id',
                '=',
                'pengajuan_judul.id'
            )
            ->select(
                'pengajuan_judul.*',
                'dospem1.name as dospem_1_nama',
                'dospem2.name as dospem_2_nama',
                'dospem_final.name as dospem_final_nama',
                'surat.nomor_sk',
                'surat.tanggal_disetujui'
            )
            ->where('pengajuan_judul.id', $id)
            ->where('pengajuan_judul.mahasiswa_id', $user->id)
            ->first();

        $isAccFinal = $pengajuan && strtolower(trim((string) $pengajuan->status)) === 'acc final';

        if (!$isAccFinal) {
            abort(403, 'Surat pengesahan belum tersedia. Pengajuan harus disahkan oleh Kaprodi terlebih dahulu.');
        }

        return view('mahasiswa.pengajuan.surat-pdf', compact(
            'pengajuan',
            'user'
        ));
    }

    // MENAMPILKAN PROFIL MAHASISWA
    public function profil()
    {
        $user = Auth::user();

        abort_unless($user->role === 'mahasiswa', 403);

        return view('mahasiswa.profil', compact('user'));
    }
}