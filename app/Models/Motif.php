<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motif extends Model
{
    protected $table = 'motif';
    protected $fillable = [
    'id_kain', 'nama_motif', 'gambar', 'link_drive_utuh',
    'link_drive_vektor', 'deskripsi', 'simbol', 'penempatan',
    'sumber', 'peruntukan', 'arah_penggunaan', 'bentuk_geometri',
    'tarikan_visual_id', 'simetris_id', 'asal_daerah', 'pewarna',
    ];

    public function tarikanVisual()
    {
        return $this->belongsTo(TarikanVisual::class, 'tarikan_visual_id');
    }

    public function simetris()
    {
        return $this->belongsTo(Simetris::class, 'simetris_id');
    }

    public function kain()
    {
        return $this->belongsTo(Kain::class, 'id_kain', 'id_kain');
    }
}