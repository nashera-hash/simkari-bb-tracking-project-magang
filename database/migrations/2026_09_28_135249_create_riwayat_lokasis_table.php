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
        Schema::create('riwayat_lokasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_bukti_id')->constrained()->cascadeOnDelete();
            $table->foreignId('gudang_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('rak_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status');
            $table->foreignId('user_id')->constrained();
            $table->text('keterangan')->nullable();
            $table->timestamp('waktu')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_lokasis');
    }
};
