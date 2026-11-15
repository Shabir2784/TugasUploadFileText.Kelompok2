<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@eventrent.com'],
            [
                'nama' => 'Administrator',
                'kata_sandi' => 'Admin123!',
                'peran' => 'admin',
                'nomor_telepon' => null,
                'berkas_ktp' => null,
                'status_verifikasi' => 'terverifikasi',
                'alasan_penolakan' => null,
            ]
        );
    }
}
