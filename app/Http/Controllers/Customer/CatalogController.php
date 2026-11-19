<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Kategori as Category;
use App\Models\Barang as Item;
use App\Services\AvailabilityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Menampilkan halaman katalog, pencarian kata kunci, & filter kategori (UC-05 & UC-06).
     */
    public function __construct(
        protected AvailabilityService $availabilityService
    ) {}

    public function index(Request $request): View|string
    {
        $validated = $request->validate([
            'q'          => ['nullable', 'string', 'max:100'],
            'kategori'   => ['nullable'],
            'kategori.*' => ['string', 'max:100'],
        ]);

        // Ambil 4 kategori utama sesuai SDD (Kursi, Meja, Tenda, Sound System)
        $categories = Category::orderBy('id')->get();

        // Normalisasi filter kategori (bisa berupa string tunggal dari Beranda atau array checkbox)
        $selectedCategories = [];
        if ($request->filled('kategori')) {
            $selectedCategories = is_array($validated['kategori'])
                ? $validated['kategori']
                : [$validated['kategori']];
        }

        $search = $validated['q'] ?? null;
        $hasActiveFilter = !empty($search) || !empty($selectedCategories);

        // Cek apakah database memang belum memiliki barang sama sekali
        $totalAllItems = Item::count();

        $query = Item::with('kategori')->latest();

        if (!empty($search)) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        if (!empty($selectedCategories)) {
            $query->whereHas('kategori', function ($q) use ($selectedCategories) {
                $q->whereIn('nama', $selectedCategories);
            });
        }

        // 9 item per halaman (grid 3 kolom x 3 baris sesuai mockup)
        $items = $query->paginate(9)->withQueryString();

        // Jika request berasal dari AJAX filter/search/pagination, kembalikan partial grid saja
        if ($request->ajax()) {
            return view('partials.customer.catalog-grid', compact(
                'items',
                'hasActiveFilter',
                'totalAllItems'
            ))->render();
        }

        return view('customer.catalog.index', compact(
            'items',
            'categories',
            'selectedCategories',
            'search',
            'hasActiveFilter',
            'totalAllItems'
        ));
    }
    /**
     * Menampilkan halaman Detail Produk & Form Cek Stok (UC-05 & UC-07).
     */
    public function show(Item $item): View
    {
        $item->load('kategori');

        $defaultStart = now()->addDay()->toDateString();
        $defaultEnd = now()->addDay()->toDateString();

        $initialCheck = $this->availabilityService->checkAvailability(
            $item,
            $defaultStart,
            $defaultEnd,
            1
        );

        return view('customer.catalog.show', compact(
            'item',
            'defaultStart',
            'defaultEnd',
            'initialCheck'
        ));
    }

    /**
     * Endpoint AJAX real-time untuk mengecek sisa stok saat tanggal/jumlah diubah (UC-07).
     */
    public function checkStock(Request $request, Item $item): JsonResponse
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
            'quantity'   => ['nullable', 'integer', 'min:1'],
        ]);

        $result = $this->availabilityService->checkAvailability(
            $item,
            $validated['start_date'],
            $validated['end_date'],
            (int) ($validated['quantity'] ?? 1)
        );

        return response()->json([
            'status'               => $result['status'],
            'available_stock'      => $result['available_stock'],
            'total_days'           => $result['total_days'],
            'estimated_total'      => $result['estimated_total'],
            'estimated_total_text' => 'Rp ' . number_format($result['estimated_total'], 0, ',', '.'),
        ]);
    }
}

