<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simetris extends Model
{
    protected $table = 'simetris';
    protected $fillable = ['nama'];

    public function motifs()
    {
        return $this->hasMany(Motif::class, 'simetris_id');
    }
}