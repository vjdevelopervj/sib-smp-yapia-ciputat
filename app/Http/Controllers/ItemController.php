<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    // Konstanta untuk opsi perPage
    const PER_PAGE_OPTIONS = [10, 25, 50, 100];
    const DEFAULT_PER_PAGE = 10;

    /**
     * Menampilkan daftar barang dengan filter dan pagination
     */
    public function index(Request $request)
    {
        // Ambil parameter filter dari request
        $search = $request->input('search');
        $kategori = $request->input('kategori');
        $kondisi = $request->input('kondisi');
        $lokasi = $request->input('lokasi');
        $perPage = $request->input('perPage', self::DEFAULT_PER_PAGE);

        // Validasi nilai perPage
        if (!in_array($perPage, self::PER_PAGE_OPTIONS)) {
            $perPage = self::DEFAULT_PER_PAGE;
        }

        // Query untuk data barang dengan filter
        $items = Item::query()
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('kode_barang', 'like', "%$search%")
                        ->orWhere('nama_barang', 'like', "%$search%");
                });
            })
            ->when($kategori, function ($query) use ($kategori) {
                return $query->where('kategori', $kategori);
            })
            ->when($kondisi, function ($query) use ($kondisi) {
                return $query->where('kondisi', $kondisi);
            })
            ->when($lokasi, function ($query) use ($lokasi) {
                return $query->where('lokasi', $lokasi);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        // Ambil opsi untuk dropdown filter
        $kategoriOptions = Item::select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $lokasiOptions = Item::select('lokasi')
            ->distinct()
            ->orderBy('lokasi')
            ->pluck('lokasi');

        $kondisiOptions = [
            'Baik' => 'Baik',
            'Rusak Ringan' => 'Rusak Ringan',
            'Rusak Berat' => 'Rusak Berat',
            'Hilang' => 'Hilang'
        ];

        if (Auth::user()->role === 'admin') {
            return view('admin.databarang', compact(
                'items',
                'kategoriOptions',
                'lokasiOptions',
                'kondisiOptions',
                'search',
                'kategori',
                'kondisi',
                'lokasi',
                'perPage'
            ));
        } else {
            return view('staff.databarang', compact(
                'items',
                'kategoriOptions',
                'lokasiOptions',
                'kondisiOptions',
                'search',
                'kategori',
                'kondisi',
                'lokasi',
                'perPage'
            ));
        }
    }

    /**
     * Generate a unique kode_barang
     */
    private function generateKodeBarang()
    {
        $prefix = 'BRG-' . now()->format('Ymd') . '-';
        $lastItem = Item::where('kode_barang', 'like', $prefix . '%')
            ->orderBy('kode_barang', 'desc')
            ->first();

        $lastNumber = $lastItem ? (int)substr($lastItem->kode_barang, -4) : 0;
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return $prefix . $newNumber;
    }

    /**
     * Menyimpan data barang baru
     */
    public function store(Request $request)
    {
        // Ambil opsi kategori dan lokasi untuk validasi staff
        $kategoriOptions = Item::select('kategori')->distinct()->pluck('kategori')->toArray();
        $lokasiOptions = Item::select('lokasi')->distinct()->pluck('lokasi')->toArray();

        // Tentukan aturan validasi berdasarkan role
        $rules = [
            'nama_barang' => 'required|max:100',
            'kategori' => 'required|max:50',
            'lokasi' => 'required|max:50',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Hilang',
            'tanggal_masuk' => 'required|date',
            'catatan' => 'nullable|string|max:255'
        ];

        if (Auth::user()->role === 'staff') {
            $rules['kategori'] = 'required|in:' . implode(',', $kategoriOptions);
            $rules['lokasi'] = 'required|in:' . implode(',', $lokasiOptions);
            $rules['catatan'] = 'nullable|string|max:100';
        }

        // Validasi input
        $validated = $request->validate($rules);

        try {
            // Mulai transaksi database
            DB::beginTransaction();

            // Tambahkan kode_barang yang dihasilkan secara otomatis
            $validated['kode_barang'] = $this->generateKodeBarang();
            $validated['created_by'] = Auth::id();
            Item::create($validated);

            // Commit transaksi
            DB::commit();

            // Redirect berdasarkan role
            $route = Auth::user()->role === 'admin' ? 'admin.databarang.index' : 'staff.databarang.index';
            return redirect()->route($route)
                ->with('success', 'Data barang berhasil ditambahkan');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            // Redirect berdasarkan role untuk error
            $route = Auth::user()->role === 'admin' ? 'admin.databarang.index' : 'staff.databarang.index';
            return redirect()->route($route)
                ->withInput()
                ->with('error', 'Gagal menambahkan data barang. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan form edit barang
     */
    public function edit(Item $databarang)
    {
        return response()->json($databarang);
    }

    /**
     * Memperbarui data barang
     */
    public function update(Request $request, Item $databarang)
    {
        // Ambil opsi kategori dan lokasi untuk validasi staff
        $kategoriOptions = Item::select('kategori')->distinct()->pluck('kategori')->toArray();
        $lokasiOptions = Item::select('lokasi')->distinct()->pluck('lokasi')->toArray();

        // Tentukan aturan validasi berdasarkan role
        $rules = [
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Hilang',
            'tanggal_masuk' => 'required|date',
            'catatan' => 'nullable|string'
        ];

        if (Auth::user()->role === 'staff') {
            $rules['kategori'] = 'required|in:' . implode(',', $kategoriOptions);
            $rules['lokasi'] = 'required|in:' . implode(',', $lokasiOptions);
            $rules['catatan'] = 'nullable|string|max:100';
        }

        // Validasi input
        $validated = $request->validate($rules);

        $databarang->update($validated);

        // Redirect berdasarkan role
        $route = Auth::user()->role === 'admin' ? 'admin.databarang.index' : 'staff.databarang.index';
        return redirect()->route($route)
            ->with('success', 'Data barang berhasil diperbarui');
    }

    /**
     * Menghapus data barang dan riwayat peminjaman terkait
     */
    public function destroy(Request $request, Item $databarang)
    {
        // Cek apakah request adalah AJAX
        $isAjax = $request->header('X-Requested-With') === 'XMLHttpRequest';

        try {
            // Mulai transaksi database
            DB::beginTransaction();

            // Hapus semua record Borrowing terkait (baik Dipinjam maupun Dikembalikan)
            Borrowing::where('item_id', $databarang->id)->delete();

            // Hapus data barang
            $databarang->delete();

            // Commit transaksi
            DB::commit();

            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data barang dan riwayat peminjaman berhasil dihapus'
                ]);
            }

            // Redirect berdasarkan role
            $route = Auth::user()->role === 'admin' ? 'admin.databarang.index' : 'staff.databarang.index';
            return redirect()->route($route)
                ->with('success', 'Data barang dan riwayat peminjaman berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            $message = 'Gagal menghapus data barang dan riwayat peminjaman. Silakan coba lagi.';
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => $message
                ], 500);
            }

            $route = Auth::user()->role === 'admin' ? 'admin.databarang.index' : 'staff.databarang.index';
            return redirect()->route($route)
                ->with('error', $message);
        }
    }

    /**
     * Mendapatkan opsi kondisi barang
     */
    public static function kondisiOptions()
    {
        return [
            'Baik' => 'Baik',
            'Rusak Ringan' => 'Rusak Ringan',
            'Rusak Berat' => 'Rusak Berat',
            'Hilang' => 'Hilang'
        ];
    }
}
