<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Item;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            return view('admin.laporan');
        } elseif (Auth::user()->role == 'petugas') {
            return view('staff.laporan');
        }
    }

    public function generate(Request $request)
    {
        try {
            // Aturan validasi dasar
            $rules = [
                'type' => 'required|in:barang_masuk,peminjaman,pengembalian',
                'period' => 'required|in:hari_ini,minggu_ini,bulan_ini,tahun_ini,custom',
            ];

            // Hanya validasi tanggal jika period = custom
            if ($request->period === 'custom') {
                $rules['start_date'] = 'required|date';
                $rules['end_date'] = 'required|date|after_or_equal:start_date';
            }

            $validated = $request->validate($rules);

            $type = $request->type;
            $period = $request->period;
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = null;
            $data = [];
            $summary = [];

            switch ($type) {
                case 'barang_masuk':
                    $query = Item::query();
                    $this->applyDateFilter($query, $period, $startDate, $endDate, 'tanggal_masuk');
                    $data = $query->get();

                    $summary = [
                        'total_items' => $data->sum('jumlah'),
                        'total_categories' => $data->groupBy('kategori')->count(),
                    ];
                    break;

                case 'peminjaman':
                    $query = Borrowing::with(['item', 'person']);
                    $this->applyDateFilter($query, $period, $startDate, $endDate, 'tanggal_pinjam');
                    $data = $query->get();

                    $summary = [
                        'total_borrowings' => $data->count(),
                        'returned' => $data->where('status', 'Dikembalikan')->count(),
                        'not_returned' => $data->where('status', '!=', 'Dikembalikan')->count(),
                    ];
                    break;

                case 'pengembalian':
                    $query = Borrowing::with(['item', 'person'])
                        ->whereNotNull('tanggal_dikembalikan');
                    $this->applyDateFilter($query, $period, $startDate, $endDate, 'tanggal_dikembalikan');
                    $data = $query->get();

                    $summary = [
                        'total_returns' => $data->count(),
                        'good_condition' => $data->where('kondisi_kembali', 'Baik')->count(),
                        'damaged_condition' => $data->where('kondisi_kembali', '!=', 'Baik')->count(),
                    ];
                    break;

                default:
                    throw new \Exception('Jenis laporan tidak valid');
            }

            $periodText = $this->getPeriodText($period, $startDate, $endDate);

            return response()->json([
                'success' => true,
                'data' => $data,
                'type' => $type,
                'periodText' => $periodText,
                'summary' => $summary
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function applyDateFilter($query, $period, $startDate, $endDate, $dateColumn)
    {
        if ($period === 'custom') {
            $query->whereDate($dateColumn, '>=', $startDate)
                ->whereDate($dateColumn, '<=', $endDate);
            return;
        }

        $now = Carbon::now();

        switch ($period) {
            case 'hari_ini':
                $query->whereDate($dateColumn, $now->toDateString());
                break;
            case 'minggu_ini':
                $query->whereBetween($dateColumn, [
                    $now->copy()->startOfWeek()->toDateString(),
                    $now->copy()->endOfWeek()->toDateString()
                ]);
                break;
            case 'bulan_ini':
                $query->whereBetween($dateColumn, [
                    $now->copy()->startOfMonth()->toDateString(),
                    $now->copy()->endOfMonth()->toDateString()
                ]);
                break;
            case 'tahun_ini':
                $query->whereBetween($dateColumn, [
                    $now->copy()->startOfYear()->toDateString(),
                    $now->copy()->endOfYear()->toDateString()
                ]);
                break;
        }
    }

    private function getPeriodText($period, $startDate, $endDate)
    {
        switch ($period) {
            case 'hari_ini':
                return 'Hari Ini (' . Carbon::now()->format('d M Y') . ')';
            case 'minggu_ini':
                return 'Minggu Ini (' . Carbon::now()->startOfWeek()->format('d M') . ' - ' . Carbon::now()->endOfWeek()->format('d M Y') . ')';
            case 'bulan_ini':
                return 'Bulan Ini (' . Carbon::now()->format('M Y') . ')';
            case 'tahun_ini':
                return 'Tahun Ini (' . Carbon::now()->format('Y') . ')';
            case 'custom':
                return Carbon::parse($startDate)->format('d M Y') . ' - ' . Carbon::parse($endDate)->format('d M Y');
            default:
                return '';
        }
    }
}
