<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisMotif extends Model
{
    protected $table = 'jenis_motif';
    protected $fillable = ['nama'];

    public function kains()
    {
        return $this->hasMany(Kain::class, 'jenis_motif_id');
    }
}