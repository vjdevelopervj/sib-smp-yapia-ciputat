<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::get('login', function () {
    return view('loginpage');
})->name('login');

Route::post('login', function () {
    $credentials = request()->validate([
        'username' => 'required|string',
        'password' => 'required'
    ]);

    if (Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
        request()->session()->regenerate();

        // Redirect berdasarkan role
        if (Auth::user()->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } else {
            return redirect()->intended('/staff/dashboard');
        }
    }

    return back()->withErrors([
        'username' => 'Username atau password yang Anda masukkan salah',
    ]);
});

Route::post('logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Main Application Routes (Require Authentication)
Route::middleware(['auth'])->group(function () {
    // Dashboard admin - Menggunakan DashboardController
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/categories-data', [DashboardController::class, 'getCategoriesData']);
    Route::get('/admin/dashboard/borrowings-data', [DashboardController::class, 'getBorrowingsData']);
    Route::get('/admin/dashboard/all-activities', [DashboardController::class, 'getAllActivities']);

    // Dashboard staff - Menggunakan DasboardController
    Route::get('/staff/dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');
    Route::get('/staff/dashboard/categories-data', [DashboardController::class, 'getCategoriesData']);
    Route::get('/staff/dashboard/borrowings-data', [DashboardController::class, 'getBorrowingsData']);
    Route::get('/staff/dashboard/all-activities', [DashboardController::class, 'getAllActivities']);

    // Data Barang admin - Menggunakan ItemController
    Route::get('/admin/databarang', [ItemController::class, 'index'])->name('admin.databarang.index');
    Route::post('/admin/databarang', [ItemController::class, 'store'])->name('admin.databarang.store');
    Route::put('/admin/databarang/{databarang}', [ItemController::class, 'update'])->name('admin.databarang.update');
    Route::delete('/admin/databarang/{databarang}', [ItemController::class, 'destroy'])->name('admin.databarang.destroy');

    // Data Barang staff - Menggunakan ItemController
    Route::get('/staff/databarang', [ItemController::class, 'index'])->name('staff.databarang.index');
    Route::post('/staff/databarang', [ItemController::class, 'store'])->name('staff.databarang.store');
    Route::put('/staff/databarang/{databarang}', [ItemController::class, 'update'])->name('staff.databarang.update');
    Route::delete('/staff/databarang/{databarang}', [ItemController::class, 'destroy'])->name('staff.databarang.destroy');

    // Data Orang admin - Menggunakan PersonController
    Route::get('/admin/dataorang', [PersonController::class, 'index'])->name('admin.dataorang.index');
    Route::post('/admin/dataorang', [PersonController::class, 'store'])->name('admin.dataorang.store');
    Route::put('/admin/dataorang/{dataorang}', [PersonController::class, 'update'])->name('admin.dataorang.update');
    Route::delete('/admin/dataorang/{dataorang}', [PersonController::class, 'destroy'])->name('admin.dataorang.destroy');

    // Data Orang staff - Menggunakan PersonController
    Route::get('/staff/dataorang', [PersonController::class, 'index'])->name('staff.dataorang.index');
    Route::post('/staff/dataorang', [PersonController::class, 'store'])->name('staff.dataorang.store');
    Route::put('/staff/dataorang/{dataorang}', [PersonController::class, 'update'])->name('staff.dataorang.update');
    Route::delete('/staff/dataorang/{dataorang}', [PersonController::class, 'destroy'])->name('staff.dataorang.destroy');

    // Peminjaman admin - Menggunakan BorrowingController
    Route::get('/admin/peminjaman', [BorrowingController::class, 'index'])->name('admin.peminjaman.index');
    Route::post('/admin/peminjaman', [BorrowingController::class, 'store'])->name('admin.peminjaman.store');
    Route::post('/admin/peminjaman/{borrowing}/return', [BorrowingController::class, 'returnItem'])->name('admin.peminjaman.return');

    // Peminjaman staff - Menggunakan BorrowingController
    Route::get('/staff/peminjaman', [BorrowingController::class, 'index'])->name('staff.peminjaman.index');
    Route::post('/staff/peminjaman', [BorrowingController::class, 'store'])->name('staff.peminjaman.store');
    Route::post('/staff/peminjaman/{borrowing}/return', [BorrowingController::class, 'returnItem'])->name('staff.peminjaman.return');

    // Laporan admin - Menggunakan ReportController
    Route::get('/admin/laporan', [ReportController::class, 'index'])->name('laporan');
    Route::post('/admin/laporan/generate', [ReportController::class, 'generate'])->name('laporan.generate');

    // Laporan staff - Menggunakan ReportController
    Route::get('/staff/laporan', [ReportController::class, 'index'])->name('laporan');
    Route::post('/staff/laporan/generate', [ReportController::class, 'generate'])->name('laporan.generate');

    // Pengguna admin - Menggunakan UserController
    Route::get('/admin/pengguna', function () {
        return view('admin.pengguna');
    })->name('pengguna');

    Route::get('/staff/profile', function () {
        return view('staff.profile');
    })->name('profile');

    // API Routes for User Management
    Route::prefix('api')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
        Route::post('/users/{user}/change-password', [UserController::class, 'changePassword']);
        // New routes for authenticated user profile management
        Route::put('/profile', [UserController::class, 'updateProfile'])->name('api.profile.update');
        Route::post('/profile/change-password', [UserController::class, 'updatePassword'])->name('api.profile.change-password');
    });
});

Route::prefix('dashboard')->group(function () {
    Route::get('/categories-data', [DashboardController::class, 'getCategoriesData']);
    Route::get('/borrowings-data', [DashboardController::class, 'getBorrowingsData']);
    Route::get('/all-activities', [DashboardController::class, 'getAllActivities']);
});

// Fallback Route (404)
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
