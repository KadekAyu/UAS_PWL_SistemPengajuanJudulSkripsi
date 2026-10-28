<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_pengesahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->unique()->constrained('pengajuan_judul')->cascadeOnDelete();
            $table->foreignId('kaprodi_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('dospem_1_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('dospem_2_id')->constrained('users')->restrictOnDelete();
            $table->string('nomor_sk');
            $table->date('tanggal_disetujui');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_pengesahan');
    }
};