<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman & Pengembalian - Inventory System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('logoyayasan.png') }}" type="image/png">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        .header-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .card-hover {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .search-input {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
        }

        .search-input:focus {
            border-color: #6366f1;
        }

        .badge {
            @apply px-2 py-1 text-xs font-semibold rounded-full;
        }

        .table-row-hover:hover {
            background-color: #32465a;
        }

        .modern-select {
            @apply border-gray-200 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500;
        }

        /* Improved Sidebar styles */
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
            background-color: rgba(99, 102, 241, 0.3);
            color: white;
        }

        .nav-item.active {
            background-color: rgba(99, 102, 241, 0.5);
            color: white;
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

        .pagination .page-item.active .page-link {
            background-color: #6366f1;
            border-color: #6366f1;
            color: white;
        }

        .pagination .page-link {
            color: #6366f1;
        }

        .pagination .page-item.disabled .page-link {
            color: #6b7280;
        }

        /* Additional styles for peminjaman page */
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

        .tab {
            border-bottom-width: 2px;
            padding-bottom: 0.75rem;
            transition: all 0.3s ease;
        }

        .tab-active {
            border-color: #6366f1;
            color: #6366f1;
        }

        .form-card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .form-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .table-container:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

        .modal-overlay {
            transition: opacity 0.3s ease;
        }

        .modal-content {
            transition: opacity 0.3s ease, transform 0.3s ease;
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
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
            color: #065f46;
        }

        .notification-error {
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
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
            color: inherit;
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

        /* Success Modal Animation */
        .animate__fadeInRight {
            animation: fadeInRight 0.5s ease-out;
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
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

        @if ($errors->any())
            <div id="errorNotification" class="notification notification-error animate-slide-in">
                <div class="notification-content">
                    <i class="fas fa-exclamation-circle notification-icon"></i>
                    <span>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </span>
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

                    {{-- <button id="mobileToggleSidebar"
                        class="text-gray-500 hover:text-gray-700 mr-4 focus:outline-none lg:hidden transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button> --}}
                    <h1 class="text-2xl font-bold text-white animate__animated animate__fadeIn">Peminjaman &
                        Pengembalian</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..."
                            class="search-input pl-10 pr-4 py-2 border border-gray-500 focus:outline-none focus:border-indigo-500 w-64 bg-[#131924] text-white">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6 animate__animated animate__fadeIn animate__faster">
                <!-- Tabs -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex space-x-8">
                        <button id="peminjamanTab"
                            class="tab {{ request('active_tab', 'peminjaman') == 'peminjaman' ? 'tab-active' : 'border-transparent text-gray-200 hover:text-gray-300 hover:border-gray-300' }} py-4 px-1 text-sm font-medium">Peminjaman</button>
                        <button id="pengembalianTab"
                            class="tab {{ request('active_tab') == 'pengembalian' ? 'tab-active' : 'border-transparent text-gray-200 hover:text-gray-300 hover:border-gray-300' }} py-4 px-1 text-sm font-medium">Pengembalian</button>
                    </nav>
                </div>

                <!-- Peminjaman Section -->
                <div id="peminjamanSection" class="animate__animated">
                    <!-- Form Peminjaman -->
                    <div
                        class="bg-gradient-to-tl from-sky-950 to-[#131924] form-card p-6 mb-6 transition-all duration-300">
                        <h2 class="text-lg font-medium text-white mb-4">Formulir Peminjaman Barang</h2>
                        <form id="peminjamanForm" action="{{ route('staff.peminjaman.store') }}" method="POST"
                            class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="item_id" class="block text-sm font-medium text-gray-300">Pilih
                                        Barang</label>
                                    <select id="item_id" name="item_id" required
                                        class="text-white modern-select mt-1 block w-full border border-gray-500 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924]">
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->kode_barang }} - {{ $item->nama_barang }} (Tersedia:
                                                {{ $item->jumlah }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="person_id"
                                        class="block text-sm font-medium text-gray-300">Peminjam</label>
                                    <select id="person_id" name="person_id" required
                                        class="text-white modern-select mt-1 block w-full border border-gray-500 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924]">
                                        <option value="">-- Pilih Peminjam --</option>
                                        @foreach ($people as $person)
                                            <option value="{{ $person->id }}"
                                                {{ old('person_id') == $person->id ? 'selected' : '' }}>
                                                {{ $person->nama }} ({{ $person->kode_orang }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="tanggal_pinjam"
                                        class="block text-sm font-medium text-gray-300">Tanggal Pinjam</label>
                                    <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" required
                                        value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                                        class="mt-1 block w-full border border-gray-500 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924] text-white">
                                </div>
                                <div>
                                    <label for="tanggal_kembali"
                                        class="block text-sm font-medium text-gray-300">Tanggal Kembali
                                        (Perkiraan)</label>
                                    <input type="date" id="tanggal_kembali" name="tanggal_kembali" required
                                        value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}"
                                        class="mt-1 block w-full border border-gray-500 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924] text-white">
                                </div>
                            </div>

                            <div>
                                <label for="catatan"
                                    class="block text-sm font-medium text-gray-300">Keterangan</label>
                                <textarea id="catatan" name="catatan" rows="2"
                                    class="mt-1 block w-full border border-gray-500 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924] text-white">{{ old('catatan') }}</textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors btn-scale">
                                    <i class="fas fa-save"></i>
                                    <span>Simpan Peminjaman</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tabel Riwayat Peminjaman -->
                    <div
                        class="bg-gradient-to-tl from-sky-950 to-[#131924] table-container transition-all duration-300">
                        <div class="p-4 border-b border-gray-500 flex justify-between items-center">
                            <h2 class="text-lg font-medium text-white">Riwayat Peminjaman</h2>
                            <form method="GET" action="{{ route('staff.peminjaman.index') }}" class="relative">
                                <input type="text" name="search_peminjaman" placeholder="Cari riwayat..."
                                    value="{{ request('search_peminjaman') }}"
                                    class="search-input pl-10 pr-4 py-2 border border-gray-500 focus:outline-none focus:border-indigo-500 w-64 bg-inherit text-white">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                @if (request('search_peminjaman'))
                                    <a href="{{ route('staff.peminjaman.index') }}"
                                        class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </form>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-[#131924]">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Kode Barang</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Nama Barang</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Peminjam</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Tanggal Pinjam</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Tanggal Kembali</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($borrowings as $borrowing)
                                        <tr class="table-row-hover animate__animated animate__fadeIn">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-300">
                                                {{ $borrowing->item->kode_barang }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ $borrowing->item->nama_barang }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ $borrowing->person->nama }} ({{ $borrowing->person->kode_orang }})
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ \Carbon\Carbon::parse($borrowing->tanggal_kembali)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                @if ($borrowing->status == 'Dipinjam')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 badge">Belum
                                                        Kembali</span>
                                                @else
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 badge">Sudah
                                                        Kembali</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                @if ($borrowing->status == 'Dipinjam' && in_array(strtolower(Auth::user()->role), ['admin', 'petugas']))
                                                    <button
                                                        class="text-indigo-400 hover:text-indigo-500 mr-3 transition-colors btn-scale return-btn"
                                                        data-id="{{ $borrowing->id }}"
                                                        data-code="{{ $borrowing->item->kode_barang }}"
                                                        data-name="{{ $borrowing->item->nama_barang }}"
                                                        data-borrower="{{ $borrowing->person->nama }} ({{ $borrowing->person->kode_orang }})"
                                                        data-borrow-date="{{ \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y') }}">
                                                        <i class="fas fa-check-circle"></i> Kembalikan
                                                    </button>
                                                @else
                                                    <button
                                                        class="text-gray-400 cursor-not-allowed mr-3 transition-colors"
                                                        disabled>
                                                        <i class="fas fa-check-circle"></i> Kembalikan
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div
                            class="bg-[#1e293b] px-4 py-3 flex items-center justify-between border-t border-gray-700 sm:px-6">
                            <div class="flex-1 flex justify-between sm:hidden">
                                @if ($borrowings->onFirstPage())
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-500 text-sm font-medium rounded-md text-gray-500 bg-[#1e293b]">
                                        Previous
                                    </span>
                                @else
                                    <a href="{{ $borrowings->previousPageUrl() }}"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-500 text-sm font-medium rounded-md text-gray-300 bg-[#1e293b] hover:bg-gray-700 transition-colors">
                                        Previous
                                    </a>
                                @endif

                                @if ($borrowings->hasMorePages())
                                    <a href="{{ $borrowings->nextPageUrl() }}"
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
                                        Showing <span class="font-medium">{{ $borrowings->firstItem() }}</span> to
                                        <span class="font-medium">{{ $borrowings->lastItem() }}</span> of
                                        <span class="font-medium">{{ $borrowings->total() }}</span> results
                                    </p>
                                </div>
                                <div class="overflow-x-auto max-w-[300px]">
                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px flex-nowrap"
                                        aria-label="Pagination">
                                        @if ($borrowings->onFirstPage())
                                            <span
                                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-500 bg-[#1e293b] text-sm font-medium text-gray-500">
                                                <span class="sr-only">Previous</span>
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        @else
                                            <a href="{{ $borrowings->previousPageUrl() }}"
                                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-500 bg-[#1e293b] text-sm font-medium text-gray-300 hover:bg-gray-700 transition-colors">
                                                <span class="sr-only">Previous</span>
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        @endif

                                        @php
                                            $currentPage = $borrowings->currentPage();
                                            $lastPage = $borrowings->lastPage();
                                            $window = 5;
                                            $halfWindow = floor($window / 2);
                                            $startPage = max(1, $currentPage - $halfWindow);
                                            $endPage = min($lastPage, $startPage + $window - 1);

                                            if ($endPage - $startPage + 1 < $window) {
                                                $startPage = max(1, $endPage - $window + 1);
                                            }
                                        @endphp

                                        @foreach (range($startPage, $endPage) as $page)
                                            @if ($page == $borrowings->currentPage())
                                                <a href="{{ $borrowings->url($page) }}" aria-current="page"
                                                    class="z-10 bg-indigo-900 border-indigo-500 text-indigo-400 relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap">
                                                    {{ $page }}
                                                </a>
                                            @else
                                                <a href="{{ $borrowings->url($page) }}"
                                                    class="bg-[#1e293b] border-gray-500 text-gray-300 hover:bg-gray-700 relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors whitespace-nowrap">
                                                    {{ $page }}
                                                </a>
                                            @endif
                                        @endforeach

                                        @if ($borrowings->hasMorePages())
                                            <a href="{{ $borrowings->nextPageUrl() }}"
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
                </div>

                <!-- Pengembalian Section -->
                <div id="pengembalianSection" class="animate__animated hidden">
                    <!-- Tabel Riwayat Pengembalian -->
                    <div
                        class="bg-gradient-to-tl from-sky-950 to-[#131924] table-container transition-all duration-300">
                        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-lg font-medium text-white">Riwayat Pengembalian</h2>
                            <form method="GET" action="{{ route('staff.peminjaman.index') }}" class="relative">
                                <input type="text" name="search_pengembalian" placeholder="Cari riwayat..."
                                    value="{{ request('search_pengembalian') }}"
                                    class="search-input pl-10 pr-4 py-2 border border-gray-500 focus:outline-none focus:border-indigo-500 w-64 bg-inherit text-white">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                @if (request('search_pengembalian'))
                                    <a href="{{ route('staff.peminjaman.index') }}"
                                        class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </form>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-[#131924]">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Kode Peminjaman</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Nama Barang</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Peminjam</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Tanggal Pinjam</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Tanggal Kembali</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Kondisi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-inherit divide-y divide-gray-200">
                                    @foreach ($returnedBorrowings as $borrowing)
                                        <tr class="table-row-hover animate__animated animate__fadeIn">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-300">
                                                {{ $borrowing->kode_peminjaman }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ $borrowing->item->nama_barang }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ $borrowing->person->nama }} ({{ $borrowing->person->kode_orang }})
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ \Carbon\Carbon::parse($borrowing->tanggal_dikembalikan)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                @if ($borrowing->kondisi_kembali == 'Baik')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500 text-white badge">Baik</span>
                                                @elseif($borrowing->kondisi_kembali == 'Rusak Ringan')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500 text-white badge">Rusak
                                                        Ringan</span>
                                                @else
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500 text-white badge">Rusak
                                                        Berat</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div
                            class="bg-[#1e293b] px-4 py-3 flex items-center justify-between border-t border-gray-700 sm:px-6">
                            <div class="flex-1 flex justify-between sm:hidden">
                                @if ($returnedBorrowings->onFirstPage())
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-500 text-sm font-medium rounded-md text-gray-500 bg-[#1e293b]">
                                        Previous
                                    </span>
                                @else
                                    <a href="{{ $returnedBorrowings->previousPageUrl() }}"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-500 text-sm font-medium rounded-md text-gray-300 bg-[#1e293b] hover:bg-gray-700 transition-colors">
                                        Previous
                                    </a>
                                @endif

                                @if ($returnedBorrowings->hasMorePages())
                                    <a href="{{ $returnedBorrowings->nextPageUrl() }}"
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
                                        Showing <span
                                            class="font-medium">{{ $returnedBorrowings->firstItem() }}</span> to
                                        <span class="font-medium">{{ $returnedBorrowings->lastItem() }}</span> of
                                        <span class="font-medium">{{ $returnedBorrowings->total() }}</span> results
                                    </p>
                                </div>
                                <div class="overflow-x-auto max-w-[300px]">
                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px flex-nowrap"
                                        aria-label="Pagination">
                                        @if ($returnedBorrowings->onFirstPage())
                                            <span
                                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-500 bg-[#1e293b] text-sm font-medium text-gray-500">
                                                <span class="sr-only">Previous</span>
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        @else
                                            <a href="{{ $returnedBorrowings->previousPageUrl() }}"
                                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-500 bg-[#1e293b] text-sm font-medium text-gray-300 hover:bg-gray-700 transition-colors">
                                                <span class="sr-only">Previous</span>
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        @endif

                                        @php
                                            $currentPage = $returnedBorrowings->currentPage();
                                            $lastPage = $returnedBorrowings->lastPage();
                                            $window = 5;
                                            $halfWindow = floor($window / 2);
                                            $startPage = max(1, $currentPage - $halfWindow);
                                            $endPage = min($lastPage, $startPage + $window - 1);

                                            if ($endPage - $startPage + 1 < $window) {
                                                $startPage = max(1, $endPage - $window + 1);
                                            }
                                        @endphp

                                        @foreach (range($startPage, $endPage) as $page)
                                            @if ($page == $returnedBorrowings->currentPage())
                                                <a href="{{ $returnedBorrowings->url($page) }}" aria-current="page"
                                                    class="z-10 bg-indigo-900 border-indigo-500 text-indigo-400 relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap">
                                                    {{ $page }}
                                                </a>
                                            @else
                                                <a href="{{ $returnedBorrowings->url($page) }}"
                                                    class="bg-[#1e293b] border-gray-500 text-gray-300 hover:bg-gray-700 relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors whitespace-nowrap">
                                                    {{ $page }}
                                                </a>
                                            @endif
                                        @endforeach

                                        @if ($returnedBorrowings->hasMorePages())
                                            <a href="{{ $returnedBorrowings->nextPageUrl() }}"
                                                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-500 bg-[#1e293b] text-sm font-medium text-gray-300 hover:bg-gray-700">
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
                </div>
            </main>
        </div>

        <!-- Pengembalian Modal -->
        <div id="pengembalianModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity modal-overlay" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true"></span>
                <div id="modalContent"
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-content">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Proses Pengembalian Barang
                                </h3>
                                <div class="mt-2 space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500 mb-2">Anda akan memproses pengembalian barang
                                            berikut:</p>
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-500">Kode Barang:</p>
                                                    <p id="modalKodeBarang" class="text-sm"></p>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-500">Nama Barang:</p>
                                                    <p id="modalNamaBarang" class="text-sm"></p>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-500">Peminjam:</p>
                                                    <p id="modalPeminjam" class="text-sm"></p>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-500">Tanggal Pinjam:</p>
                                                    <p id="modalTanggalPinjam" class="text-sm"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="modalTanggalKembali"
                                            class="block text-sm font-medium text-gray-700">Tanggal
                                            Dikembalikan</label>
                                        <input type="date" id="modalTanggalKembali"
                                            class="modern-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    <div>
                                        <label for="modalKondisiKembali"
                                            class="block text-sm font-medium text-gray-700">Kondisi Saat
                                            Dikembalikan</label>
                                        <select id="modalKondisiKembali"
                                            class="modern-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo- focus:border-indigo-500">
                                            <option value="Baik">Baik</option>
                                            <option value="Rusak Ringan">Rusak Ringan</option>
                                            <option value="Rusak Berat">Rusak Berat</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="modalCatatanKembali"
                                            class="block text-sm font-medium text-gray-700">Catatan</label>
                                        <textarea id="modalCatatanKembali" rows="2"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="confirmReturnBtn"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors btn-scale">
                            Konfirmasi Pengembalian
                        </button>
                        <button type="button" id="cancelReturnBtn"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors btn-scale">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Notification functions
        function showNotification(type, message) {
            const notificationContainer = document.querySelector('.notification-container');
            const notificationId = 'notification-' + Date.now();

            const notification = document.createElement('div');
            notification.id = notificationId;
            notification.className = `notification notification-${type} animate-slide-in`;

            notification.innerHTML = `
                <div class="notification-content">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} notification-icon"></i>
                    <span>${message}</span>
                    <button onclick="hideNotification('${notificationId}')" class="notification-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            notificationContainer.appendChild(notification);

            // Auto-hide after 5 seconds
            setTimeout(() => {
                hideNotification(notificationId);
            }, 5000);
        }

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

        // Auto-hide existing notifications after 5 seconds
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

        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const peminjamanTab = document.getElementById('peminjamanTab');
            const pengembalianTab = document.getElementById('pengembalianTab');
            const peminjamanSection = document.getElementById('peminjamanSection');
            const pengembalianSection = document.getElementById('pengembalianSection');

            // Set initial active tab
            peminjamanTab.classList.add('tab-active');
            peminjamanSection.classList.remove('hidden');
            pengembalianSection.classList.add('hidden');

            // Tab click handlers
            peminjamanTab.addEventListener('click', function() {
                peminjamanTab.classList.add('tab-active');
                peminjamanTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700',
                    'hover:border-gray-300');
                pengembalianTab.classList.remove('tab-active');
                pengembalianTab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700',
                    'hover:border-gray-300');

                pengembalianSection.classList.add('hidden');
                peminjamanSection.classList.remove('hidden');
                peminjamanSection.classList.add('animate__fadeIn');
            });

            pengembalianTab.addEventListener('click', function() {
                pengembalianTab.classList.add('tab-active');
                pengembalianTab.classList.remove('border-transparent', 'text-gray-500',
                    'hover:text-gray-700', 'hover:border-gray-300');
                peminjamanTab.classList.remove('tab-active');
                peminjamanTab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700',
                    'hover:border-gray-300');

                peminjamanSection.classList.add('hidden');
                pengembalianSection.classList.remove('hidden');
                pengembalianSection.classList.add('animate__fadeIn');
            });

            // Return button handlers
            const returnButtons = document.querySelectorAll('.return-btn');
            const pengembalianModal = document.getElementById('pengembalianModal');
            const modalContent = document.getElementById('modalContent');
            const confirmReturnBtn = document.getElementById('confirmReturnBtn');
            const cancelReturnBtn = document.getElementById('cancelReturnBtn');

            returnButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id');
                    const itemCode = this.getAttribute('data-code');
                    const itemName = this.getAttribute('data-name');
                    const borrower = this.getAttribute('data-borrower');
                    const borrowDate = this.getAttribute('data-borrow-date');

                    // Set modal content
                    document.getElementById('modalKodeBarang').textContent = itemCode;
                    document.getElementById('modalNamaBarang').textContent = itemName;
                    document.getElementById('modalPeminjam').textContent = borrower;
                    document.getElementById('modalTanggalPinjam').textContent = borrowDate;

                    // Set today's date as default return date
                    const today = new Date();
                    const formattedDate = today.toISOString().split('T')[0];
                    document.getElementById('modalTanggalKembali').value = formattedDate;

                    // Show modal with animation
                    pengembalianModal.classList.remove('hidden');
                    modalContent.style.opacity = '0';
                    modalContent.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        modalContent.style.opacity = '1';
                        modalContent.style.transform = 'translateY(0)';
                    }, 10);

                    // Set up confirm button with the current item ID
                    confirmReturnBtn.onclick = function() {
                        const tanggalDikembalikan = document.getElementById('modalTanggalKembali').value;
                        const kondisiKembali = document.getElementById('modalKondisiKembali').value;
                        const catatan = document.getElementById('modalCatatanKembali').value;

                        fetch(`/staff/peminjaman/${itemId}/return`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({
                                    tanggal_dikembalikan: tanggalDikembalikan,
                                    kondisi_kembali: kondisiKembali,
                                    catatan: catatan
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    console.error('HTTP Error:', response.status, response.statusText);
                                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    closeModal();
                                    showNotification('success', 'Pengembalian barang berhasil diproses!');
                                    // Refresh the page after 1 second to show updated data
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                } else {
                                    console.error('Server Error:', data.message);
                                    showNotification('error', 'Terjadi kesalahan: ' + data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Fetch Error:', error);
                                showNotification('error', 'Terjadi kesalahan saat memproses pengembalian: ' + error.message);
                            });
                    };
                });
            });

            // Modal close handlers
            cancelReturnBtn.addEventListener('click', closeModal);

            // Close modal when clicking outside
            pengembalianModal.addEventListener('click', function(e) {
                if (e.target === pengembalianModal) {
                    closeModal();
                }
            });

            function closeModal() {
                modalContent.style.opacity = '0';
                modalContent.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    pengembalianModal.classList.add('hidden');
                }, 300);
            }

            // Form submissions
            document.getElementById('peminjamanForm').addEventListener('submit', function(e) {
                // Validasi client-side
                const itemId = document.getElementById('item_id').value;
                const personId = document.getElementById('person_id').value;
                const tanggalPinjam = document.getElementById('tanggal_pinjam').value;
                const tanggalKembali = document.getElementById('tanggal_kembali').value;

                if (!itemId || !personId || !tanggalPinjam || !tanggalKembali) {
                    e.preventDefault();
                    showNotification('error', 'Harap lengkapi semua field yang wajib diisi!');
                    return;
                }
            });

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

            // Set today's date as default for borrowing form
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0];
            document.getElementById('tanggal_pinjam').value = formattedDate;

            // Set return date to 7 days from today
            const nextWeek = new Date();
            nextWeek.setDate(today.getDate() + 7);
            const formattedNextWeek = nextWeek.toISOString().split('T')[0];
            document.getElementById('tanggal_kembali').value = formattedNextWeek;
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
                toggleIcon.className = 'fas fa-chevron-right';
            } else {
                sidebar.classList.remove("collapsed");
                sidebar.classList.add("expanded");
                toggleIcon.className = 'fas fa-chevron-left';
            }
        });
    </script>
</body>

</html>