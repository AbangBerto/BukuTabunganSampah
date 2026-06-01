<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kepala_keluarga_id')->constrained('kepala_keluargas')->onDelete('cascade');
            $table->enum('jenis_transaksi', ['Setor', 'Tarik'])->default('Setor');
            $table->enum('jenis_sampah', ['Plastik', 'Besi', 'Lainnya'])->nullable();
            $table->decimal('berat', 8, 2)->nullable();
            $table->integer('nominal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};