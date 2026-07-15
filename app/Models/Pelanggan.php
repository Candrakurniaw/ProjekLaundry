<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = [
        'kode_pelanggan',
        'nama',
        'no_telepon',
        'alamat',
        'poin',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
