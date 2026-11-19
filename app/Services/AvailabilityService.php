<?php

namespace App\Services;

use App\Models\DetailPemesanan as BookingDetail;
use App\Models\Barang as Item;
use Carbon\Carbon;

class AvailabilityService
{
    /**
     * Memeriksa ketersediaan stok barang pada rentang tanggal tertentu (UC-07 & UC-11).
     *
     * @return array{
     *     status: 'available'|'conflict'|'out_of_stock',
     *     available_stock: int,
     *     total_days: int,
     *     estimated_total: float
     * }
     */
    public function checkAvailability(Item $item, string $startDate, string $endDate, int $requestedQty = 1): array
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->startOfDay();

        // Durasi minimal 1 hari sesuai aturan tabel pemesanans di SDD
        $totalDays = max(1, (int) $start->diffInDays($end) + 1);
        $estimatedTotal = (float) ($item->harga_per_hari * $requestedQty * $totalDays);

        // 1. Hitung unit yang sudah dikunci permanen (status: disetujui / berlangsung) pada rentang tanggal beririsan
        $lockedQty = (int) BookingDetail::where('barang_id', $item->id)
            ->whereHas('pemesanan', function ($q) use ($startDate, $endDate) {
                $q->whereIn('status', ['disetujui', 'berlangsung'])
                  ->where('tanggal_mulai', '<=', $endDate)
                  ->where('tanggal_selesai', '>=', $startDate);
            })
            ->sum('jumlah');

        // 2. Hitung unit yang sedang ditahan sementara (status: menunggu) pada rentang tanggal beririsan
        $pendingQty = (int) BookingDetail::where('barang_id', $item->id)
            ->whereHas('pemesanan', function ($q) use ($startDate, $endDate) {
                $q->where('status', 'menunggu')
                  ->where('tanggal_mulai', '<=', $endDate)
                  ->where('tanggal_selesai', '>=', $startDate);
            })
            ->sum('jumlah');

        $physicallyRemaining = max(0, $item->stok - $lockedQty);
        $effectiveAvailable = max(0, $physicallyRemaining - $pendingQty);

        // Tentukan variasi status sesuai Mockup Detail Produk Bab IV SDD
        if ($effectiveAvailable >= $requestedQty && $effectiveAvailable > 0) {
            $status = 'available';
        } elseif ($physicallyRemaining > 0 && $pendingQty > 0) {
            // Stok fisik ada, tetapi sedang ditinjau pada pesanan lain -> opsi Masuk Antrean (UC-11)
            $status = 'conflict';
        } else {
            $status = 'out_of_stock';
        }

        return [
            'status'          => $status,
            'available_stock' => $effectiveAvailable,
            'total_days'      => $totalDays,
            'estimated_total' => $estimatedTotal,
        ];
    }
}
