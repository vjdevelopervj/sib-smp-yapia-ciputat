<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $kelas = $request->input('kelas');
        $perPage = $request->input('perPage', 10);

        $query = Person::query();

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('kode_orang', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // Role filter
        if ($role) {
            $query->where('role', $role);
        }

        // Kelas filter (only applicable for siswa/siswi)
        if ($kelas && ($role == 'Siswa' || $role == 'Siswi' || !$role)) {
            $query->where('kelas', $kelas);
        }

        // Get paginated results with sorting
        $people = $query->orderBy('role')
            ->orderBy('nama')
            ->paginate($perPage)
            ->appends([
                'search' => $search,
                'role' => $role,
                'kelas' => $kelas,
                'perPage' => $perPage
            ]);

        if (Auth::user()->role == 'admin') {
            return view('admin.dataorang', [
                'people' => $people,
                'search' => $search,
                'role' => $role,
                'kelas' => $kelas,
                'perPage' => $perPage
            ]);
        } elseif (Auth::user()->role == 'staff' || Auth::user()->role == 'petugas') {
            return view('staff.dataorang', [
                'people' => $people,
                'search' => $search,
                'role' => $role,
                'kelas' => $kelas,
                'perPage' => $perPage
            ]);
        }

        // Fallback redirect for unauthorized users
        return redirect()->route('home')->with('error', 'Unauthorized access');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_orang' => 'required|unique:people',
            'nama' => 'required|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'role' => 'required|in:Siswa,Siswi,Guru,Staff,Admin,Petugas',
            'kelas' => 'nullable|string|max:10',
            'email' => 'nullable|email|max:100',
            'telepon' => 'nullable|max:20',
            'catatan' => 'nullable|string'
        ]);

        // Jika bukan siswa/siswi, set kelas menjadi null
        if (!in_array($validated['role'], ['Siswa', 'Siswi'])) {
            $validated['kelas'] = null;
        }

        Person::create($validated);

        // Redirect based on user role
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dataorang.index')
                ->with('success', 'Data warga sekolah berhasil ditambahkan');
        } elseif (Auth::user()->role == 'staff' || Auth::user()->role == 'petugas') {
            return redirect()->route('staff.dataorang.index')
                ->with('success', 'Data warga sekolah berhasil ditambahkan');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Person $dataorang)
    {
        $validated = $request->validate([
            'nama' => 'required|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'role' => 'required|in:Siswa,Siswi,Guru,Staff,Admin,Petugas',
            'kelas' => 'nullable|string|max:10',
            'email' => 'nullable|email|max:100',
            'telepon' => 'nullable|max:20',
            'catatan' => 'nullable|string'
        ]);

        // Jika bukan siswa/siswi, set kelas menjadi null
        if (!in_array($validated['role'], ['Siswa', 'Siswi'])) {
            $validated['kelas'] = null;
        }

        $dataorang->update($validated);

        // Redirect based on user role
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dataorang.index')
                ->with('success', 'Data warga sekolah berhasil diperbarui');
        } elseif (Auth::user()->role == 'staff' || Auth::user()->role == 'petugas') {
            return redirect()->route('staff.dataorang.index')
                ->with('success', 'Data warga sekolah berhasil diperbarui');
        }
    }

    /**
     * Remove the specified resource and its related borrowing history from storage.
     */
    public function destroy($id)
    {
        // Check if user has permission to delete
        if (!in_array(Auth::user()->role, ['admin', 'petugas'])) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        try {
            // Mulai transaksi database
            DB::beginTransaction();

            $person = Person::findOrFail($id);

            // Hapus semua record Borrowing terkait (baik Dipinjam maupun Dikembalikan)
            Borrowing::where('person_id', $person->id)->delete();

            // Hapus data person
            $person->delete();

            // Commit transaksi
            DB::commit();

            // Redirect based on user role
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dataorang.index')
                    ->with('success', 'Data warga sekolah dan riwayat peminjaman berhasil dihapus');
            } elseif (Auth::user()->role == 'petugas') {
                return redirect()->route('staff.dataorang.index')
                    ->with('success', 'Data warga sekolah dan riwayat peminjaman berhasil dihapus');
            }
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            // Lue of the error
            $message = 'Gagal menghapus data warga sekolah dan riwayat peminjaman: ' . $e->getMessage();

            // Redirect based on user role
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dataorang.index')
                    ->with('error', $message);
            } elseif (Auth::user()->role == 'petugas') {
                return redirect()->route('staff.dataorang.index')
                    ->with('error', $message);
            }
        }
    }
}
