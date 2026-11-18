<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pengesahan Judul Skripsi</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; line-height: 1.6; margin: 40px; color: #000; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h3, .header h2 { margin: 2px; }
        .content { margin-top: 20px; }
        .details { margin: 20px 0; width: 100%; border-collapse: collapse; }
        .details td { padding: 6px 0; vertical-align: top; }
        .footer { margin-top: 50px; float: right; text-align: center; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h3>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</h3>
        <h3>UNIVERSITAS LAMPUNG</h3>
        <h2>FAKULTAS MATEMATIKA DAN ILMU PENGETAHUAN ALAM</h2>
        <h2>PROGRAM STUDI ILMU KOMPUTER</h2>
        <p style="font-size: 12px; margin: 2px;">Jl. Prof. Dr. Soemantri Brodjonegoro No. 1 Bandar Lampung</p>
    </div>

    <div class="content" style="text-align: center;">
        <h3 style="text-decoration: underline; margin-bottom: 5px;">SURAT KETERANGAN PENGESAHAN JUDUL SKRIPSI</h3>
        <p style="margin-top: 0;">Nomor: B / {{ $pengajuan->id }}/UN26.17/DT.01.00/2026</p>
    </div>

    <div class="content">
        <p>Ketua Program Studi Ilmu Komputer Universitas Lampung dengan ini menerangkan bahwa mahasiswa berikut:</p>
        <table class="details">
            <tr>
                <td style="width: 200px;">Nama Mahasiswa</td>
                <td>: <strong>{{ $user->name }}</strong></td>
            </tr>
            <tr>
                <td>NPM</td>
                <td>: <strong>{{ $user->npm ?? '2417051057' }}</strong></td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>: Ilmu Komputer (S1)</td>
            </tr>
            <tr>
                <td>Judul Skripsi Disetujui</td>
                <td>: <strong>{{ $pengajuan->judul }}</strong></td>
            </tr>
        </table>

        <p>Telah disetujui dan ditetapkan untuk dapat melanjutkan ke tahap penyusunan proposal dan penelitian bimbingan dengan dosen pembimbing:</p>
        <ol>
            <li><strong>{{ $pengajuan->dospem_1_nama ?? '-' }}</strong> (Pembimbing 1)</li>
            <li><strong>{{ $pengajuan->dospem_2_nama ?? '-' }}</strong> (Pembimbing 2)</li>
        </ol>

        <p>Demikian surat keterangan pengesahan ini diterbitkan agar dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="footer">
        <p>Bandar Lampung, {{ \Carbon\Carbon::parse($pengajuan->updated_at)->translatedFormat('d F Y') }}</p>
        <p>Ketua Program Studi Ilmu Komputer,</p>
        <br><br><br>
        <p><strong>Dr. Ketua Prodi, S.Kom., M.Cs.</strong><br>NIP. 198001012005011001</p>
    </div>
</body>
</html>