<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kain extends Model
{
    protected $table = 'kain';
    protected $primaryKey = 'id_kain';
    protected $fillable = ['nama_kain', 'jenis_motif_id'];

    public function motifs()
    {
        return $this->hasMany(Motif::class, 'id_kain', 'id_kain');
    }

    public function jenisMotif()
    {
        return $this->belongsTo(JenisMotif::class, 'jenis_motif_id');
    }
}