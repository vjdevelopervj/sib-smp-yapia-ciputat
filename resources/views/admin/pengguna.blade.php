<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - Inventory System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('logoyayasan.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Updated styles to match dashboard */
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
            background-color: #131924;
            border: 1px solid #374151;
            color: white;
        }

        .search-input:focus {
            border-color: #6366f1;
            outline: none;
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
            background: linear-gradient(to bottom, #131924, #0f172a);
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .table-container:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        }

        .table-row-hover:hover {
            background-color: #1e293b;
        }

        .badge {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
        }

        .badge-admin {
            background-color: rgba(79, 70, 229, 0.2);
            color: #a5b4fc;
        }

        .badge-petugas {
            background-color: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }

        .badge-active {
            background-color: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }

        .badge-inactive {
            background-color: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        .modern-select {
            border-radius: 0.375rem;
            transition: all 0.3s ease;
            background-color: #131924;
            border: 1px solid #374151;
            color: white;
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

        /* Sidebar styles */
        .sidebar {
            transition: all 0.3s ease;
            width: 250px;
            display: flex;
            flex-direction: column;
            background-color: #131924;
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
            color: white;
        }

        .nav-item.active {
            background-color: #143a6b;
            color: white;
            font-weight: 500;
        }

        .nav-item i {
            width: 24px;
            text-align: center;
            margin-right: 12px;
            font-size: 1.1rem;
            color: white;
        }

        .nav-text {
            transition: opacity 0.3s ease, width 0.3s ease;
            white-space: nowrap;
            color: white;
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
            background-color: #8b5cf6;
            color: white;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #7c3aed;
        }

        .logout-btn i {
            margin-right: 0.75rem;
        }

        .toggle-btn {
            transition: all 0.3s ease;
        }

        .logo-text {
            transition: opacity 0.3s ease, width 0.3s ease;
            color: white;
        }

        .sidebar.collapsed .logo-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .glow-effect:hover {
            box-shadow: 0 0 10px rgba(165, 180, 252, 0.5);
        }

        .glow-effect.active {
            box-shadow: 0 0 15px rgba(165, 180, 252, 0.7);
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

        /* Dark mode table styles */
        .table-dark {
            background-color: #131924;
            color: #e5e7eb;
        }

        .table-dark thead {
            background-color: #1e293b;
            color: #f3f4f6;
        }

        .table-dark tbody tr {
            border-bottom: 1px solid #1e293b;
        }

        .table-dark tbody tr:hover {
            background-color: #1e293b;
        }

        /* Modal styles */
        .modal-dark {
            background-color: #1e293b;
            color: #e5e7eb;
        }

        .modal-dark .modal-header {
            border-bottom: 1px solid #334155;
        }

        .modal-dark .modal-footer {
            border-top: 1px solid #334155;
            background-color: #1e293b;
        }

        .modal-dark .form-control {
            background-color: #1e293b;
            border-color: #334155;
            color: #e5e7eb;
        }

        .modal-dark .form-control:focus {
            background-color: #1e293b;
            border-color: #6366f1;
            color: #e5e7eb;
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
        <!-- Sidebar yang sudah diperbaiki -->
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
                    <!-- Di bagian sidebar -->
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
                                    Data Orang
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
                                class="nav-item {{ request()->is('admin/pengguna') ? 'active' : '' }}">
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
                        class="text-indigo-200 hover:text-white focus:outline-none toggle-btn collapsed transition-colors mr-5"
                        onclick="toggleSidebarState()">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <h1 class="text-2xl font-bold text-white animate__animated animate__fadeIn">
                        Manajemen Pengguna
                    </h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..."
                            class="search-input pl-10 pr-10 py-2 border border-gray-500 focus:outline-none focus:border-indigo-500 w-64"
                            id="searchInput">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        <button id="clearSearch"
                            class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 hidden">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6 animate__animated animate__fadeIn animate__faster">
                <!-- Loading State (hidden by default) -->
                <div id="loadingIndicator" class="flex justify-center items-center p-4 hidden">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
                </div>

                <!-- Error State (hidden by default) -->
                <div id="errorAlert"
                    class="bg-red-900 border border-red-700 text-red-100 px-4 py-3 rounded relative mb-4 hidden"
                    role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline" id="errorMessage"></span>
                    <button onclick="hideError()" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Action Bar -->
                <div class="flex justify-between items-center mb-6">
                    <button id="addUserBtn"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors duration-300">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Pengguna</span>
                    </button>

                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-300">Items per page:</span>
                        <select id="itemsPerPageSelect"
                            class="modern-select border border-gray-600 px-3 py-1 text-sm focus:outline-none text-white">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="bg-gradient-to-tl from-sky-950 to-[#131924] rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-[#1e293b]">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Nama Lengkap
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Username
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody" class="bg-[#131924] divide-y divide-gray-800">
                                <!-- Users will be loaded here dynamically -->
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-400">
                                        Memuat data...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="bg-[#131924] px-4 py-3 flex items-center justify-between border-t border-gray-700 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <button id="prevPageMobile"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-600 text-sm font-medium rounded-md text-gray-300 bg-[#1e293b] hover:bg-gray-800 disabled:opacity-50">
                                Previous
                            </button>
                            <button id="nextPageMobile"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-600 text-sm font-medium rounded-md text-gray-300 bg-[#1e293b] hover:bg-gray-800 disabled:opacity-50">
                                Next
                            </button>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-300" id="paginationInfo">
                                    Memuat data...
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                    aria-label="Pagination">
                                    <button id="prevPage"
                                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-600 bg-[#1e293b] text-sm font-medium text-gray-300 hover:bg-gray-800 disabled:opacity-50">
                                        <span class="sr-only">Previous</span>
                                        <i class="fas fa-chevron-left"></i>
                                    </button>

                                    <span
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-600 bg-[#1e293b] text-sm font-medium text-gray-300"
                                        id="currentPage">
                                        1
                                    </span>

                                    <button id="nextPage"
                                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-600 bg-[#1e293b] text-sm font-medium text-gray-300 hover:bg-gray-800 disabled:opacity-50">
                                        <span class="sr-only">Next</span>
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Add/Edit User Modal -->
        <div id="userModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-[#1e293b] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-[#1e293b] px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-white mb-4" id="userModalTitle">
                                    Tambah Pengguna Baru
                                </h3>
                                <form id="userForm">
                                    <div class="mt-2 space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="userFirstName"
                                                    class="block text-sm font-medium text-gray-300">
                                                    Nama Depan
                                                </label>
                                                <input type="text" id="userFirstName" name="first_name"
                                                    class="mt-1 block w-full border border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924] text-white"
                                                    required />
                                            </div>
                                            <div>
                                                <label for="userLastName"
                                                    class="block text-sm font-medium text-gray-300">
                                                    Nama Belakang
                                                </label>
                                                <input type="text" id="userLastName" name="last_name"
                                                    class="mt-1 block w-full border border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924] text-white" />
                                            </div>
                                        </div>
                                        <div>
                                            <label for="userEmail" class="block text-sm font-medium text-gray-300">
                                                Email
                                            </label>
                                            <input type="email" id="userEmail" name="email"
                                                class="mt-1 block w-full border border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924] text-white"
                                                required />
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="userUsername"
                                                    class="block text-sm font-medium text-gray-300">
                                                    Username
                                                </label>
                                                <input type="text" id="userUsername" name="username"
                                                    class="mt-1 block w-full border border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924] text-white"
                                                    required />
                                            </div>
                                            <div>
                                                <label for="userRole" class="block text-sm font-medium text-gray-300">
                                                    Role
                                                </label>
                                                <select id="userRole" name="role"
                                                    class="mt-1 block w-full border border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924] text-white">
                                                    <option value="petugas">Petugas</option>
                                                    <option value="admin">Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="passwordFields">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="userPassword"
                                                        class="block text-sm font-medium text-gray-300">
                                                        Password
                                                        <button type="button" id="generatePasswordBtn"
                                                            class="ml-2 text-xs text-indigo-400 hover:text-indigo-300">
                                                            Generate
                                                        </button>
                                                    </label>
                                                    <input type="password" id="userPassword" name="password"
                                                        class="mt-1 block w-full border border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924] text-white"
                                                        required />
                                                </div>
                                                <div>
                                                    <label for="userConfirmPassword"
                                                        class="block text-sm font-medium text-gray-300">
                                                        Konfirmasi Password
                                                    </label>
                                                    <input type="password" id="userConfirmPassword"
                                                        name="password_confirmation"
                                                        class="mt-1 block w-full border border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924] text-white"
                                                        required />
                                                </div>
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                Password minimal 8 karakter, mengandung huruf besar, huruf kecil, dan
                                                angka.
                                            </div>
                                        </div>
                                        <div>
                                            <label for="userStatus" class="block text-sm font-medium text-gray-300">
                                                Status
                                            </label>
                                            <select id="userStatus" name="status"
                                                class="mt-1 block w-full border border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924] text-white">
                                                <option value="active">Aktif</option>
                                                <option value="inactive">Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="bg-[#131924] px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse mt-4">
                                        <button type="submit"
                                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                            Simpan
                                        </button>
                                        <button type="button" id="cancelUserModal"
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-[#1e293b] text-base font-medium text-gray-300 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Password Modal -->
        <div id="changePasswordModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-[#1e293b] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                    <div class="bg-[#1e293b] px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-900 sm:mx-0 sm:h-10 sm:w-10 shadow-inner">
                                <i class="fas fa-key text-blue-400"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-white">
                                    Ganti Password
                                </h3>
                                <div class="mt-4">
                                    <p class="text-sm text-gray-300 mb-4" id="changePasswordUserInfo">
                                        <!-- User info will be inserted here -->
                                    </p>

                                    <div id="changePasswordError"
                                        class="mb-4 p-3 rounded-md bg-red-900 text-red-100 hidden">
                                        <!-- Error message will be inserted here -->
                                    </div>

                                    <form id="changePasswordForm">
                                        <div class="space-y-4">
                                            <div>
                                                <label for="currentPassword"
                                                    class="block text-sm font-medium text-gray-300">
                                                    Password Saat Ini
                                                </label>
                                                <input type="password" id="currentPassword" name="current_password"
                                                    class="mt-1 block w-full border border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924] text-white"
                                                    required />
                                            </div>
                                            <div>
                                                <label for="newPassword"
                                                    class="block text-sm font-medium text-gray-300">
                                                    Password Baru
                                                </label>
                                                <input type="password" id="newPassword" name="new_password"
                                                    class="mt-1 block w-full border border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924] text-white"
                                                    required />
                                            </div>
                                            <div>
                                                <label for="confirmNewPassword"
                                                    class="block text-sm font-medium text-gray-300">
                                                    Konfirmasi Password Baru
                                                </label>
                                                <input type="password" id="confirmNewPassword"
                                                    name="new_password_confirmation"
                                                    class="mt-1 block w-full border border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#131924] text-white"
                                                    required />
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                Password minimal 8 karakter, mengandung huruf besar, huruf kecil, dan
                                                angka.
                                            </div>
                                        </div>
                                        <div class="bg-[#131924] px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse mt-4">
                                            <button type="submit"
                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors"
                                                id="changePasswordSubmitBtn">
                                                Ganti Password
                                            </button>
                                            <button type="button" id="cancelChangePasswordModal"
                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-[#1e293b] text-base font-medium text-gray-300 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                                Batal
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete User Confirmation Modal -->
        <div id="deleteUserModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-[#1e293b] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-[#1e293b] px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-900 sm:mx-0 sm:h-10 sm:w-10 shadow-inner">
                                <i class="fas fa-exclamation-triangle text-red-400"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-white">
                                    Hapus Data Pengguna
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-300" id="deleteUserInfo">
                                        <!-- User info will be inserted here -->
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#131924] px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="confirmDeleteUser"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Hapus
                        </button>
                        <button type="button" id="cancelDeleteUserModal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-[#1e293b] text-base font-medium text-gray-300 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentPage = 1;
        let itemsPerPage = 10;
        let totalUsers = 0;
        let searchQuery = "";
        let selectedUser = null;
        let isEditMode = false;
        let users = [];
        let searchTimeout;

        // DOM elements
        const loadingIndicator = document.getElementById('loadingIndicator');
        const errorAlert = document.getElementById('errorAlert');
        const errorMessage = document.getElementById('errorMessage');
        const searchInput = document.getElementById('searchInput');
        const clearSearchBtn = document.getElementById('clearSearch');
        const itemsPerPageSelect = document.getElementById('itemsPerPageSelect');
        const usersTableBody = document.getElementById('usersTableBody');
        const paginationInfo = document.getElementById('paginationInfo');
        const currentPageSpan = document.getElementById('currentPage');
        const prevPageBtn = document.getElementById('prevPage');
        const nextPageBtn = document.getElementById('nextPage');
        const prevPageMobileBtn = document.getElementById('prevPageMobile');
        const nextPageMobileBtn = document.getElementById('nextPageMobile');

        // Modal elements
        const userModal = document.getElementById('userModal');
        const userModalTitle = document.getElementById('userModalTitle');
        const userForm = document.getElementById('userForm');
        const passwordFields = document.getElementById('passwordFields');
        const generatePasswordBtn = document.getElementById('generatePasswordBtn');
        const cancelUserModalBtn = document.getElementById('cancelUserModal');

        const changePasswordModal = document.getElementById('changePasswordModal');
        const changePasswordUserInfo = document.getElementById('changePasswordUserInfo');
        const changePasswordError = document.getElementById('changePasswordError');
        const changePasswordForm = document.getElementById('changePasswordForm');
        const cancelChangePasswordModalBtn = document.getElementById('cancelChangePasswordModal');
        const changePasswordSubmitBtn = document.getElementById('changePasswordSubmitBtn');

        const deleteUserModal = document.getElementById('deleteUserModal');
        const deleteUserInfo = document.getElementById('deleteUserInfo');
        const confirmDeleteUserBtn = document.getElementById('confirmDeleteUser');
        const cancelDeleteUserModalBtn = document.getElementById('cancelDeleteUserModal');

        // API Base URL
        const API_BASE_URL = window.location.origin;

        // Helper functions
        function showLoading() {
            loadingIndicator.classList.remove('hidden');
        }

        function hideLoading() {
            loadingIndicator.classList.add('hidden');
        }

        function showError(message) {
            errorMessage.innerHTML = message;
            errorAlert.classList.remove('hidden');
        }

        function hideError() {
            errorAlert.classList.add('hidden');
        }

        function showChangePasswordError(message) {
            changePasswordError.textContent = message;
            changePasswordError.classList.remove('hidden');
        }

        function hideChangePasswordError() {
            changePasswordError.classList.add('hidden');
        }

        function formatUser(user) {
            return {
                id: user.id,
                firstName: user.first_name || '',
                lastName: user.last_name || '',
                name: `${user.first_name || ''} ${user.last_name || ''}`.trim(),
                email: user.email || '',
                username: user.username || '',
                role: user.role || 'petugas',
                status: user.status || 'active',
                avatarColor: user.role === 'admin' ? 'indigo' : 'green'
            };
        }

        function generateRandomPassword() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
            let password = '';
            for (let i = 0; i < 12; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return password;
        }

        function validatePassword(password) {
            const minLength = 8;
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumbers = /\d/.test(password);

            return password.length >= minLength && hasUpperCase && hasLowerCase && hasNumbers;
        }

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

        // API functions
        async function handleApiResponse(response) {
            const contentType = response.headers.get('content-type');

            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                if (text.startsWith('<!DOCTYPE html>') || text.startsWith('<html')) {
                    // Token might be expired, redirect to login
                    window.location.href = '/login';
                    throw new Error('Session expired, please login again');
                }
                throw new Error(`Invalid content type: ${contentType}. Response: ${text}`);
            }

            if (response.status === 401) {
                // Unauthorized - token expired or invalid
                localStorage.removeItem('token');
                window.location.href = '/login';
                throw new Error('Session expired, please login again');
            }

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
            }

            return response.json();
        }

        async function fetchUsers() {
            showLoading();
            hideError();

            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    window.location.href = '/login';
                    return;
                }

                let url = `${API_BASE_URL}/api/users?page=${currentPage}&limit=${itemsPerPage}`;

                if (searchQuery.trim() !== '') {
                    url += `&search=${encodeURIComponent(searchQuery.trim())}`;
                }

                const response = await fetch(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await handleApiResponse(response);

                if (!data.data || !data.pagination) {
                    throw new Error('Invalid response format from server');
                }

                users = data.data.map(formatUser);
                totalUsers = data.pagination.total;

                renderUsers();
                updatePagination();
            } catch (err) {
                console.error('Error fetching users:', err);
                showError(err.message);
                usersTableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-red-400">
                            Gagal memuat data: ${err.message}
                        </td>
                    </tr>
                `;
            } finally {
                hideLoading();
            }
        }

        async function saveUser(userData) {
            showLoading();

            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    window.location.href = '/login';
                    return;
                }

                const url = isEditMode ?
                    `${API_BASE_URL}/api/users/${selectedUser.id}` :
                    `${API_BASE_URL}/api/users`;

                const method = isEditMode ? 'PUT' : 'POST';

                const response = await fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        first_name: userData.firstName,
                        last_name: userData.lastName,
                        email: userData.email,
                        username: userData.username,
                        password: userData.password,
                        password_confirmation: userData.confirmPassword,
                        role: userData.role,
                        status: userData.status
                    })
                });

                if (response.status === 422) {
                    const errorData = await response.json();
                    console.error('Validation errors:', errorData);

                    let errorMessages = [];
                    for (const field in errorData.errors) {
                        errorMessages.push(...errorData.errors[field]);
                    }

                    showError(errorMessages.join('<br>'));
                    return;
                }

                const data = await handleApiResponse(response);
                console.log('User saved successfully:', data);

                await fetchUsers();
                closeUserModal();
            } catch (error) {
                console.error('Error saving user:', error);
                showError(error.message || 'Terjadi kesalahan saat menyimpan pengguna');
            } finally {
                hideLoading();
            }
        }

        async function changeUserPassword(passwordData) {
            showLoading();
            changePasswordSubmitBtn.disabled = true;
            changePasswordSubmitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
            `;

            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    window.location.href = '/login';
                    return;
                }

                const response = await fetch(`${API_BASE_URL}/api/users/${selectedUser.id}/change-password`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        current_password: passwordData.currentPassword,
                        new_password: passwordData.newPassword,
                        new_password_confirmation: passwordData.confirmNewPassword
                    })
                });

                if (response.status === 422) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Validasi password gagal');
                }

                const data = await handleApiResponse(response);

                alert('Password berhasil diubah');
                closeChangePasswordModal();
            } catch (error) {
                console.error('Error changing password:', error);
                showChangePasswordError(error.message || 'Gagal mengubah password');
            } finally {
                hideLoading();
                changePasswordSubmitBtn.disabled = false;
                changePasswordSubmitBtn.textContent = 'Ganti Password';
            }
        }

        async function deleteUser() {
            showLoading();

            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    window.location.href = '/login';
                    return;
                }

                const response = await fetch(`${API_BASE_URL}/api/users/${selectedUser.id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                await handleApiResponse(response);
                await fetchUsers();
                closeDeleteUserModal();
            } catch (error) {
                console.error('Error deleting user:', error);
                showError(error.message || 'Gagal menghapus pengguna');
            } finally {
                hideLoading();
            }
        }

        // Render functions
        function renderUsers() {
            usersTableBody.innerHTML = '';

            if (users.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-400">
                        ${searchQuery.trim() !== '' ? 'Tidak ditemukan pengguna yang sesuai dengan pencarian' : 'Tidak ada data pengguna'}
                    </td>
                `;
                usersTableBody.appendChild(row);
                return;
            }

            users.forEach(user => {
                const row = document.createElement('tr');
                row.className = 'table-row-hover animate__animated animate__fadeIn';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-${user.avatarColor}-900 flex items-center justify-center shadow-inner">
                                <i class="fas ${user.role === "admin" ? "fa-user" : "fa-user-tie"} text-${user.avatarColor}-400"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-white">
                                    ${user.name}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                        ${user.username}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                        ${user.email}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="badge ${user.role === "admin" ? "badge-admin" : "badge-petugas"}">
                            ${user.role === "admin" ? "Admin" : "Petugas"}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="badge ${user.status === "active" ? "badge-active" : "badge-inactive"}">
                            ${user.status === "active" ? "Aktif" : "Nonaktif"}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button class="text-indigo-400 hover:text-indigo-300 mr-3 transition-colors edit-user-btn" data-id="${user.id}">
                            <i class="fas fa-edit"></i>
                        </button>
                        ${user.role === "admin" ? `
                                    <button class="text-gray-500 cursor-not-allowed" disabled title="Tidak dapat menghapus admin utama">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                ` : `
                                    <button class="text-red-400 hover:text-red-300 mr-3 transition-colors delete-user-btn" data-id="${user.id}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="text-gray-400 hover:text-gray-300 transition-colors change-password-btn" data-id="${user.id}" title="Ganti Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                `}
                    </td>
                `;
                usersTableBody.appendChild(row);
            });

            // Add event listeners to action buttons
            document.querySelectorAll('.edit-user-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const userId = btn.getAttribute('data-id');
                    const user = users.find(u => u.id == userId);
                    if (user) openEditUserModal(user);
                });
            });

            document.querySelectorAll('.delete-user-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const userId = btn.getAttribute('data-id');
                    const user = users.find(u => u.id == userId);
                    if (user) openDeleteUserModal(user);
                });
            });

            document.querySelectorAll('.change-password-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const userId = btn.getAttribute('data-id');
                    const user = users.find(u => u.id == userId);
                    if (user) openChangePasswordModal(user);
                });
            });
        }

        function updatePagination() {
            const startItem = (currentPage - 1) * itemsPerPage + 1;
            const endItem = Math.min(currentPage * itemsPerPage, totalUsers);

            if (totalUsers > 0) {
                paginationInfo.innerHTML = `
                    Menampilkan <span class="font-medium">${startItem}</span> sampai <span class="font-medium">${endItem}</span>
                    dari <span class="font-medium">${totalUsers}</span> pengguna
                `;
            } else {
                paginationInfo.innerHTML = `Tidak ada data pengguna`;
            }

            currentPageSpan.textContent = currentPage;

            // Disable previous button if on first page
            prevPageBtn.disabled = currentPage === 1;
            prevPageMobileBtn.disabled = currentPage === 1;

            // Disable next button if on last page
            const isLastPage = currentPage * itemsPerPage >= totalUsers;
            nextPageBtn.disabled = isLastPage;
            nextPageMobileBtn.disabled = isLastPage;
        }

        // Modal functions
        function openAddUserModal() {
            isEditMode = false;
            selectedUser = null;
            userModalTitle.textContent = 'Tambah Pengguna Baru';

            // Reset form
            userForm.reset();
            passwordFields.style.display = 'block';

            // Show modal
            userModal.classList.remove('hidden');
        }

        function openEditUserModal(user) {
            isEditMode = true;
            selectedUser = user;
            userModalTitle.textContent = 'Edit Data Pengguna';

            // Fill form with user data
            document.getElementById('userFirstName').value = user.firstName || '';
            document.getElementById('userLastName').value = user.lastName || '';
            document.getElementById('userEmail').value = user.email || '';
            document.getElementById('userUsername').value = user.username || '';
            document.getElementById('userRole').value = user.role || 'petugas';
            document.getElementById('userStatus').value = user.status || 'active';

            // Hide password fields for edit mode
            passwordFields.style.display = 'none';

            // Show modal
            userModal.classList.remove('hidden');
        }

        function closeUserModal() {
            userModal.classList.add('hidden');
        }

        function openChangePasswordModal(user) {
            selectedUser = user;
            changePasswordUserInfo.innerHTML = `
                Anda akan mengganti password untuk
                <span class="font-semibold">
                    ${user.firstName || ''} ${user.lastName || ''} (${user.username || ''})
                </span>
            `;

            // Reset form
            changePasswordForm.reset();
            hideChangePasswordError();

            // Show modal
            changePasswordModal.classList.remove('hidden');
        }

        function closeChangePasswordModal() {
            changePasswordModal.classList.add('hidden');
        }

        function openDeleteUserModal(user) {
            selectedUser = user;
            deleteUserInfo.innerHTML = `
                Apakah Anda yakin ingin menghapus pengguna
                <span class="font-semibold">
                    ${user.firstName || ''} ${user.lastName || ''} (${user.username || ''})
                </span>? Data yang sudah dihapus tidak dapat dikembalikan.
            `;

            // Show modal
            deleteUserModal.classList.remove('hidden');
        }

        function closeDeleteUserModal() {
            deleteUserModal.classList.add('hidden');
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', () => {
            // Check for token on page load
            const token = localStorage.getItem('token');
            if (!token) {
                window.location.href = '/login';
                return;
            }

            // Initial fetch
            fetchUsers();

            // Search input with debounce
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);

                if (e.target.value.trim() !== '') {
                    clearSearchBtn.classList.remove('hidden');
                } else {
                    clearSearchBtn.classList.add('hidden');
                }

                // Show loading in table
                usersTableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-400">
                            Mencari pengguna...
                        </td>
                    </tr>
                `;

                searchTimeout = setTimeout(() => {
                    searchQuery = e.target.value;
                    currentPage = 1;
                    fetchUsers();
                }, 500);
            });

            // Clear search button
            clearSearchBtn.addEventListener('click', () => {
                searchInput.value = '';
                searchQuery = '';
                currentPage = 1;
                fetchUsers();
                clearSearchBtn.classList.add('hidden');
            });

            // Items per page select
            itemsPerPageSelect.addEventListener('change', (e) => {
                itemsPerPage = Number(e.target.value);
                currentPage = 1;
                fetchUsers();
            });

            // Pagination buttons
            prevPageBtn.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    fetchUsers();
                }
            });

            nextPageBtn.addEventListener('click', () => {
                if (currentPage * itemsPerPage < totalUsers) {
                    currentPage++;
                    fetchUsers();
                }
            });

            prevPageMobileBtn.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    fetchUsers();
                }
            });

            nextPageMobileBtn.addEventListener('click', () => {
                if (currentPage * itemsPerPage < totalUsers) {
                    currentPage++;
                    fetchUsers();
                }
            });

            // Add user button
            document.getElementById('addUserBtn').addEventListener('click', openAddUserModal);

            // Generate password button
            generatePasswordBtn.addEventListener('click', () => {
                const newPassword = generateRandomPassword();
                document.getElementById('userPassword').value = newPassword;
                document.getElementById('userConfirmPassword').value = newPassword;
            });

            // User form submission
            userForm.addEventListener('submit', (e) => {
                e.preventDefault();

                const formData = {
                    firstName: document.getElementById('userFirstName').value.trim(),
                    lastName: document.getElementById('userLastName').value.trim(),
                    email: document.getElementById('userEmail').value.trim(),
                    username: document.getElementById('userUsername').value.trim(),
                    role: document.getElementById('userRole').value,
                    password: document.getElementById('userPassword').value,
                    confirmPassword: document.getElementById('userConfirmPassword').value,
                    status: document.getElementById('userStatus').value
                };

                if (!isEditMode && formData.password !== formData.confirmPassword) {
                    showError('Password dan konfirmasi password tidak cocok');
                    return;
                }

                if (!isEditMode && !validatePassword(formData.password)) {
                    showError(
                        'Password minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka');
                    return;
                }

                saveUser(formData);
            });

            // Change password form submission
            changePasswordForm.addEventListener('submit', (e) => {
                e.preventDefault();

                const passwordData = {
                    currentPassword: document.getElementById('currentPassword').value,
                    newPassword: document.getElementById('newPassword').value,
                    confirmNewPassword: document.getElementById('confirmNewPassword').value
                };

                // Validation
                if (passwordData.newPassword !== passwordData.confirmNewPassword) {
                    showChangePasswordError('Password baru dan konfirmasi password tidak cocok');
                    return;
                }

                if (!validatePassword(passwordData.newPassword)) {
                    showChangePasswordError(
                        'Password minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka');
                    return;
                }

                changeUserPassword(passwordData);
            });

            // Delete user confirmation
            confirmDeleteUserBtn.addEventListener('click', deleteUser);

            // Modal close buttons
            cancelUserModalBtn.addEventListener('click', closeUserModal);
            cancelChangePasswordModalBtn.addEventListener('click', closeChangePasswordModal);
            cancelDeleteUserModalBtn.addEventListener('click', closeDeleteUserModal);

            // Close modals when clicking outside
            userModal.addEventListener('click', (e) => {
                if (e.target === userModal) closeUserModal();
            });

            changePasswordModal.addEventListener('click', (e) => {
                if (e.target === changePasswordModal) closeChangePasswordModal();
            });

            deleteUserModal.addEventListener('click', (e) => {
                if (e.target === deleteUserModal) closeDeleteUserModal();
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