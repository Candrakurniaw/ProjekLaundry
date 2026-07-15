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
            $table->string('kode_transaksi')->unique();
            $table->foreignId('pelanggan_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->enum('status', ['proses', 'selesai', 'diambil'])->default('proses');
            $table->text('catatan')->nullable();
            $table->date('tanggal_masuk');
            $table->date('tanggal_selesai_estimasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
