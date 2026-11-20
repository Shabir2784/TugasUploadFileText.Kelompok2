<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Kerusakan;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function show(Request $request, Pemesanan $pemesanan)
    {
        $pemesanan->load([
            'user',
            'detailPemesanans.barang',
            'detailPemesanans.kerusakans',
        ]);

        return view('customer.pesanan.show', [
            'pemesanan' => $pemesanan,
        ]);
    }

    public function createKerusakan(Request $request, Pemesanan $pemesanan)
    {
        $pemesanan->load([
            'user',
            'detailPemesanans.barang',
        ]);

        return view('customer.pesanan.laporan-kerusakan', [
            'pemesanan' => $pemesanan,
        ]);
    }

    public function storeKerusakan(Request $request, Pemesanan $pemesanan)
    {
        $validated = $request->validate([
            'detail_pemesanan_id' => ['required', 'integer', 'exists:detail_pemesanans,id'],
            'keterangan' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'max:5120'],
        ]);

        $fotoPath = '';
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('kerusakan', 'public');
        }

        Kerusakan::create([
            'detail_pemesanan_id' => $validated['detail_pemesanan_id'],
            'deskripsi' => $validated['keterangan'],
            'foto_kerusakan' => $fotoPath,
            'status' => 'dilaporkan',
        ]);

        return redirect()
            ->route('pesanan.show', $pemesanan)
            ->with('success', 'Laporan kerusakan berhasil dikirim dan diteruskan ke Admin.');
    }

    public function kondisiBaik(Request $request, Pemesanan $pemesanan)
    {
        $pemesanan->update([
            'status' => 'selesai',
        ]);

        return redirect()
            ->route('pesanan.show', $pemesanan)
            ->with('success', 'Konfirmasi barang dalam kondisi baik berhasil disimpan.');
    }
}