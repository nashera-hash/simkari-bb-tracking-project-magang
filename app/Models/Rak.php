<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    protected $guarded = [];

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function barangBuktis()
    {
        return $this->hasMany(BarangBukti::class);
    }
}