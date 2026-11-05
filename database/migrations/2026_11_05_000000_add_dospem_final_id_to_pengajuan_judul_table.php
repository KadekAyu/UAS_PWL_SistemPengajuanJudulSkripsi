<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan_judul', function (Blueprint $table) {
            $table->foreignId('dospem_final_id')
                ->nullable()
                ->after('dospem_2_id')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan_judul', function (Blueprint $table) {
            $table->dropConstrainedForeignId('dospem_final_id');
        });
    }
};
