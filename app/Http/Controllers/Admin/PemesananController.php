<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PemesananController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'status' => [
                'nullable',
                Rule::in([
                    'menunggu',
                    'disetujui',
                    'ditolak',
                    'berlangsung',
                    'selesai',
                    'dibatalkan',
                ]),
            ],
        ]);

        $query = Pemesanan::with([
            'user',
            'detailPemesanans.barang',
        ])->latest();

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        $pemesanans = $query->paginate(10)->withQueryString();

        return view('admin.pemesananMasuk', compact('pemesanans'));
    }
}
