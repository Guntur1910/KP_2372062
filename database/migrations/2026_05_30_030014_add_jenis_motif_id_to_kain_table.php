<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('jenis_motif')->insert([
            ['nama' => 'flora', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'fauna', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'manusia', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'geometrik', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Schema::table('kain', function (Blueprint $table) {
            $table->foreignId('jenis_motif_id')->nullable()->constrained('jenis_motif')->onDelete('set null');
        });

        DB::statement("
            UPDATE kain SET jenis_motif_id = (
                SELECT id FROM jenis_motif WHERE nama = kain.jenis_motif
            )
        ");

        Schema::table('kain', function (Blueprint $table) {
            $table->dropColumn('jenis_motif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kain', function (Blueprint $table) {
            $table->string('jenis_motif')->nullable();
            $table->dropForeign(['jenis_motif_id']);
            $table->dropColumn('jenis_motif_id');
        });
    }
};
