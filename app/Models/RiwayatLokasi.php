<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatLokasi extends Model
{
    protected $guarded = [];
    protected $casts = ['waktu' => 'datetime'];

    public function barangBukti()
    {
        return $this->belongsTo(BarangBukti::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}