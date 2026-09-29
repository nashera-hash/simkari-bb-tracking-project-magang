<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangBukti extends Model
{
    protected $guarded = [];

    public const STATUS = [
        'disimpan' => 'Disimpan',
        'dipinjam' => 'Dipinjam',
        'dilelang' => 'Dilelang',
        'dimusnahkan' => 'Dimusnahkan',
        'dikembalikan' => 'Dikembalikan',
    ];

    public function perkara()
    {
        return $this->belongsTo(Perkara::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }

    public function riwayat()
    {
        return $this->hasMany(RiwayatLokasi::class)->latest('waktu');
    }
}