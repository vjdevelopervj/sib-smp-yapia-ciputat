<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - InventorySys</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        /* CSS styles aligned with admin dashboard */
        .header-gradient {
            background: #131924;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .card-hover {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .card-hover:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
        }

        .search-input {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
        }

        .search-input:focus {
            border-color: #6366f1;
        }

        .pulse-notification {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 8px;
            height: 8px;
            background-color: #ef4444;
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                opacity: 1;
            }

            70% {
                transform: scale(1.3);
                opacity: 0.7;
            }

            100% {
                transform: scale(0.95);
                opacity: 1;
            }
        }

        .chart-container {
            background: linear-gradient(to top left, #0c4a6e, #131924);
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .chart-container:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .modern-select {
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }

        .modern-select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }

        /* Sidebar styles */
        .sidebar {
            transition: all 0.3s ease;
            width: 250px;
            display: flex;
            flex-direction: column;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.expanded {
            width: 250px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: #e0e7ff;
            transition: all 0.3s ease;
            margin-bottom: 0.25rem;
        }

        .nav-item:hover {
            background-color: #143a6b;
        }

        .nav-item.active {
            background-color: #143a6b;
            font-weight: 500;
        }

        .nav-item i {
            width: 24px;
            text-align: center;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .nav-text {
            transition: opacity 0.3s ease, width 0.3s ease;
            white-space: nowrap;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(79, 70, 229, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(165, 180, 252, 0.3);
            color: #c7d2fe;
            transition: all 0.3s ease;
        }

        .user-info {
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .sidebar.collapsed .user-info {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            background-color: #d946ef;
            color: white;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #c026d3;
        }

        .logout-btn i {
            margin-right: 0.75rem;
        }

        .toggle-btn {
            transition: all 0.3s ease;
        }

        .logo-text {
            transition: opacity 0.3s ease, width 0.3s ease;
        }

        .sidebar.collapsed .logo-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        /* Animation for activity items */
        .activity-item {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }

        .activity-item.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-[#10151D]">
    <div class="flex h-screen w-full overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar bg-[#131924] text-white flex-shrink-0 collapsed relative h-full">
            <div class="flex flex-col h-full">
                <!-- Top part of sidebar (logo and menu) -->
                <div class="flex-1 overflow-y-auto">
                    <div class="p-4 flex items-center justify-between border-b border-fuchsia-500">
                        <div class="flex items-center space-x-2">
                            <img src="{{ asset('logoyayasan.png') }}" alt="logo" class="w-10 mr-3">
                            <span class="text-xl font-bold logo-text text-indigo-50">
                                InventorySys
                            </span>
                        </div>
                    </div>
                    <!-- Sidebar navigation -->
                    <nav class="p-4">
                        <div class="space-y-1">
                            <a href="/staff/dashboard"
                                class="nav-item {{ request()->is('staff/dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt text-white"></i>
                                <span class="nav-text font-medium text-white">
                                    Dashboard
                                </span>
                            </a>
                            <a href="/staff/databarang"
                                class="nav-item {{ request()->is('staff/databarang') ? 'active' : '' }}">
                                <i class="fas fa-box text-white"></i>
                                <span class="nav-text font-medium text-white">
                                    Data Barang
                                </span>
                            </a>
                            <a href="/staff/dataorang"
                                class="nav-item {{ request()->is('staff/dataorang') ? 'active' : '' }}">
                                <i class="fas fa-users text-white"></i>
                                <span class="nav-text font-medium text-white">
                                    Data Peminjam
                                </span>
                            </a>
                            <a href="/staff/peminjaman"
                                class="nav-item {{ request()->is('staff/peminjaman') ? 'active' : '' }}">
                                <i class="fas fa-exchange-alt text-white"></i>
                                <span class="nav-text font-medium text-white">
                                    Peminjaman
                                </span>
                            </a>
                            <a href="/staff/laporan"
                                class="nav-item {{ request()->is('staff/laporan') ? 'active' : '' }}">
                                <i class="fas fa-chart-bar text-white"></i>
                                <span class="nav-text font-medium text-white">
                                    Laporan
                                </span>
                            </a>
                            <a href="/staff/profile"
                                class="nav-item {{ request()->is('staff/profile') ? 'active' : '' }}">
                                <i class="fas fa-user text-white"></i>
                                <span class="nav-text font-medium text-white">
                                    Profil
                                </span>
                            </a>
                        </div>
                    </nav>
                </div>

                <!-- Bottom part of sidebar (user info and logout) -->
                <div class="w-full p-4 border-t border-fuchsia-500">
                    <div class="flex items-center space-x-2 mb-3">
                        <div class="user-avatar">
                            <img src="{{ asset('sidebar/staff.png') }}" alt="staff" class="rounded-full">
                        </div>
                        <div class="user-info">
                            <div class="font-medium text-lime-200">
                                {{ Auth::user()->first_name ?? 'Staff' }} {{ Auth::user()->last_name ?? 'User' }}
                            </div>
                            <div class="text-xs text-indigo-100">
                                {{ Auth::user()->role === 'petugas' ? 'Staff' : 'Pengguna' }}
                            </div>
                        </div>
                    </div>
                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn bg-fuchsia-500 hover:bg-fuchsia-700">
                            <i class="fas fa-sign-out-alt text-indigo-200"></i>
                            <span class="nav-text font-medium text-indigo-50">
                                Logout
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <header class="header-gradient p-4 flex items-center justify-between sticky top-0 z-10">
                <div class="flex items-center">
                    <button id="toggleSidebar"
                        class="text-indigo-200 hover:text-white focus:outline-none toggle-btn collapsed transition-colors mr-5"
                        onclick="toggleSidebarState()">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    {{-- <button id="mobileToggleSidebar"
                        class="text-indigo-200 hover:text-white mr-4 focus:outline-none lg:hidden transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button> --}}
                    <h1 class="text-2xl font-bold text-white animate__animated animate__fadeIn">
                        Dashboard
                    </h1>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6 animate__animated animate__fadeIn animate__faster">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Items Card -->
                    <div
                        class="bg-gradient-to-t from-sky-950 to-[#131924] bg-opacity-25 rounded-xl shadow-md p-3 card-hover transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-300 text-sm">Total Barang</p>
                                <h3 class="text-5xl font-bold mt-2 text-white">{{ $totalItems }}</h3>
                                <p
                                    class="text-sm {{ $itemPercentageChange >= 0 ? 'text-green-500' : 'text-rose-400' }} mt-1 font-medium">
                                    <i
                                        class="fas {{ $itemPercentageChange >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                                    {{ abs($itemPercentageChange) }}% dari bulan lalu
                                </p>
                            </div>
                            <div
                                class="w-40 h-28 rounded-br-2xl rounded-tr-2xl rounded-bl-full rounded-tl-full p-2 bg-[#0bff65] flex items-center justify-end shadow-inner">
                                <img src="{{ asset('dashboard/total-barang.png') }}" alt="total-item">
                            </div>
                        </div>
                    </div>

                    <!-- Borrowed Items Card -->
                    <div
                        class="bg-gradient-to-t from-sky-950 to-[#131924] bg-opacity-25 rounded-xl shadow-md p-3 card-hover transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-300 text-sm">Barang Dipinjam</p>
                                <h3 class="text-5xl font-bold mt-2 text-white">{{ $borrowedItems }}</h3>
                                <p
                                    class="text-sm {{ $borrowedPercentageChange >= 0 ? 'text-rose-400' : 'text-green-500' }} mt-1 font-medium">
                                    <i
                                        class="fas {{ $borrowedPercentageChange >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                                    {{ abs($borrowedPercentageChange) }}% dari kemarin
                                </p>
                            </div>
                            <div
                                class="w-40 h-28 rounded-br-2xl rounded-tr-2xl rounded-bl-full rounded-tl-full p-2 bg-[#875fff] flex items-center justify-end shadow-inner">
                                <img src="{{ asset('dashboard/barang-dipinjam.png') }}" alt="barang di pinjam">
                            </div>
                        </div>
                    </div>

                    <!-- Returned Today Card -->
                    <div
                        class="bg-gradient-to-t from-sky-950 to-[#131924] bg-opacity-25 rounded-xl shadow-md p-3 card-hover transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-300 text-sm">Pengembalian Hari Ini</p>
                                <h3 class="text-5xl font-bold mt-2 text-white">{{ $returnedToday }}</h3>
                                <p
                                    class="text-sm {{ $returnedPercentageChange >= 0 ? 'text-green-500' : 'text-rose-400' }} mt-1 font-medium">
                                    <i
                                        class="fas {{ $returnedPercentageChange >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                                    {{ abs($returnedPercentageChange) }} dari kemarin
                                </p>
                            </div>
                            <div
                                class="w-40 h-28 rounded-bl-full rounded-tl-full rounded-br-2xl rounded-tr-2xl p-2 bg-[#ff86b0] flex items-center justify-end shadow-inner">
                                <img src="{{ asset('dashboard/pengembalian-hari-ini.png') }}"
                                    alt="pengembalian hari ini">
                            </div>
                        </div>
                    </div>

                    <!-- Problematic Items Card -->
                    <div
                        class="bg-gradient-to-t from-sky-950 to-[#131924] bg-opacity-25 rounded-xl shadow-md p-3 card-hover transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-300 text-sm">Barang Bermasalah</p>
                                <h3 class="text-5xl font-bold mt-2 text-white">{{ $problematicItems }}</h3>
                                <p
                                    class="text-sm {{ $problematicPercentageChange >= 0 ? 'text-rose-400' : 'text-green-500' }} mt-1 font-medium">
                                    <i
                                        class="fas {{ $problematicPercentageChange >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                                    {{ abs($problematicPercentageChange) }} baru minggu ini
                                </p>
                            </div>
                            <div
                                class="w-40 h-28 rounded-bl-full rounded-tl-full rounded-br-2xl rounded-tr-2xl bg-[#3a93ff] flex items-center justify-end p-3 shadow-inner">
                                <img src="{{ asset('dashboard/barang-rusak.png') }}" alt="barang-bermasalah">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Category Chart -->
                    <div class="chart-container p-6 transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg text-gray-300">Jumlah Barang per Kategori</h3>
                            <select id="categoryFilter"
                                class="bg-[#131924] modern-select border border-gray-600 px-3 py-1 text-gray-300 text-sm focus:outline-none">
                                <option value="month">Bulan Ini</option>
                                <option value="last_month">Bulan Lalu</option>
                                <option value="year">Tahun Ini</option>
                            </select>
                        </div>
                        <div class="h-64">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>

                    <!-- Borrowing Chart -->
                    <div class="chart-container p-6 transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg text-gray-300">Peminjaman</h3>
                            <select id="borrowingFilter"
                                class="bg-[#131924] text-white modern-select border border-gray-600 px-3 py-1 text-sm focus:outline-none">
                                <option value="30">30 Hari Terakhir</option>
                                <option value="14">14 Hari Terakhir</option>
                                <option value="7">7 Hari Terakhir</option>
                            </select>
                        </div>
                        <div class="h-64">
                            <canvas id="borrowingChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div
                    class="bg-gradient-to-tl from-sky-950 to-[#131924] rounded-xl shadow-md p-6 transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg text-gray-300">Aktivitas Terbaru</h3>
                        <button id="showAllActivities"
                            class="text-indigo-300 hover:text-indigo-800 text-sm font-medium transition-colors flex items-center">
                            Lihat Semua <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </button>
                    </div>
                    <div class="relative mb-4">
                        <input type="text" id="activitySearch" placeholder="Cari aktivitas..."
                            class="search-input pl-10 pr-4 py-2 bg-[#131924] border border-gray-500 focus:outline-none focus:border-indigo-500 w-full">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <div class="space-y-4 activity-timeline" id="activityContainer">
                        @forelse($recentActivities as $activity)
                            <div
                                class="activity-item p-4 border-b border-gray-500 hover:bg-sky-950 rounded-lg transition-all duration-300">
                                <div class="flex items-start">
                                    <div
                                        class="w-10 h-10 rounded-full
                                        @if ($activity['type'] === 'return') bg-green-100
                                        @elseif($activity['type'] === 'borrow') bg-blue-100
                                        @elseif($activity['type'] === 'damage') bg-red-100
                                        @else bg-indigo-100 @endif
                                        flex items-center justify-center mr-3 mt-1 shadow-inner">
                                        <i
                                            class="fas
                                            @if ($activity['type'] === 'return') fa-undo text-green-600
                                            @elseif($activity['type'] === 'borrow') fa-hand-holding text-blue-600
                                            @elseif($activity['type'] === 'damage') fa-times-circle text-red-600
                                            @else fa-box text-indigo-600 @endif"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-medium text-gray-200">{{ $activity['title'] }}</h4>
                                            <span class="text-xs text-gray-300">{{ $activity['time'] }}</span>
                                        </div>
                                        <p class="text-sm text-gray-300 mt-1">
                                            {{ $activity['description'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-300 text-center py-4">Tidak ada aktivitas terbaru</p>
                        @endforelse
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        @if (session('token'))
            localStorage.setItem('token', '{{ session('token') }}');
        @endif

        @if (session('clear_token'))
            localStorage.removeItem('token');
        @endif

        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi variabel chart
            let categoryChart, borrowingChart;

            // Fungsi untuk memuat data kategori berdasarkan filter
            function loadCategoryData(filter) {
                fetch(`/dashboard/categories-data?filter=${filter}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        updateCategoryChart(data.labels, data.data);
                    })
                    .catch(error => {
                        console.error('Error loading category data:', error);
                        alert('Gagal memuat data kategori. Silakan coba lagi.');
                    });
            }

            // Fungsi untuk memperbarui chart kategori
            function updateCategoryChart(labels, data) {
                if (!categoryChart) {
                    console.error('Category chart not initialized');
                    return;
                }

                categoryChart.data.labels = labels;
                categoryChart.data.datasets[0].data = data;
                categoryChart.update();
            }

            // Fungsi untuk memuat data peminjaman berdasarkan hari
            function loadBorrowingData(days) {
                fetch(`/dashboard/borrowings-data?days=${days}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        updateBorrowingChart(data.labels, data.data);
                    })
                    .catch(error => {
                        console.error('Error loading borrowing data:', error);
                        alert('Gagal memuat data peminjaman. Silakan coba lagi.');
                    });
            }

            // Fungsi untuk memperbarui chart peminjaman
            function updateBorrowingChart(labels, data) {
                if (!borrowingChart) {
                    console.error('Borrowing chart not initialized');
                    return;
                }

                borrowingChart.data.labels = labels;
                borrowingChart.data.datasets[0].data = data;
                borrowingChart.update();
            }

            // Event listener untuk filter kategori
            document.getElementById('categoryFilter').addEventListener('change', function() {
                loadCategoryData(this.value);
            });

            // Event listener untuk filter peminjaman
            document.getElementById('borrowingFilter').addEventListener('change', function() {
                loadBorrowingData(this.value);
            });

            // Inisialisasi chart kategori
            const categoryCtx = document.getElementById('categoryChart');
            if (categoryCtx) {
                categoryChart = new Chart(categoryCtx, {
                    type: "bar",
                    data: {
                        labels: {!! json_encode(array_keys($categories)) !!},
                        datasets: [{
                            label: "Jumlah Barang",
                            data: {!! json_encode(array_values($categories)) !!},
                            backgroundColor: [
                                "#4ade80",
                                "#a78bfa",
                                "#f87171",
                                "#60a5fa",
                                "#FF669C",
                            ],
                            borderWidth: 0,
                            borderRadius: 6,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: "rgba(0, 0, 0, 0.05)",
                                    drawBorder: false,
                                },
                                ticks: {
                                    color: "#6b7280",
                                },
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false,
                                },
                                ticks: {
                                    color: "#6b7280",
                                },
                            },
                        },
                        plugins: {
                            legend: {
                                display: false,
                            },
                        }
                    }
                });
            }

            // Inisialisasi chart peminjaman
            const borrowingCtx = document.getElementById('borrowingChart');
            if (borrowingCtx) {
                // Prepare labels and data for last 30 days
                const dates = [];
                const counts = [];
                const today = new Date();

                for (let i = 29; i >= 0; i--) {
                    const date = new Date(today);
                    date.setDate(today.getDate() - i);
                    const dateString = date.toISOString().split('T')[0];
                    const formattedDate = date.getDate() + ' ' + date.toLocaleString('default', {
                        month: 'short'
                    });
                    dates.push(formattedDate);
                    counts.push({!! json_encode($completeBorrowingsData) !!}[dateString] || 0);
                }

                borrowingChart = new Chart(borrowingCtx, {
                    type: "line",
                    data: {
                        labels: dates,
                        datasets: [{
                            label: "Peminjaman",
                            data: counts,
                            fill: true,
                            backgroundColor: "rgba(79, 70, 229, 0.1)",
                            borderColor: "rgba(79, 70, 229, 1)",
                            tension: 0.4,
                            pointBackgroundColor: "rgba(79, 70, 229, 1)",
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            borderWidth: 2,
                            pointBorderColor: "#fff",
                            pointBorderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: "rgba(0, 0, 0, 0.05)",
                                    drawBorder: false,
                                },
                                ticks: {
                                    color: "#6b7280",
                                },
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false,
                                },
                                ticks: {
                                    color: "#6b7280",
                                    maxRotation: 0,
                                    autoSkip: true,
                                    maxTicksLimit: 10,
                                },
                            },
                        },
                        plugins: {
                            legend: {
                                display: false,
                            },
                        }
                    }
                });
            }

            // Fitur "Lihat Semua" aktivitas
            document.getElementById('showAllActivities').addEventListener('click', function() {
                const button = this;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Memuat...';
                button.disabled = true;

                fetch('/dashboard/all-activities')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const activityContainer = document.getElementById('activityContainer');
                        activityContainer.innerHTML = '';

                        if (data.length === 0) {
                            activityContainer.innerHTML =
                                '<p class="text-gray-300 text-center py-4">Tidak ada aktivitas</p>';
                            return;
                        }

                        data.forEach(activity => {
                            const activityItem = document.createElement('div');
                            activityItem.className =
                                'activity-item p-4 border-b border-gray-500 hover:bg-sky-950 rounded-lg transition-all duration-300';
                            activityItem.innerHTML = `
                                <div class="flex items-start">
                                    <div class="w-10 h-10 rounded-full ${getActivityColorClass(activity.type)}
                                        flex items-center justify-center mr-3 mt-1 shadow-inner">
                                        <i class="fas ${getActivityIconClass(activity.type)}"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-medium text-gray-200">${activity.title}</h4>
                                            <span class="text-xs text-gray-300">${activity.time}</span>
                                        </div>
                                        <p class="text-sm text-gray-300 mt-1">
                                            ${activity.description}
                                        </p>
                                    </div>
                                </div>
                            `;
                            activityContainer.appendChild(activityItem);

                            // Animate the item after adding to DOM
                            setTimeout(() => {
                                activityItem.classList.add('visible');
                            }, 100);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading activities:', error);
                        alert('Gagal memuat aktivitas. Silakan coba lagi.');
                    })
                    .finally(() => {
                        button.innerHTML =
                            'Lihat Semua <i class="fas fa-chevron-right ml-1 text-xs"></i>';
                        button.disabled = false;
                    });
            });

            // Fungsi bantu untuk aktivitas
            function getActivityColorClass(type) {
                switch (type) {
                    case 'return':
                        return 'bg-green-100';
                    case 'borrow':
                        return 'bg-blue-100';
                    case 'damage':
                        return 'bg-red-100';
                    default:
                        return 'bg-indigo-100';
                }
            }

            function getActivityIconClass(type) {
                switch (type) {
                    case 'return':
                        return 'fa-undo text-green-600';
                    case 'borrow':
                        return 'fa-hand-holding text-blue-600';
                    case 'damage':
                        return 'fa-times-circle text-red-600';
                    default:
                        return 'fa-box text-indigo-600';
                }
            }

            // Fitur pencarian aktivitas
            document.getElementById('activitySearch').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const activities = document.querySelectorAll('.activity-item');

                let hasResults = false;

                activities.forEach(activity => {
                    const text = activity.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        activity.style.display = 'block';
                        hasResults = true;
                    } else {
                        activity.style.display = 'none';
                    }
                });

                // Show message if no results
                const noResultsMsg = document.getElementById('noResultsMessage');
                if (!hasResults) {
                    if (!noResultsMsg) {
                        const msg = document.createElement('p');
                        msg.id = 'noResultsMessage';
                        msg.className = 'text-gray-300 text-center py-4';
                        msg.textContent = 'Tidak ditemukan aktivitas yang sesuai';
                        document.getElementById('activityContainer').appendChild(msg);
                    }
                } else if (noResultsMsg) {
                    noResultsMsg.remove();
                }
            });

            // Animate initial activity items
            const activityItems = document.querySelectorAll('.activity-item');
            activityItems.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('visible');
                }, index * 100);
            });

            // Card hover effects
            document.querySelectorAll(".card-hover").forEach((card) => {
                card.addEventListener("mouseenter", () => {
                    card.style.transform = "translateY(-5px) scale(1.02)";
                    card.style.boxShadow = "0 15px 25px rgba(0, 0, 0, 0.1)";
                });

                card.addEventListener("mouseleave", () => {
                    card.style.transform = "translateY(0) scale(1)";
                    card.style.boxShadow = "0 4px 6px rgba(0, 0, 0, 0.05)";
                });
            });
        });

        // Sidebar toggle functionality
        let isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true' || true;

        // Initialize sidebar state
        function initSidebarState() {
            const sidebar = document.getElementById("sidebar");
            const toggleBtn = document.getElementById("toggleSidebar");
            const toggleIcon = toggleBtn.querySelector('i');

            if (isCollapsed) {
                sidebar.classList.add("collapsed");
                sidebar.classList.remove("expanded");
                toggleIcon.className = 'fas fa-chevron-right'; // Panah ke kanan ketika collapsed
            } else {
                sidebar.classList.remove("collapsed");
                sidebar.classList.add("expanded");
                toggleIcon.className = 'fas fa-chevron-left'; // Panah ke kiri ketika expanded
            }
        }

        // Panggil fungsi inisialisasi saat halaman dimuat
        initSidebarState();

        function toggleSidebarState() {
            isCollapsed = !isCollapsed;
            localStorage.setItem('sidebarCollapsed', isCollapsed);

            const sidebar = document.getElementById("sidebar");
            const toggleBtn = document.getElementById("toggleSidebar");
            const toggleIcon = toggleBtn.querySelector('i');

            if (isCollapsed) {
                sidebar.classList.add("collapsed");
                sidebar.classList.remove("expanded");
                toggleIcon.className = 'fas fa-chevron-right'; // Panah ke kanan ketika collapsed
            } else {
                sidebar.classList.remove("collapsed");
                sidebar.classList.add("expanded");
                toggleIcon.className = 'fas fa-chevron-left'; // Panah ke kiri ketika expanded
            }
        }

        // Mobile sidebar toggle
        document.getElementById('mobileToggleSidebar').addEventListener('click', function() {
            isCollapsed = !isCollapsed;
            localStorage.setItem('sidebarCollapsed', isCollapsed);

            const sidebar = document.getElementById("sidebar");
            const toggleBtn = document.getElementById("toggleSidebar");
            const toggleIcon = toggleBtn.querySelector('i');

            if (isCollapsed) {
                sidebar.classList.add("collapsed");
                sidebar.classList.remove("expanded");
                toggleIcon.className = 'fas fa-chevron-right'; // Panah ke kanan ketika collapsed
            } else {
                sidebar.classList.remove("collapsed");
                sidebar.classList.add("expanded");
                toggleIcon.className = 'fas fa-chevron-left'; // Panah ke kiri ketika expanded
            }
        });
    </script>
</body>

</html>
