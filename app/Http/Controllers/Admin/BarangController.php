<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Menampilkan daftar barang.
     */
    public function index()
    {
        $barangs = Barang::with('kategori')
            ->latest()
            ->get();

        $kategoris = Kategori::orderBy('nama')->get();

        return view('admin.kelolaBarang', compact(
            'barangs',
            'kategoris'
        ));
    }

    /**
     * Menampilkan formulir tambah barang.
     */
    public function create()
    {
        $kategoris = Kategori::orderBy('nama')->get();

        return view('admin.barang.create', compact('kategoris'));
    }

    /**
     * Menyimpan barang baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'stok' => ['required', 'integer', 'min:0'],
            'harga_per_hari' => ['required', 'numeric', 'min:0'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')
                ->store('barang', 'public');
        }

        Barang::create($validated);

        return redirect()
            ->route('admin.barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit barang.
     */
    public function edit(Barang $barang)
    {
        $kategoris = Kategori::orderBy('nama')->get();

        return view('admin.barang.edit', compact(
            'barang',
            'kategoris'
        ));
    }

    /**
     * Memperbarui data barang.
     */
    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'stok' => ['required', 'integer', 'min:0'],
            'harga_per_hari' => ['required', 'numeric', 'min:0'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('gambar')) {
            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }

            $validated['gambar'] = $request->file('gambar')
                ->store('barang', 'public');
        }

        $barang->update($validated);

        return redirect()
            ->route('admin.barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Menghapus barang.
     */
    public function destroy(Barang $barang)
    {
        if ($barang->detailPemesanans()->exists()) {
            return redirect()
                ->route('admin.barang.index')
                ->with('error', 'Barang tidak dapat dihapus karena sudah digunakan dalam pemesanan.');
        }

        if ($barang->antreanPemesanans()->exists()) {
            return redirect()
                ->route('admin.barang.index')
                ->with('error', 'Barang tidak dapat dihapus karena masih memiliki antrean pemesanan.');
        }

        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $barang->delete();

        return redirect()
            ->route('admin.barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
