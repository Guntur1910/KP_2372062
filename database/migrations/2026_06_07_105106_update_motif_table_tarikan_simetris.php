<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('tarikan_visual')->insert([
            ['nama' => 'garis', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'garis dan lengkung', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('simetris')->insert([
            ['nama' => 'bilateral', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'tidak simetris', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Schema::table('motif', function (Blueprint $table) {
            $table->foreignId('tarikan_visual_id')->nullable()->constrained('tarikan_visual')->onDelete('set null');
            $table->foreignId('simetris_id')->nullable()->constrained('simetris')->onDelete('set null');
        });

        DB::statement("
            UPDATE motif SET tarikan_visual_id = (
                SELECT id FROM tarikan_visual WHERE nama = motif.tarikan_visual
            )
        ");

        DB::statement("
            UPDATE motif SET simetris_id = (
                SELECT id FROM simetris WHERE nama = motif.simetris
            )
        ");

        Schema::table('motif', function (Blueprint $table) {
            $table->dropColumn(['tarikan_visual', 'simetris']);
        });
    }

    public function down(): void
    {
        Schema::table('motif', function (Blueprint $table) {
            $table->enum('tarikan_visual', ['garis', 'garis dan lengkung'])->nullable();
            $table->enum('simetris', ['bilateral', 'tidak simetris'])->nullable();
            $table->dropForeign(['tarikan_visual_id']);
            $table->dropForeign(['simetris_id']);
            $table->dropColumn(['tarikan_visual_id', 'simetris_id']);
        });
    }
};
