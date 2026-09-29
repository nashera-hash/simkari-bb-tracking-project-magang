<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_buktis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perkara_id')->constrained()->cascadeOnDelete();
            $table->string('kode')->unique();
            $table->string('nama_barang');
            $table->unsignedInteger('jumlah')->default(1);
            $table->string('satuan')->nullable();
            $table->string('kondisi')->nullable();
            $table->enum('status', ['disimpan', 'dipinjam', 'dilelang', 'dimusnahkan', 'dikembalikan'])->default('disimpan');
            $table->foreignId('gudang_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('rak_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_buktis');
    }
};
