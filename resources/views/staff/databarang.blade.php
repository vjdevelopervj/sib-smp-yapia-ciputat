<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - Inventory System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('logoyayasan.png') }}" type="image/x-icon">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .card-hover {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            background: linear-gradient(to top left, #0C4A6E, #131924);
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

        .badge {
            @apply px-2 py-1 text-xs font-semibold rounded-full text-white;
        }

        .table-row-hover:hover {
            background-color: #1e293b;
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
            background: #131924;
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
            color: #fff;
        }

        .nav-text {
            transition: opacity 0.3s ease, width 0.3s ease;
            white-space: nowrap;
            color: #fff;
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
            background-color: rgba(79, 70, 229, 0.7);
            color: white;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background-color: rgba(79, 70, 229, 0.9);
        }

        .logout-btn i {
            margin-right: 0.75rem;
            color: #fff;
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

        /* Notification Styles */
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
            width: 100%;
        }

        .notification {
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .notification-success {
            background-color: #1e293b;
            border-left: 4px solid #10b981;
            color: #10b981;
        }

        .notification-error {
            background-color: #1e293b;
            border-left: 4px solid #ef4444;
            color: #ef4444;
        }

        .notification-content {
            padding: 1rem;
            display: flex;
            align-items: center;
        }

        .notification-icon {
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        .notification-close {
            margin-left: auto;
            cursor: pointer;
            background: transparent;
            border: none;
            color: #6b7280;
        }

        /* Modal styles */
        .modal {
            background: #1e293b;
            color: #e0e7ff;
        }

        .modal input,
        .modal select,
        .modal textarea {
            background: #131924;
            border: 1px solid #4b5563;
            color: #e0e7ff;
        }

        .modal input:focus,
        .modal select:focus,
        .modal textarea:focus {
            border-color: #6366f1;
            outline: none;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }

        .modal label {
            color: #9ca3af;
        }

        .modal .bg-gray-50 {
            background: #1e293b;
        }

        /* Animation */
        .animate-slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }

        .animate-slide-out {
            animation: slideOut 0.5s ease-out forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
</head>

<body class="bg-[#10151D]">
    <!-- Notification Container -->
    <div class="notification-container">
        @if (session('success'))
            <div id="successNotification" class="notification notification-success animate-slide-in">
                <div class="notification-content">
                    <i class="fas fa-check-circle notification-icon"></i>
                    <span>{{ session('success') }}</span>
                    <button onclick="hideNotification('successNotification')" class="notification-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div id="errorNotification" class="notification notification-error animate-slide-in">
                <div class="notification-content">
                    <i class="fas fa-exclamation-circle notification-icon"></i>
                    <span>{{ session('error') }}</span>
                    <button onclick="hideNotification('errorNotification')" class="notification-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>

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
                                Inventory System
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
                            <i class="fas fa-sign-out-alt text-white"></i>
                            <span class="nav-text font-medium text-white">
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
                        class="text-white hover:text-indigo-200 focus:outline-none toggle-btn collapsed transition-colors mr-5"
                        onclick="toggleSidebarState()">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    {{-- <button id="mobileToggleSidebar"
                        class="text-white hover:text-indigo-200 mr-4 focus:outline-none lg:hidden transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button> --}}
                    <h1 class="text-2xl font-bold text-white animate__animated animate__fadeIn">
                        Data Barang
                    </h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <form action="{{ route('staff.databarang.index') }}" method="GET">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari barang..."
                                class="search-input pl-10 pr-4 py-2 bg-[#131924] border border-gray-500 text-gray-300 focus:outline-none focus:border-indigo-500 w-64"
                                onkeypress="if(event.keyCode == 13) { this.form.submit(); }">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            @if (request('kategori'))
                                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                            @endif
                            @if (request('kondisi'))
                                <input type="hidden" name="kondisi" value="{{ request('kondisi') }}">
                            @endif
                            @if (request('lokasi'))
                                <input type="hidden" name="lokasi" value="{{ request('lokasi') }}">
                            @endif
                            @if (request('perPage'))
                                <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                            @endif
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6 animate__animated animate__fadeIn animate__faster">
                <!-- Action Bar -->
                <div class="bg-gradient-to-tl from-sky-950 to-[#131924] rounded-xl shadow-md p-6 mb-6 card-hover">
                    <form id="filterForm" action="{{ route('staff.databarang.index') }}" method="GET">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <button type="button" onclick="openAddModal()"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-all">
                                    <i class="fas fa-plus"></i>
                                    <span>Tambah Barang</span>
                                </button>

                                <div class="relative">
                                    <select name="kategori" onchange="document.getElementById('filterForm').submit()"
                                        class="modern-select bg-[#131924] text-gray-300 border border-gray-500 px-3 py-2 text-sm">
                                        <option value="">Semua Kategori</option>
                                        @foreach ($kategoriOptions as $kategori)
                                            <option value="{{ $kategori }}"
                                                {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                                {{ $kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="relative">
                                    <select name="kondisi" onchange="document.getElementById('filterForm').submit()"
                                        class="modern-select bg-[#131924] text-gray-300 border border-gray-500 px-3 py-2 text-sm">
                                        <option value="">Semua Kondisi</option>
                                        @foreach ($kondisiOptions as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ request('kondisi') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="relative">
                                    <select name="lokasi" onchange="document.getElementById('filterForm').submit()"
                                        class="modern-select bg-[#131924] text-gray-300 border border-gray-500 px-3 py-2 text-sm">
                                        <option value="">Semua Lokasi</option>
                                        @foreach ($lokasiOptions as $lokasi)
                                            <option value="{{ $lokasi }}"
                                                {{ request('lokasi') == $lokasi ? 'selected' : '' }}>
                                                {{ $lokasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-300">Items per page:</span>
                                <select name="perPage" onchange="document.getElementById('filterForm').submit()"
                                    class="modern-select bg-[#131924] text-gray-300 border border-gray-500 px-2 py-1 text-sm">
                                    <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10
                                    </option>
                                    <option value="25" {{ request('perPage', 10) == 25 ? 'selected' : '' }}>25
                                    </option>
                                    <option value="50" {{ request('perPage', 10) == 50 ? 'selected' : '' }}>50
                                    </option>
                                    <option value="100" {{ request('perPage', 10) == 100 ? 'selected' : '' }}>100
                                    </option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="bg-gradient-to-tl from-sky-950 to-[#131924] rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-[#1e293b]">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Kode Barang
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Nama Barang
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Kategori
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Lokasi
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Jumlah
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Kondisi
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Tanggal Masuk
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @forelse ($items as $item)
                                    <tr class="table-row-hover">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-100">
                                            {{ $item->kode_barang }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $item->nama_barang }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $item->kategori }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $item->lokasi }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $item->jumlah }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            <span
                                                class="badge py-1 px-4 rounded-full {{ $item->kondisi == 'Baik' ? 'bg-green-500 text-white' : ($item->kondisi == 'Rusak Ringan' ? 'bg-yellow-500 text-white' : 'bg-red-500 text-white') }}">
                                                {{ $item->kondisi }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $item->tanggal_masuk->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button onclick="openEditModal({{ json_encode($item) }})"
                                                class="text-indigo-400 hover:text-indigo-600 mr-3">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button
                                                onclick="confirmDelete('{{ route('staff.databarang.destroy', $item->id) }}', '{{ $item->nama_barang }}')"
                                                class="text-red-400 hover:text-red-600">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-gray-300">
                                            Tidak ada data barang
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div
                        class="bg-[#1e293b] px-4 py-3 flex items-center justify-between border-t border-gray-700 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            @if ($items->onFirstPage())
                                <span
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-500 text-sm font-medium rounded-md text-gray-500 bg-[#1e293b]">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $items->previousPageUrl() }}"
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-500 text-sm font-medium rounded-md text-gray-300 bg-[#1e293b] hover:bg-gray-700 transition-colors">
                                    Previous
                                </a>
                            @endif

                            @if ($items->hasMorePages())
                                <a href="{{ $items->nextPageUrl() }}"
                                    class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-500 text-sm font-medium rounded-md text-gray-300 bg-[#1e293b] hover:bg-gray-700 transition-colors">
                                    Next
                                </a>
                            @else
                                <span
                                    class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-500 text-sm font-medium rounded-md text-gray-500 bg-[#1e293b]">
                                    Next
                                </span>
                            @endif
                        </div>
                        <div class="hidden sm:flex sm:items-center sm:justify-between w-full">
                            <div>
                                <p class="text-sm text-gray-300">
                                    Showing <span class="font-medium">{{ $items->firstItem() }}</span> to <span
                                        class="font-medium">{{ $items->lastItem() }}</span> of <span
                                        class="font-medium">{{ $items->total() }}</span> results
                                </p>
                            </div>
                            <div class="overflow-x-auto max-w-[300px]">
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px flex-nowrap"
                                    aria-label="Pagination">
                                    @if ($items->onFirstPage())
                                        <span
                                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-500 bg-[#1e293b] text-sm font-medium text-gray-500">
                                            <span class="sr-only">Previous</span>
                                            <i class="fas fa-chevron-left"></i>
                                        </span>
                                    @else
                                        <a href="{{ $items->previousPageUrl() }}"
                                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-500 bg-[#1e293b] text-sm font-medium text-gray-300 hover:bg-gray-700 transition-colors">
                                            <span class="sr-only">Previous</span>
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    @endif

                                    @php
                                        $currentPage = $items->currentPage();
                                        $lastPage = $items->lastPage();
                                        $window = 5;
                                        $halfWindow = floor($window / 2);
                                        $startPage = max(1, $currentPage - $halfWindow);
                                        $endPage = min($lastPage, $startPage + $window - 1);

                                        if ($endPage - $startPage + 1 < $window) {
                                            $startPage = max(1, $endPage - $window + 1);
                                        }
                                    @endphp

                                    @foreach (range($startPage, $endPage) as $page)
                                        @if ($page == $items->currentPage())
                                            <a href="{{ $items->url($page) }}" aria-current="page"
                                                class="z-10 bg-indigo-900 border-indigo-500 text-indigo-400 relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap">
                                                {{ $page }}
                                            </a>
                                        @else
                                            <a href="{{ $items->url($page) }}"
                                                class="bg-[#1e293b] border-gray-500 text-gray-300 hover:bg-gray-700 relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors whitespace-nowrap">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach

                                    @if ($items->hasMorePages())
                                        <a href="{{ $items->nextPageUrl() }}"
                                            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-500 bg-[#1e293b] text-sm font-medium text-gray-300 hover:bg-gray-700 transition-colors">
                                            <span class="sr-only">Next</span>
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    @else
                                        <span
                                            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-500 bg-[#1e293b] text-sm font-medium text-gray-500">
                                            <span class="sr-only">Next</span>
                                            <i class="fas fa-chevron-right"></i>
                                        </span>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Add Item Modal -->
        <div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true"></span>
                <div
                    class="modal inline-block align-bottom rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form id="addForm" action="{{ route('staff.databarang.store') }}" method="POST">
                        @csrf
                        <div class="modal px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-100 mb-4">
                                        Tambah Barang Baru
                                    </h3>
                                    <div class="mt-2 space-y-4">
                                        <div>
                                            <label for="nama_barang" class="block text-sm font-medium text-gray-400">
                                                Nama Barang
                                            </label>
                                            <input type="text" name="nama_barang" id="nama_barang" required
                                                class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none">
                                        </div>
                                        <div>
                                            <label for="kategori" class="block text-sm font-medium text-gray-400">
                                                Kategori
                                            </label>
                                            <select name="kategori" id="kategori" required
                                                class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none">
                                                <option value="">Pilih Kategori</option>
                                                @foreach ($kategoriOptions as $kategori)
                                                    <option value="{{ $kategori }}">{{ $kategori }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="lokasi" class="block text-sm font-medium text-gray-400">
                                                Lokasi Penyimpanan
                                            </label>
                                            <select name="lokasi" id="lokasi" required
                                                class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none">
                                                <option value="">Pilih Lokasi</option>
                                                @foreach ($lokasiOptions as $lokasi)
                                                    <option value="{{ $lokasi }}">{{ $lokasi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="jumlah" class="block text-sm font-medium text-gray-400">
                                                    Jumlah
                                                </label>
                                                <input type="number" name="jumlah" id="jumlah" min="1"
                                                    required
                                                    class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none">
                                            </div>
                                            <div>
                                                <label for="kondisi" class="block text-sm font-medium text-gray-400">
                                                    Kondisi
                                                </label>
                                                <select name="kondisi" id="kondisi" required
                                                    class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none">
                                                    <option value="Baik">Baik</option>
                                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                                    <option value="Rusak Berat">Rusak Berat</option>
                                                    <option value="Hilang">Hilang</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="tanggal_masuk"
                                                class="block text-sm font-medium text-gray-400">
                                                Tanggal Masuk
                                            </label>
                                            <input type="date" name="tanggal_masuk" id="tanggal_masuk" required
                                                class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none">
                                        </div>
                                        <div>
                                            <label for="catatan" class="block text-sm font-medium text-gray-400">
                                                Catatan
                                            </label>
                                            <textarea name="catatan" id="catatan" rows="3"
                                                class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-[#1e293b] px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Simpan
                            </button>
                            <button type="button" onclick="closeAddModal()"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-500 shadow-sm px-4 py-2 bg-[#1e293b] text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Item Modal -->
        <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true"></span>
                <div
                    class="modal inline-block align-bottom rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form id="editForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-100 mb-4">
                                        Edit Data Barang
                                    </h3>
                                    <div class="mt-2 space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-400">
                                                Kode Barang
                                            </label>
                                            <div id="editKodeBarang"
                                                class="mt-1 block w-full border border-gray-500 rounded-md shadow-sm py-2 px-3 bg-[#131924] text-gray-300">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="edit_nama_barang"
                                                class="block text-sm font-medium text-gray-400">
                                                Nama Barang
                                            </label>
                                            <input type="text" name="nama_barang" id="edit_nama_barang" required
                                                class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none">
                                        </div>
                                        <div>
                                            <label for="edit_kategori"
                                                class="block text-sm font-medium text-gray-400">
                                                Kategori
                                            </label>
                                            <select name="kategori" id="edit_kategori" required
                                                class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none">
                                                <option value="">Pilih Kategori</option>
                                                @foreach ($kategoriOptions as $kategori)
                                                    <option value="{{ $kategori }}">{{ $kategori }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="edit_lokasi" class="block text-sm font-medium text-gray-400">
                                                Lokasi Penyimpanan
                                            </label>
                                            <select name="lokasi" id="edit_lokasi" required
                                                class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none">
                                                <option value="">Pilih Lokasi</option>
                                                @foreach ($lokasiOptions as $lokasi)
                                                    <option value="{{ $lokasi }}">{{ $lokasi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="edit_jumlah"
                                                    class="block text-sm font-medium text-gray-400">
                                                    Jumlah
                                                </label>
                                                <input type="number" name="jumlah" id="edit_jumlah" min="1"
                                                    required
                                                    class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none">
                                            </div>
                                            <div>
                                                <label for="edit_kondisi"
                                                    class="block text-sm font-medium text-gray-400">
                                                    Kondisi
                                                </label>
                                                <select name="kondisi" id="edit_kondisi" required
                                                    class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none">
                                                    <option value="Baik">Baik</option>
                                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                                    <option value="Rusak Berat">Rusak Berat</option>
                                                    <option value="Hilang">Hilang</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="edit_tanggal_masuk"
                                                class="block text-sm font-medium text-gray-400">
                                                Tanggal Masuk
                                            </label>
                                            <input type="date" name="tanggal_masuk" id="edit_tanggal_masuk"
                                                required
                                                class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none">
                                        </div>
                                        <div>
                                            <label for="edit_catatan" class="block text-sm font-medium text-gray-400">
                                                Catatan
                                            </label>
                                            <textarea name="catatan" id="edit_catatan" rows="3"
                                                class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-[#1e293b] px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Simpan Perubahan
                            </button>
                            <button type="button" onclick="closeEditModal()"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-500 shadow-sm px-4 py-2 bg-[#1e293b] text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function openEditModal(item) {
            document.getElementById('editForm').action = `/staff/databarang/${item.id}`;
            document.getElementById('editKodeBarang').textContent = item.kode_barang;
            document.getElementById('edit_nama_barang').value = item.nama_barang;
            document.getElementById('edit_kategori').value = item.kategori;
            document.getElementById('edit_lokasi').value = item.lokasi;
            document.getElementById('edit_jumlah').value = item.jumlah;
            document.getElementById('edit_kondisi').value = item.kondisi;
            document.getElementById('edit_tanggal_masuk').value = item.tanggal_masuk.split('T')[0];
            document.getElementById('edit_catatan').value = item.catatan || '';

            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Delete confirmation
        function confirmDelete(url, itemName) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Anda akan menghapus barang ${itemName}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

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

        // Mobile sidebar toggle
        document.getElementById('mobileToggleSidebar').addEventListener('click', function() {
            toggleSidebarState();
        });

        // Notification functions
        function hideNotification(id) {
            const notification = document.getElementById(id);
            if (notification) {
                notification.classList.remove('animate-slide-in');
                notification.classList.add('animate-slide-out');
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }
        }

        // Auto-hide notifications after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successNotification = document.getElementById('successNotification');
            const errorNotification = document.getElementById('errorNotification');

            const autoHide = (notification) => {
                if (notification) {
                    setTimeout(() => {
                        hideNotification(notification.id);
                    }, 5000);
                }
            };

            autoHide(successNotification);
            autoHide(errorNotification);
        });
    </script>
</body>

</html>
