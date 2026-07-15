<?php

namespace Database\Seeders;

use App\Models\Layanan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Layanan::create([
            'nama' => 'Cuci Kering',
            'harga_per_kg' => 8000,
            'estimasi_jam' => 24,
        ]);

        Layanan::create([
            'nama' => 'Cuci Setrika',
            'harga_per_kg' => 12000,
            'estimasi_jam' => 24,
        ]);

        Layanan::create([
            'nama' => 'Setrika Saja',
            'harga_per_kg' => 6000,
            'estimasi_jam' => 12,
        ]);

        Layanan::create([
            'nama' => 'Express (6 Jam)',
            'harga_per_kg' => 18000,
            'estimasi_jam' => 6,
        ]);
    }
}
