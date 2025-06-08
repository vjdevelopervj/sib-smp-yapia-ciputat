<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Borrowing;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Total items
        $totalItems = Item::count();
        $lastMonthItems = Item::where('created_at', '>=', now()->subMonth())->count();
        $itemPercentageChange = $lastMonthItems > 0 ? round((($totalItems - $lastMonthItems) / $lastMonthItems * 100)) : 0;

        // Borrowed items
        $borrowedItems = Borrowing::where('status', 'Dipinjam')->count();
        $yesterdayBorrowed = Borrowing::where('status', 'Dipinjam')
            ->whereDate('created_at', today()->subDay())
            ->count();
        $borrowedPercentageChange = $yesterdayBorrowed > 0 ? round((($borrowedItems - $yesterdayBorrowed) / $yesterdayBorrowed * 100)) : 0;

        // Returned today
        $returnedToday = Borrowing::whereDate('tanggal_dikembalikan', today())->count();
        $yesterdayReturned = Borrowing::whereDate('tanggal_dikembalikan', today()->subDay())->count();
        $returnedPercentageChange = $returnedToday - $yesterdayReturned;

        // Problematic items
        $problematicItems = Item::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat', 'Hilang'])->count() +
            Borrowing::whereIn('status', ['Rusak', 'Hilang'])->count();
        $lastWeekProblematic = Item::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat', 'Hilang'])
            ->where('created_at', '>=', now()->subWeek())
            ->count() +
            Borrowing::whereIn('status', ['Rusak', 'Hilang'])
            ->where('created_at', '>=', now()->subWeek())
            ->count();
        $problematicPercentageChange = $lastWeekProblematic;

        // Recent activities
        $recentActivities = $this->getRecentActivities();

        // Chart data - Item Categories
        $categories = Item::groupBy('kategori')
            ->selectRaw('kategori, count(*) as total')
            ->pluck('total', 'kategori')
            ->toArray();

        // If no categories exist, provide sample data
        if (empty($categories)) {
            $categories = [
                'Elektronik' => 12,
                'Furnitur' => 8,
                'Alat Tulis' => 15,
                'Kendaraan' => 3
            ];
        }

        // Borrowings last 30 days
        $borrowingsLast30Days = [];
        $borrowingsData = Borrowing::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, count(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        foreach ($borrowingsData as $data) {
            $borrowingsLast30Days[$data->date] = $data->total;
        }

        // Fill in missing dates with 0
        $startDate = now()->subDays(29)->startOfDay();
        $endDate = now()->endOfDay();
        $completeBorrowingsData = [];

        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $dateString = $date->format('Y-m-d');
            $completeBorrowingsData[$dateString] = $borrowingsLast30Days[$dateString] ?? 0;
        }

        if (Auth::user()->role === 'admin') {
            return view('admin.dashboard', compact(
                'totalItems',
                'itemPercentageChange',
                'borrowedItems',
                'borrowedPercentageChange',
                'returnedToday',
                'returnedPercentageChange',
                'problematicItems',
                'problematicPercentageChange',
                'recentActivities',
                'categories',
                'completeBorrowingsData'
            ));
        } else {
            return view('staff.dashboard', compact(
                'totalItems',
                'itemPercentageChange',
                'borrowedItems',
                'borrowedPercentageChange',
                'returnedToday',
                'returnedPercentageChange',
                'problematicItems',
                'problematicPercentageChange',
                'recentActivities',
                'categories',
                'completeBorrowingsData'
            ));
        }
    }

    private function getRecentActivities()
    {
        $activities = [];

        // Get recent borrowings (last 5)
        $recentBorrowings = Borrowing::with(['item', 'person'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        foreach ($recentBorrowings as $borrowing) {
            // Add borrowing activity
            $activities[] = [
                'type' => 'borrow',
                'title' => 'Peminjaman Barang',
                'description' => ($borrowing->person ? $borrowing->person->nama : 'Orang Tidak Diketahui') .
                    ' meminjam ' . ($borrowing->item ? $borrowing->item->nama_barang : 'Barang Tidak Diketahui') .
                    ($borrowing->item ? ' (ID: ' . $borrowing->item->kode_barang . ')' : ''),
                'time' => $borrowing->created_at->diffForHumans()
            ];

            // Add return activity if exists
            if ($borrowing->tanggal_dikembalikan) {
                $activities[] = [
                    'type' => 'return',
                    'title' => 'Pengembalian Barang',
                    'description' => ($borrowing->person ? $borrowing->person->nama : 'Orang Tidak Diketahui') .
                        ' mengembalikan ' . ($borrowing->item ? $borrowing->item->nama_barang : 'Barang Tidak Diketahui') .
                        ($borrowing->item ? ' (ID: ' . $borrowing->item->kode_barang . ')' : ''),
                    'time' => $borrowing->updated_at->diffForHumans()
                ];
            }

            // Add damage report if status is Rusak
            if ($borrowing->status === 'Rusak') {
                $activities[] = [
                    'type' => 'damage',
                    'title' => 'Barang Rusak',
                    'description' => ($borrowing->item ? $borrowing->item->nama_barang : 'Barang Tidak Diketahui') .
                        ($borrowing->item ? ' (ID: ' . $borrowing->item->kode_barang . ')' : '') .
                        ' dilaporkan rusak oleh ' . ($borrowing->person ? $borrowing->person->nama : 'Orang Tidak Diketahui'),
                    'time' => $borrowing->updated_at->diffForHumans()
                ];
            }
        }

        // Get recently added items (last 2)
        $recentItems = Item::orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        foreach ($recentItems as $item) {
            $activities[] = [
                'type' => 'new_item',
                'title' => 'Barang Baru',
                'description' => $item->nama_barang . ' (ID: ' . $item->kode_barang . ') ditambahkan ke inventaris',
                'time' => $item->created_at->diffForHumans()
            ];
        }

        // Sort all activities by time (newest first)
        usort($activities, function ($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        // Return only the 5 most recent activities
        return array_slice($activities, 0, 5);
    }

    public function getCategoriesData(Request $request)
    {
        $filter = $request->input('filter', 'month');

        $query = Item::query();

        switch ($filter) {
            case 'last_month':
                $query->whereBetween('created_at', [
                    now()->subMonth()->startOfMonth(),
                    now()->subMonth()->endOfMonth()
                ]);
                break;

            case 'year':
                $query->whereBetween('created_at', [
                    now()->startOfYear(),
                    now()->endOfYear()
                ]);
                break;

            default: // month
                $query->whereBetween('created_at', [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ]);
        }

        $categories = $query->groupBy('kategori')
            ->selectRaw('kategori, count(*) as total')
            ->pluck('total', 'kategori');

        return response()->json([
            'labels' => $categories->keys()->toArray(),
            'data' => $categories->values()->toArray()
        ]);
    }

    public function getBorrowingsData(Request $request)
    {
        $days = (int) $request->input('days', 30);
        $days = min(max($days, 7), 90); // Batasi antara 7-90 hari

        $labels = [];
        $data = [];
        $today = now();

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $dateString = $date->format('Y-m-d');
            $formattedDate = $date->format('j M');

            $count = Borrowing::whereDate('created_at', $date)->count();

            $labels[] = $formattedDate;
            $data[] = $count;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function getAllActivities()
    {
        $activities = $this->getRecentActivities();
        return response()->json($activities);
    }
}
