<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    protected $guarded = [];

    public function raks()
    {
        return $this->hasMany(Rak::class);
    }

    public function barangBuktis()
    {
        return $this->hasMany(BarangBukti::class);
    }
}