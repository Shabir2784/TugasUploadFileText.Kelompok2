<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            [
                'nama' => 'Tenda',
                'deskripsi' => 'Perlengkapan tenda untuk kegiatan acara.'
            ],
            [
                'nama' => 'Kursi',
                'deskripsi' => 'Berbagai jenis kursi untuk kebutuhan acara.'
            ],
            [
                'nama' => 'Meja',
                'deskripsi' => 'Berbagai jenis meja untuk kebutuhan acara.'
            ],
            [
                'nama' => 'Panggung',
                'deskripsi' => 'Perlengkapan panggung untuk kegiatan acara.'
            ],
            [
                'nama' => 'Peralatan Audio',
                'deskripsi' => 'Peralatan suara untuk kegiatan acara.'
            ],
            [
                'nama' => 'Peralatan Pencahayaan',
                'deskripsi' => 'Peralatan pencahayaan untuk kegiatan acara.'
            ],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::updateOrCreate(
                ['nama' => $kategori['nama']],
                ['deskripsi' => $kategori['deskripsi']]
            );
        }
    }
}
