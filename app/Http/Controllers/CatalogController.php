<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $produkPilihan = Barang::with('kategori')->latest()->take(4)->get();

        return view('home', compact('produkPilihan'));
    }
}