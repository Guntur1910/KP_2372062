<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarikanVisual extends Model
{
    protected $table = 'tarikan_visual';
    protected $fillable = ['nama'];

    public function motifs()
    {
        return $this->hasMany(Motif::class, 'tarikan_visual_id');
    }
}