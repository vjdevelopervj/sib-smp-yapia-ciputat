<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Item;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        // Get per_page values from request or use defaults
        $perPagePeminjaman = $request->input('per_page_peminjaman', 10);
        $perPagePengembalian = $request->input('per_page_pengembalian', 10);

        // Get active borrowings (not returned yet) with search functionality
        $borrowings = Borrowing::with(['item', 'person'])
            ->where('status', 'Dipinjam')
            ->when($request->has('search_peminjaman'), function ($query) use ($request) {
                $search = $request->input('search_peminjaman');
                return $query->whereHas('item', function ($q) use ($search) {
                    $q->where('kode_barang', 'like', "%$search%")
                        ->orWhere('nama_barang', 'like', "%$search%");
                })->orWhereHas('person', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%")
                        ->orWhere('kode_orang', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate($perPagePeminjaman, ['*'], 'peminjaman_page')
            ->withQueryString();

        // Get returned borrowings with search functionality
        $returnedBorrowings = Borrowing::with(['item', 'person'])
            ->where('status', 'Dikembalikan')
            ->when($request->has('search_pengembalian'), function ($query) use ($request) {
                $search = $request->input('search_pengembalian');
                return $query->whereHas('item', function ($q) use ($search) {
                    $q->where('kode_barang', 'like', "%$search%")
                        ->orWhere('nama_barang', 'like', "%$search%");
                })->orWhereHas('person', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%")
                        ->orWhere('kode_orang', 'like', "%$search%");
                })->orWhere('kode_peminjaman', 'like', "%$search%");
            })
            ->latest()
            ->paginate($perPagePengembalian, ['*'], 'pengembalian_page')
            ->withQueryString();

        // Get available items (jumlah > 0)
        $items = Item::where('jumlah', '>', 0)->get();

        // Get all people
        $people = Person::all();

        if (Auth::user()->role == 'admin') {
            return view('admin.peminjamanpengembalian', compact(
                'borrowings',
                'returnedBorrowings',
                'items',
                'people'
            ));
        } elseif (in_array(Auth::user()->role, ['staff', 'petugas'])) {
            return view('staff.peminjamanpengembalian', compact(
                'borrowings',
                'returnedBorrowings',
                'items',
                'people'
            ));
        }

        // Fallback redirect for unauthorized users
        return redirect()->route('home')->with('error', 'Unauthorized access');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'person_id' => 'required|exists:people,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'catatan' => 'nullable|string',
        ]);

        // Check item availability
        $item = Item::find($request->item_id);
        if ($item->jumlah <= 0) {
            return back()
                ->withInput()
                ->with('error', 'Barang tidak tersedia untuk dipinjam');
        }

        try {
            // Generate transaction code
            $validated['kode_peminjaman'] = 'TRX-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
            $validated['status'] = 'Dipinjam';

            // Create borrowing record
            Borrowing::create($validated);

            // Reduce item quantity
            $item->decrement('jumlah');

            // Redirect based on user role
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.peminjaman.index')
                    ->with('success', 'Peminjaman berhasil dicatat');
            } elseif (in_array(Auth::user()->role, ['staff', 'petugas'])) {
                return redirect()->route('staff.peminjaman.index')
                    ->with('success', 'Peminjaman berhasil dicatat');
            }
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan peminjaman: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan peminjaman. Silakan coba lagi.');
        }
    }

    public function returnItem(Request $request, $id)
    {
        // Log the user role for debugging
        Log::info('Attempting returnItem by user with role: ' . Auth::user()->role);

        // Check if user has permission to return items (case-insensitive)
        if (!in_array(strtolower(Auth::user()->role), ['admin', 'petugas'])) {
            Log::error('Unauthorized access attempt by role: ' . Auth::user()->role);
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access. Only admin or petugas roles can return items.'
            ], 403);
        }

        $validated = $request->validate([
            'tanggal_dikembalikan' => 'required|date',
            'kondisi_kembali' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'catatan' => 'nullable|string',
        ]);

        try {
            $borrowing = Borrowing::findOrFail($id);

            // Update borrowing record
            $validated['status'] = 'Dikembalikan';
            $borrowing->update($validated);

            // Return item quantity if condition is good
            if ($validated['kondisi_kembali'] == 'Baik') {
                $borrowing->item->increment('jumlah');
            }

            // Return JSON response with redirect route based on user role
            $redirectRoute = Auth::user()->role == 'admin'
                ? route('admin.peminjaman.index')
                : route('staff.peminjaman.index');

            return response()->json([
                'success' => true,
                'message' => 'Pengembalian berhasil dicatat',
                'redirect' => $redirectRoute
            ]);
        } catch (\Exception $e) {
            Log::error('Error saat pengembalian: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pengembalian: ' . $e->getMessage()
            ], 500);
        }
    }
}
