<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kain', function (Blueprint $table) {
            $table->id('id_kain');
            $table->string('nama_kain');
            $table->enum('jenis_motif', ['flora', 'fauna']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kain');
    }
};