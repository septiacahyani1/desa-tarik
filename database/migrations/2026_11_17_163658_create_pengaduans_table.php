<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori'); // Infrastruktur Jalan, Lingkungan, Fasilitas Umum
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->string('status')->default('Menunggu'); // Menunggu, Diproses, Selesai
            $table->text('tanggapan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};