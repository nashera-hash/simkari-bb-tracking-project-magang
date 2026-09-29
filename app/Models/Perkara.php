<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perkara extends Model
{
    protected $guarded = [];

    public const KATEGORI = [
        'narkotika' => 'Narkotika',
        'non_narkotika' => 'Non narkotika',
    ];

    public const STATUS = [
        'proses' => 'Proses',
        'inkracht' => 'Inkracht',
        'selesai' => 'Selesai',
    ];

    public function barangBuktis()
    {
        return $this->hasMany(BarangBukti::class);
    }
}