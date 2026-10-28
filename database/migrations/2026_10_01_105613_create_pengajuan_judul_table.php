<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_judul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->cascadeOnDelete();
            $table->string('judul');
            $table->text('abstrak');
            $table->string('file_proposal');
            $table->foreignId('dospem_1_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('dospem_2_id')->constrained('users')->restrictOnDelete();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_judul');
    }
};