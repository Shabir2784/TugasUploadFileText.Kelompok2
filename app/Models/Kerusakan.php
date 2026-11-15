<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kerusakan extends Model
{
    use HasFactory;

    protected $table = 'kerusakans';

    protected $fillable = [
        'detail_pemesanan_id',
        'deskripsi',
        'foto_kerusakan',
        'jumlah_denda',
        'catatan_admin',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_denda' => 'decimal:2',
        ];
    }

    public function detailPemesanan(): BelongsTo
    {
        return $this->belongsTo(
            DetailPemesanan::class,
            'detail_pemesanan_id'
        );
    }
}
