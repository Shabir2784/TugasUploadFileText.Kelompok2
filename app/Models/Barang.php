<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'kategori_id',
        'nama',
        'deskripsi',
        'stok',
        'harga_per_hari',
        'gambar',
    ];

    protected function casts(): array
    {
        return [
            'stok' => 'integer',
            'harga_per_hari' => 'decimal:2',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function detailPemesanans(): HasMany
    {
        return $this->hasMany(DetailPemesanan::class, 'barang_id');
    }

    public function antreanPemesanans(): HasMany
    {
        return $this->hasMany(AntreanPemesanan::class, 'barang_id');
    }
}