<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Inventaris - Inventory System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('logoyayasan.png') }}" type="image/x-icon">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jsPDF dan autoTable untuk PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

    <!-- SheetJS untuk Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        .header-gradient {
            background: #131924;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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

        .table-container {
            background: linear-gradient(to top left, #0c4a6e, #131924);
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .table-container:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .table-row-hover:hover {
            background-color: #1e3a8a;
        }

        .badge {
            transition: all 0.2s ease;
        }

        .modern-select {
            transition: all 0.3s ease;
            border-radius: 0.375rem;
        }

        .modern-select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }

        .btn-scale {
            transition: transform 0.15s ease;
        }

        .btn-scale:hover {
            transform: scale(1.05);
        }

        .btn-scale:active {
            transform: scale(0.98);
        }

        .card-hover {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .card-hover:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
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
            background-color: #a21caf;
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
    </style>
</head>

<body class="bg-[#10151D]">
    <div class="flex h-screen w-full overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar"
            class="sidebar bg-[#131924] text-white flex-shrink-0 collapsed relative h-full">
            <div class="flex flex-col h-full">
                <!-- Top part of sidebar (logo and menu) -->
                <div class="flex-1 overflow-y-auto">
                    <div class="p-4 flex items-center justify-between border-b border-fuchsia-500">
                        <div class="flex items-center space-x-2">
                            <img src="{{ asset('logoyayasan.png') }}" alt="logo" class="w-10 mr-3">
                            <span class="text-xl font-bold logo-text text-indigo-50">
                                Inventory System
                            </span>
                        </div>
                    </div>
                    <nav class="p-4">
                        <div class="space-y-1">
                            <a href="/admin/dashboard"
                                class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt text-white"></i>
                                <span class="nav-text font-medium text-white">
                                    Dashboard
                                </span>
                            </a>
                            <a href="/admin/databarang"
                                class="nav-item {{ request()->is('admin/databarang') ? 'active' : '' }}">
                                <i class="fas fa-box text-white"></i>
                                <span class="nav-text font-medium text-white">
                                    Data Barang
                                </span>
                            </a>
                            <a href="/admin/dataorang"
                                class="nav-item {{ request()->is('admin/dataorang') ? 'active' : '' }}">
                                <i class="fas fa-users text-white"></i>
                                <span class="nav-text font-medium text-white">
                                    Data Peminjam
                                </span>
                            </a>
                            <a href="/admin/peminjaman"
                                class="nav-item {{ request()->is('admin/peminjaman') ? 'active' : '' }}">
                                <i class="fas fa-exchange-alt text-white"></i>
                                <span class="nav-text font-medium text-white">
                                    Peminjaman
                                </span>
                            </a>
                            <a href="/admin/laporan"
                                class="nav-item {{ request()->is('admin/laporan') ? 'active' : '' }}">
                                <i class="fas fa-chart-bar text-white"></i>
                                <span class="nav-text font-medium text-white">
                                    Laporan
                                </span>
                            </a>
                            <a href="/admin/pengguna"
                                class="nav-item {{ request()->is('admin/profile') ? 'active' : '' }}">
                                <i class="fas fa-user text-white"></i>
                                <span class="nav-text font-medium text-white">
                                    Pengguna
                                </span>
                            </a>
                        </div>
                    </nav>
                </div>

                <!-- Bottom part of sidebar (user info and logout) -->
                <div class="w-full p-4 border-t border-fuchsia-500">
                    <div class="flex items-center space-x-2 mb-3">
                        <div class="user-avatar">
                            <img src="{{ asset('sidebar/admin.png') }}" alt="admin" class="rounded-full">
                        </div>
                        <div class="user-info">
                            <div class="font-medium text-lime-200">
                                {{ Auth::user()->first_name ?? 'Admin' }} {{ Auth::user()->last_name ?? 'User' }}
                            </div>
                            <div class="text-xs text-indigo-100">
                                {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Pengguna' }}
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
            <header class="bg-[#131924] p-4 flex items-center justify-between sticky top-0 z-10">
                <div class="flex items-center">
                    <button id="toggleSidebar"
                        class="text-indigo-200 hover:text-white focus:outline-none toggle-btn collapsed transition-colors mr-5"
                        onclick="toggleSidebarState()">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <h1 class="text-2xl font-bold text-white animate__animated animate__fadeIn">
                        Laporan Inventaris
                    </h1>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6 animate__animated animate__fadeIn animate__faster">
                <!-- Report Controls -->
                <div class="bg-gradient-to-tl from-sky-950 to-[#131924] bg-opacity-25 rounded-xl shadow-md p-6 mb-6 card-hover">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="reportType" class="block text-sm font-medium text-gray-300 mb-1">
                                Jenis Laporan
                            </label>
                            <select id="reportType"
                                class="modern-select bg-[#131924] border border-gray-600 rounded-md shadow-sm py-2 px-3 text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 w-full">
                                <option value="">-- Pilih Jenis Laporan --</option>
                                <option value="barang_masuk">Laporan Barang Masuk</option>
                                <option value="peminjaman">Laporan Peminjaman</option>
                                <option value="pengembalian">Laporan Pengembalian</option>
                            </select>
                        </div>

                        <div>
                            <label for="timePeriod" class="block text-sm font-medium text-gray-300 mb-1">
                                Periode Waktu
                            </label>
                            <select id="timePeriod"
                                class="modern-select bg-[#131924] border border-gray-600 rounded-md shadow-sm py-2 px-3 text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 w-full">
                                <option value="hari_ini">Hari Ini</option>
                                <option value="minggu_ini">Minggu Ini</option>
                                <option value="bulan_ini">Bulan Ini</option>
                                <option value="tahun_ini">Tahun Ini</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>

                        <div id="customDateRange" class="hidden">
                            <label class="block text-sm font-medium text-gray-300 mb-1">
                                Rentang Tanggal
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="date" id="startDate"
                                    class="modern-select bg-[#131924] border border-gray-600 rounded-md shadow-sm py-2 px-3 text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <input type="date" id="endDate"
                                    class="modern-select bg-[#131924] border border-gray-600 rounded-md shadow-sm py-2 px-3 text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-between items-center">
                        <button id="generateReport"
                            class="bg-fuchsia-500 hover:bg-fuchsia-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors btn-scale">
                            <i class="fas fa-sync-alt"></i>
                            <span>Generate Laporan</span>
                        </button>

                        <div class="flex space-x-2">
                            <button id="printPdf"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors btn-scale">
                                <i class="fas fa-file-pdf"></i>
                                <span>Cetak PDF</span>
                            </button>
                            <button id="exportExcel"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors btn-scale">
                                <i class="fas fa-file-excel"></i>
                                <span>Export Excel</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Report Preview -->
                <div class="bg-gradient-to-tl from-sky-950 to-[#131924] rounded-xl shadow-md overflow-hidden table-container">
                    <div class="p-4 border-b border-gray-600 flex justify-between items-center">
                        <h2 class="text-lg font-medium text-gray-300">
                            Preview Laporan
                        </h2>
                        <div id="reportInfo" class="text-sm text-gray-400 hidden">
                            <span id="reportTitle"></span> - <span id="reportPeriod"></span>
                        </div>
                    </div>

                    <!-- Report Content -->
                    <div class="p-6">
                        <!-- Default empty state -->
                        <div id="emptyReport" class="text-center py-12">
                            <i class="fas fa-file-alt text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-300">
                                Belum ada laporan yang digenerate
                            </h3>
                            <p class="mt-1 text-sm text-gray-400">
                                Pilih jenis laporan dan periode waktu, lalu klik tombol "Generate Laporan"
                            </p>
                        </div>

                        <!-- Barang Masuk Report -->
                        <div id="barangMasukReport" class="hidden">
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-gray-300 mb-2">
                                    Laporan Barang Masuk
                                </h3>
                                <p class="text-sm text-gray-400" id="barangMasukPeriod">
                                    Periode: Hari Ini
                                </p>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-600">
                                    <thead class="bg-[#131924]">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Kode Barang
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Nama Barang
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Kategori
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Jumlah
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Tanggal Masuk
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Kondisi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-[#131924] divide-y divide-gray-600">
                                        <tr class="table-row-hover animate__animated animate__fadeIn">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                                INV-2023-0001
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                Laptop Dell XPS 15
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                Elektronik
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                5
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                15 Jan 2023
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 badge">
                                                    Baik
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="table-row-hover animate__animated animate__fadeIn"
                                            style="animation-delay: 0.1s">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                                INV-2023-0002
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                Proyektor Epson EB-U05
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                Elektronik
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                3
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                20 Jan 2023
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 badge">
                                                    Baik
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="table-row-hover animate__animated animate__fadeIn"
                                            style="animation-delay: 0.2s">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                                INV-2023-0003
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                Meja Kantor
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                Furnitur
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                12
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                5 Feb 2023
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 badge">
                                                    Baik
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-600">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-300">
                                            Total Barang Masuk
                                        </h4>
                                        <p class="text-2xl font-bold text-indigo-400">
                                            20 item
                                        </p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-300">
                                            Total Kategori Barang
                                        </h4>
                                        <p class="text-2xl font-bold text-indigo-400">
                                            3 kategori
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Peminjaman Report -->
                        <div id="peminjamanReport" class="hidden">
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-gray-300 mb-2">
                                    Laporan Peminjaman
                                </h3>
                                <p class="text-sm text-gray-400" id="peminjamanPeriod">
                                    Periode: Hari Ini
                                </p>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-600">
                                    <thead class="bg-[#131924]">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Kode Peminjaman
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Nama Barang
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Peminjam
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Tanggal Pinjam
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Tanggal Kembali
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Status
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-[#131924] divide-y divide-gray-600">
                                        <tr class="table-row-hover animate__animated animate__fadeIn">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                                TRX-2023-001
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                Laptop Dell XPS 15
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                John Doe (IT)
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                10 Jan 2023
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                17 Jan 2023
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 badge">
                                                    Sudah Kembali
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="table-row-hover animate__animated animate__fadeIn"
                                            style="animation-delay: 0.1s">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                                TRX-2023-002
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                Proyektor Epson EB-U05
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                Jane Smith (HR)
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                15 Jan 2023
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                22 Jan 2023
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 badge">
                                                    Sudah Kembali
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="table-row-hover animate__animated animate__fadeIn"
                                            style="animation-delay: 0.2s">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                                TRX-202

3-003
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                Meja Kantor
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                Robert Johnson (Finance)
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                20 Jan 2023
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                27 Jan 2023
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 badge">
                                                    Belum Kembali
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-600">
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-300">
                                            Total Peminjaman
                                        </h4>
                                        <p class="text-2xl font-bold text-indigo-400">
                                            3 transaksi
                                        </p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-300">
                                            Sudah Kembali
                                        </h4>
                                        <p class="text-2xl font-bold text-green-500">
                                            2 item
                                        </p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-300">
                                            Belum Kembali
                                        </h4>
                                        <p class="text-2xl font-bold text-yellow-500">
                                            1 item
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pengembalian Report -->
                        <div id="pengembalianReport" class="hidden">
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-gray-300 mb-2">
                                    Laporan Pengembalian
                                </h3>
                                <p class="text-sm text-gray-400" id="pengembalianPeriod">
                                    Periode: Hari Ini
                                </p>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-600">
                                    <thead class="bg-[#131924]">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Kode Pengembalian
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Nama Barang
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Peminjam
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Tanggal Kembali
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                Kondisi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-[#131924] divide-y divide-gray-600">
                                        <tr class="table-row-hover animate__animated animate__fadeIn">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                                RTN-2023-001
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                Laptop Dell XPS 15
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                John Doe (IT)
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                17 Jan 2023
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 badge">
                                                    Baik
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="table-row-hover animate__animated animate__fadeIn"
                                            style="animation-delay: 0.1s">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                                RTN-2023-002
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                Proyektor Epson EB-U05
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                Jane Smith (HR)
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                22 Jan 2023
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 badge">
                                                    Rusak Ringan
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-600">
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-300">
                                            Total Pengembalian
                                        </h4>
                                        <p class="text-2xl font-bold text-indigo-400">
                                            2 transaksi
                                        </p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-300">
                                            Kondisi Baik
                                        </h4>
                                        <p class="text-2xl font-bold text-green-500">
                                            1 item
                                        </p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-300">
                                            Kondisi Rusak
                                        </h4>
                                        <p class="text-2xl font-bold text-yellow-500">
                                            1 item
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Initialize jsPDF
        const {
            jsPDF
        } = window.jspdf;

        // Initialize Charts
        document.addEventListener('DOMContentLoaded', function() {
            // DOM elements
            const reportTypeSelect = document.getElementById('reportType');
            const timePeriodSelect = document.getElementById('timePeriod');
            const customDateRange = document.getElementById('customDateRange');
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');
            const generateReportBtn = document.getElementById('generateReport');
            const printPdfBtn = document.getElementById('printPdf');
            const exportExcelBtn = document.getElementById('exportExcel');
            const emptyReport = document.getElementById('emptyReport');
            const reportInfo = document.getElementById('reportInfo');
            const reportTitle = document.getElementById('reportTitle');
            const reportPeriod = document.getElementById('reportPeriod');

            // Report sections
            const barangMasukReport = document.getElementById('barangMasukReport');
            const peminjamanReport = document.getElementById('peminjamanReport');
            const pengembalianReport = document.getElementById('pengembalianReport');

            // Period texts
            const barangMasukPeriod = document.getElementById('barangMasukPeriod');
            const peminjamanPeriod = document.getElementById('peminjamanPeriod');
            const pengembalianPeriod = document.getElementById('pengembalianPeriod');

            // Toggle custom date range visibility
            timePeriodSelect.addEventListener('change', function() {
                if (this.value === 'custom') {
                    customDateRange.classList.remove('hidden');
                } else {
                    customDateRange.classList.add('hidden');
                }
            });

            // Format date to Indonesian format
            function formatDate(dateString) {
                if (!dateString) return "";
                const options = {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            }

            // Get report period text
            function getReportPeriodText() {
                const timePeriod = timePeriodSelect.value;
                let periodText = "";

                if (timePeriod === 'hari_ini') {
                    periodText = "Hari Ini";
                } else if (timePeriod === 'minggu_ini') {
                    periodText = "Minggu Ini";
                } else if (timePeriod === 'bulan_ini') {
                    periodText = "Bulan Ini";
                } else if (timePeriod === 'tahun_ini') {
                    periodText = "Tahun Ini";
                } else if (timePeriod === 'custom') {
                    periodText = `${formatDate(startDateInput.value)} - ${formatDate(endDateInput.value)}`;
                }

                return periodText;
            }

            // Generate report
            generateReportBtn.addEventListener('click', async function() {
                const reportType = reportTypeSelect.value;
                const timePeriod = timePeriodSelect.value;
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;

                if (!reportType) {
                    alert('Silakan pilih jenis laporan terlebih dahulu');
                    return;
                }

                // Validasi khusus untuk periode "custom"
                if (timePeriod === 'custom') {
                    if (!startDate || !endDate) {
                        alert('Silakan pilih rentang tanggal untuk periode custom');
                        return;
                    }
                    if (new Date(endDate) < new Date(startDate)) {
                        alert('Tanggal akhir tidak boleh sebelum tanggal mulai');
                        return;
                    }
                }

                // Show loading state
                generateReportBtn.disabled = true;
                generateReportBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';

                try {
                    const requestData = {
                        type: reportType,
                        period: timePeriod
                    };

                    // Hanya kirim tanggal jika period = custom
                    if (timePeriod === 'custom') {
                        requestData.start_date = startDate;
                        requestData.end_date = endDate;
                    }

                    const response = await fetch('{{ route('laporan.generate') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(requestData)
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Server error');
                    }

                    const data = await response.json();

                    if (!data.success) {
                        throw new Error(data.message);
                    }

                    // Hide empty state and show report info
                    emptyReport.classList.add('hidden');
                    reportInfo.classList.remove('hidden');

                    // Set report title and period
                    let title = '';
                    if (data.type === 'barang_masuk') {
                        title = 'Laporan Barang Masuk';
                    } else if (data.type === 'peminjaman') {
                        title = 'Laporan Peminjaman';
                    } else if (data.type === 'pengembalian') {
                        title = 'Laporan Pengembalian';
                    }

                    reportTitle.textContent = title;
                    reportPeriod.textContent = data.periodText;

                    // Hide all reports first
                    barangMasukReport.classList.add('hidden');
                    peminjamanReport.classList.add('hidden');
                    pengembalianReport.classList.add('hidden');

                    // Show selected report and populate data
                    if (data.type === 'barang_masuk') {
                        populateBarangMasuk(data.data, data.summary, data.periodText);
                        barangMasukReport.classList.remove('hidden');
                    } else if (data.type === 'peminjaman') {
                        populatePeminjaman(data.data, data.summary, data.periodText);
                        peminjamanReport.classList.remove('hidden');
                    } else if (data.type === 'pengembalian') {
                        populatePengembalian(data.data, data.summary, data.periodText);
                        pengembalianReport.classList.remove('hidden');
                    }

                } catch (error) {
                    console.error('Error:', error);
                    alert(`Terjadi kesalahan: ${error.message}`);
                } finally {
                    generateReportBtn.disabled = false;
                    generateReportBtn.innerHTML =
                        '<i class="fas fa-sync-alt"></i><span>Generate Laporan</span>';
                }
            });

            // Helper functions untuk populate tabel
            function populateBarangMasuk(items, summary, periodText) {
                const tbody = barangMasukReport.querySelector('tbody');
                tbody.innerHTML = '';

                barangMasukPeriod.textContent = `Periode: ${periodText}`;

                items.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.className = `table-row-hover animate__animated animate__fadeIn`;
                    row.style.animationDelay = `${index * 0.1}s`;

                    row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                ${item.kode_barang}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                ${item.nama_barang}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                ${item.kategori}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                ${item.jumlah}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                ${new Date(item.tanggal_masuk).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getConditionClass(item.kondisi)}">
                    ${item.kondisi}
                </span>
            </td>
        `;

                    tbody.appendChild(row);
                });

                // Update summary
                barangMasukReport.querySelector('.text-indigo-400').textContent = `${summary.total_items} item`;
                barangMasukReport.querySelectorAll('.text-indigo-400')[1].textContent =
                    `${summary.total_categories} kategori`;
            }

            function populatePeminjaman(borrowings, summary, periodText) {
                const tbody = peminjamanReport.querySelector('tbody');
                tbody.innerHTML = '';

                peminjamanPeriod.textContent = `Periode: ${periodText}`;

                borrowings.forEach((borrowing, index) => {
                    const row = document.createElement('tr');
                    row.className = `table-row-hover animate__animated animate__fadeIn`;
                    row.style.animationDelay = `${index * 0.1}s`;

                    row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                ${borrowing.kode_peminjaman}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                ${borrowing.item.nama_barang}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                ${borrowing.person.nama} (${borrowing.person.departemen})
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                ${new Date(borrowing.tanggal_pinjam).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                ${new Date(borrowing.tanggal_kembali).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getStatusClass(borrowing.status)}">
                    ${borrowing.status}
                </span>
            </td>
        `;

                    tbody.appendChild(row);
                });

                // Update summary
                peminjamanReport.querySelector('.text-indigo-400').textContent =
                    `${summary.total_borrowings} transaksi`;
                peminjamanReport.querySelector('.text-green-500').textContent = `${summary.returned} item`;
                peminjamanReport.querySelector('.text-yellow-500').textContent = `${summary.not_returned} item`;
            }

            function populatePengembalian(returns, summary, periodText) {
                const tbody = pengembalianReport.querySelector('tbody');
                tbody.innerHTML = '';

                pengembalianPeriod.textContent = `Periode: ${periodText}`;

                returns.forEach((returnItem, index) => {
                    const row = document.createElement('tr');
                    row.className = `table-row-hover animate__animated animate__fadeIn`;
                    row.style.animationDelay = `${index * 0.1}s`;

                    row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                ${returnItem.kode_peminjaman}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                ${returnItem.item.nama_barang}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                ${returnItem.person.nama} (${returnItem.person.departemen})
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                ${new Date(returnItem.tanggal_dikembalikan).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getConditionClass(returnItem.kondisi_kembali)}">
                    ${returnItem.kondisi_kembali}
                </span>
            </td>
        `;

                    tbody.appendChild(row);
                });

                // Update summary
                pengembalianReport.querySelector('.text-indigo-400').textContent =
                    `${summary.total_returns} transaksi`;
                pengembalianReport.querySelector('.text-green-500').textContent = `${summary.good_condition} item`;
                pengembalianReport.querySelector('.text-yellow-500').textContent =
                    `${summary.damaged_condition} item`;
            }

            function getConditionClass(condition) {
                switch (condition) {
                    case 'Baik':
                        return 'bg-green-500 text-white';
                    case 'Rusak Ringan':
                        return 'bg-yellow-500 text-white';
                    case 'Rusak Berat':
                        return 'bg-red-500 text-white';
                    default:
                        return 'bg-gray-100 text-gray-800';
                }
            }

            function getStatusClass(status) {
                switch (status) {
                    case 'Dikembalikan':
                        return 'bg-green-500 text-white';
                    case 'Dipinjam':
                        return 'bg-yellow-500 text-white';
                    case 'Hilang':
                        return 'bg-red-500 text-white';
                    case 'Rusak':
                        return 'bg-red-500 text-white';
                    default:
                        return 'bg-gray-100 text-gray-800';
                }
            }

            // Print PDF
            printPdfBtn.addEventListener('click', function() {
                if (emptyReport.classList.contains('hidden')) {
                    exportToPDF();
                } else {
                    alert('Silakan generate laporan terlebih dahulu');
                }
            });

            // Export Excel
            exportExcelBtn.addEventListener('click', function() {
                if (emptyReport.classList.contains('hidden')) {
                    exportToExcel();
                } else {
                    alert('Silakan generate laporan terlebih dahulu');
                }
            });

            // Fungsi untuk export ke PDF dengan konten terstruktur menggunakan autoTable
            function exportToPDF() {
                // Inisialisasi PDF
                const doc = new jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });

                // Judul laporan
                const reportName = reportTitle.textContent || 'Laporan';
                const period = reportPeriod.textContent || '';
                const currentDate = new Date().toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

                // Set font dan warna untuk header
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(16);
                doc.setTextColor(40, 40, 40);
                doc.text(reportName, 105, 20, {
                    align: 'center'
                });

                // Sub judul
                doc.setFontSize(12);
                doc.setFont('helvetica', 'normal');
                doc.text(period, 105, 28, {
                    align: 'center'
                });

                // Info tanggal cetak
                doc.setFontSize(10);
                doc.text(`Dicetak pada: ${currentDate}`, 105, 35, {
                    align: 'center'
                });

                // Garis pemisah
                doc.setDrawColor(200, 200, 200);
                doc.line(20, 40, 190, 40);

                // Dapatkan data dari tabel yang aktif
                let headers = [];
                let rows = [];

                if (!barangMasukReport.classList.contains('hidden')) {
                    headers = ['Kode Barang', 'Nama Barang', 'Kategori', 'Jumlah', 'Tanggal Masuk', 'Kondisi'];
                    rows = getTableData(barangMasukReport);
                } else if (!peminjamanReport.classList.contains('hidden')) {
                    headers = ['Kode Peminjaman', 'Nama Barang', 'Peminjam', 'Tanggal Pinjam', 'Tanggal Kembali',
                        'Status'
                    ];
                    rows = getTableData(peminjamanReport);
                } else if (!pengembalianReport.classList.contains('hidden')) {
                    headers = ['Kode Pengembalian', 'Nama Barang', 'Peminjam', 'Tanggal Kembali', 'Kondisi'];
                    rows = getTableData(pengembalianReport);
                }

                // Buat tabel menggunakan autoTable
                if (rows.length > 0) {
                    doc.autoTable({
                        startY: 45,
                        head: [headers],
                        body: rows,
                        theme: 'grid',
                        styles: {
                            font: 'helvetica',
                            fontSize: 10,
                            cellPadding: 2,
                            overflow: 'linebreak',
                            halign: 'left',
                            valign: 'middle'
                        },
                        headStyles: {
                            fillColor: [99, 102, 241],
                            textColor: [255, 255, 255],
                            fontStyle: 'bold'
                        },
                        columnStyles: {
                            0: {
                                cellWidth: 30
                            },
                            1: {
                                cellWidth: 50
                            },
                            2: {
                                cellWidth: 30
                            },
                            3: {
                                cellWidth: 20
                            },
                            4: {
                                cellWidth: 30
                            },
                            5: {
                                cellWidth: 25
                            }
                        },
                        margin: {
                            top: 45,
                            left: 10,
                            right: 10
                        },
                        didDrawPage: function(data) {
                            const pageCount = doc.internal.getNumberOfPages();
                            doc.setFontSize(8);
                            doc.setTextColor(150, 150, 150);
                            doc.text(`Halaman ${data.pageNumber} dari ${pageCount}`, 105, 287, {
                                align: 'center'
                            });
                        }
                    });
                }

                // Simpan PDF
                doc.save(`${reportName}_${currentDate}.pdf`);
            }

            // Fungsi untuk mendapatkan data dari tabel HTML
            function getTableData(reportSection) {
                const table = reportSection.querySelector('table');
                if (!table) return [];

                const rows = [];
                const tableRows = table.querySelectorAll('tbody tr');

                tableRows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const rowData = [];

                    cells.forEach(cell => {
                        const badge = cell.querySelector('span.badge');
                        if (badge) {
                            rowData.push(badge.textContent.trim());
                        } else {
                            rowData.push(cell.textContent.trim());
                        }
                    });

                    rows.push(rowData);
                });

                return rows;
            }

            // Fungsi untuk export ke Excel dengan template rapi
            function exportToExcel() {
                // Dapatkan informasi laporan
                const reportName = reportTitle.textContent || 'Laporan';
                const period = reportPeriod.textContent || '';
                const currentDate = new Date().toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

                // Dapatkan tabel yang aktif
                let headers = [];
                let rows = [];
                let summary = [];

                if (!barangMasukReport.classList.contains('hidden')) {
                    headers = ['Kode Barang', 'Nama Barang', 'Kategori', 'Jumlah', 'Tanggal Masuk', 'Kondisi'];
                    rows = getTableData(barangMasukReport);
                    summary = [
                        ['Total Barang Masuk', barangMasukReport.querySelector('.text-indigo-400').textContent],
                        ['Total Kategori Barang', barangMasukReport.querySelectorAll('.text-indigo-400')[1]
                            .textContent
                        ]
                    ];
                } else if (!peminjamanReport.classList.contains('hidden')) {
                    headers = ['Kode Peminjaman', 'Nama Barang', 'Peminjam', 'Tanggal Pinjam', 'Tanggal Kembali',
                        'Status'
                    ];
                    rows = getTableData(peminjamanReport);
                    summary = [
                        ['Total Peminjaman', peminjamanReport.querySelector('.text-indigo-400').textContent],
                        ['Sudah Kembali', peminjamanReport.querySelector('.text-green-500').textContent],
                        ['Belum Kembali', peminjamanReport.querySelector('.text-yellow-500').textContent]
                    ];
                } else if (!pengembalianReport.classList.contains('hidden')) {
                    headers = ['Kode Pengembalian', 'Nama Barang', 'Peminjam', 'Tanggal Kembali', 'Kondisi'];
                    rows = getTableData(pengembalianReport);
                    summary = [
                        ['Total Pengembalian', pengembalianReport.querySelector('.text-indigo-400')
                        .textContent],
                        ['Kondisi Baik', pengembalianReport.querySelector('.text-green-500').textContent],
                        ['Kondisi Rusak', pengembalianReport.querySelector('.text-yellow-500').textContent]
                    ];
                }

                if (rows.length === 0) {
                    Swal.fire('Error', 'Tidak ada data untuk diexport', 'error');
                    return;
                }

                // Buat workbook dan worksheet baru
                const workbook = XLSX.utils.book_new();
                const worksheetData = [];

                // Tambahkan header laporan
                worksheetData.push([reportName]);
                worksheetData.push(['Periode:', period]);
                worksheetData.push(['Dicetak pada:', currentDate]);
                worksheetData.push([]); // Baris kosong

                // Tambahkan header tabel
                worksheetData.push(headers);

                // Tambahkan data tabel
                worksheetData.push(...rows);

                // Tambahkan baris kosong sebelum summary
                worksheetData.push([]);

                // Tambahkan summary
                worksheetData.push(...summary);

                // Buat worksheet dari data
                const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);

                // Terapkan formatting
                const range = XLSX.utils.decode_range(worksheet['!ref']);
                for (let col = range.s.c; col <= range.e.c; col++) {
                    for (let row = range.s.r; row <= range.e.r; row++) {
                        const cellAddress = XLSX.utils.encode_cell({
                            r: row,
                            c: col
                        });
                        if (!worksheet[cellAddress]) continue;

                        // Format header laporan (judul, periode, tanggal)
                        if (row < 3 && col === 0) {
                            worksheet[cellAddress].s = {
                                font: {
                                    bold: true,
                                    sz: row === 0 ? 16 : 12
                                },
                                alignment: {
                                    horizontal: 'left',
                                    vertical: 'center'
                                }
                            };
                        }

                        // Format header tabel
                        if (row === 4) {
                            worksheet[cellAddress].s = {
                                font: {
                                    bold: true
                                },
                                fill: {
                                    fgColor: {
                                        rgb: '6366F1'
                                    }
                                },
                                alignment: {
                                    horizontal: 'center',
                                    vertical: 'center'
                                },
                                border: {
                                    top: {
                                        style: 'thin'
                                    },
                                    bottom: {
                                        style: 'thin'
                                    },
                                    left: {
                                        style: 'thin'
                                    },
                                    right: {
                                        style: 'thin'
                                    }
                                }
                            };
                        }

                        // Format data tabel
                        if (row >= 5 && row < 5 + rows.length) {
                            worksheet[cellAddress].s = {
                                alignment: {
                                    horizontal: 'left',
                                    vertical: 'center',
                                    wrapText: true
                                },
                                border: {
                                    top: {
                                        style: 'thin'
                                    },
                                    bottom: {
                                        style: 'thin'
                                    },
                                    left: {
                                        style: 'thin'
                                    },
                                    right: {
                                        style: 'thin'
                                    }
                                }
                            };
                        }

                        // Format summary
                        if (row >= 5 + rows.length + 1) {
                            worksheet[cellAddress].s = {
                                font: {
                                    bold: col === 0
                                },
                                alignment: {
                                    horizontal: col === 0 ? 'left' : 'right',
                                    vertical: 'center'
                                },
                                border: {
                                    top: {
                                        style: 'thin'
                                    },
                                    bottom: {
                                        style: 'thin'
                                    },
                                    left: {
                                        style: 'thin'
                                    },
                                    right: {
                                        style: 'thin'
                                    }
                                }
                            };
                        }
                    }
                }

                // Atur lebar kolom
                const colWidths = headers.map((header, i) => ({
                    wch: Math.max(
                        header.length,
                        ...rows.map(row => (row[i] || '').toString().length)
                    ) + 5
                }));
                worksheet['!cols'] = colWidths;

                // Tambahkan worksheet ke workbook
                XLSX.utils.book_append_sheet(workbook, worksheet, "Laporan");

                // Export ke file Excel
                XLSX.writeFile(workbook, `${reportName}_${currentDate}.xlsx`);
            }

            // Initialize animations for table rows
            const tableRows = document.querySelectorAll('tbody tr');
            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate__fadeIn');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1
                }
            );

            tableRows.forEach((row) => {
                observer.observe(row);
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
                toggleIcon.className = 'fas fa-chevron-right';
            } else {
                sidebar.classList.remove("collapsed");
                sidebar.classList.add("expanded");
                toggleIcon.className = 'fas fa-chevron-left';
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
                toggleIcon.className = 'fas fa-chevron-right';
            } else {
                sidebar.classList.remove("collapsed");
                sidebar.classList.add("expanded");
                toggleIcon.className = 'fas fa-chevron-left';
            }
        }
    </script>
</body>

</html>