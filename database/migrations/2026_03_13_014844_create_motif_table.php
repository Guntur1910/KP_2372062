<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motif', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kain')->constrained('kain', 'id_kain')->onDelete('cascade');
            $table->string('nama_motif');
            $table->string('gambar')->nullable();
            $table->string('link_drive_utuh')->nullable();
            $table->string('link_drive_vektor')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('simbol')->nullable();
            $table->string('penempatan')->nullable();
            $table->string('sumber')->nullable();
            $table->enum('peruntukan', ['raja', 'ratu', 'umum'])->nullable();
            $table->string('arah_penggunaan')->nullable();
            $table->string('bentuk_geometri')->nullable();
            $table->enum('tarikan_visual', ['garis', 'garis dan lengkung'])->nullable();
            $table->enum('simetris', ['bilateral', 'tidak simetris'])->nullable();
            $table->string('asal_daerah')->nullable();
            $table->enum('pewarna', ['buatan', 'alami'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motif');
    }
};