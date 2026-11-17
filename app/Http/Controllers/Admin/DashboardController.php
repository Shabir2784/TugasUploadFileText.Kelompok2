<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'start' => ['nullable', 'date'],
            'end'   => ['nullable', 'date', 'after_or_equal:start'],
        ]);

        // Sementara kosong: view memakai data dummy. Isi dengan query asli
        // ($stats, $tren, $jadwalSewa, $inventaris) sesuai periode start/end.
        return view('admin.dashboard');
    }
}