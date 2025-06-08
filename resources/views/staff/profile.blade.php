<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Inventory System</title>
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
        /* Updated styles to match admin/pengguna.blade.php */
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

        /* Profile specific styles */
        .profile-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            background: linear-gradient(to bottom, #131924, #0f172a);
        }

        .profile-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
        }

        .avatar-large {
            width: 120px;
            height: 120px;
            border: 4px solid rgba(165, 180, 252, 0.3);
            background-color: rgba(79, 70, 229, 0.3);
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #1e293b;
            color: #e5e7eb;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .form-control {
            background-color: #131924;
            border: 1px solid #374151;
            color: white;
        }

        .form-control:focus {
            background-color: #131924;
            border-color: #6366f1;
            color: white;
            outline: none;
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
                            <span class="text-xl font-bold logo-text text-white">
                                Inventory System
                            </span>
                        </div>
                    </div>
                    <!-- Navigation -->
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
                                    Data Orang
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
                            <img src="{{ asset('sidebar/admin.png') }}" alt="admin" class="rounded-full">
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
                        class="text-indigo-200 hover:text-white focus:outline-none toggle-btn collapsed transition-colors mr-5"
                        onclick="toggleSidebarState()">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    {{-- <button id="mobileToggleSidebar"
                        class="text-indigo-200 hover:text-white mr-4 focus:outline-none lg:hidden transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button> --}}
                    <h1 class="text-2xl font-bold text-white animate__animated animate__fadeIn">
                        Profil Saya
                    </h1>
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

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Profile Card -->
                    <div class="lg:col-span-1">
                        <div class="rounded-xl shadow-md p-6 profile-card card-hover">
                            <div class="flex flex-col items-center">
                                <div class="avatar-large rounded-full flex items-center justify-center mb-4 shadow-lg">
                                    <i class="fas fa-user text-indigo-400 text-4xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-1">{{ Auth::user()->first_name }}
                                    {{ Auth::user()->last_name }}</h3>
                                <p class="text-gray-300 mb-6">
                                    {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Petugas' }}</p>

                                <div class="w-full">
                                    <div class="detail-item">
                                        <span class="text-gray-400">Username</span>
                                        <span class="font-medium text-white">{{ Auth::user()->username }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="text-gray-400">Email</span>
                                        <span class="font-medium text-white">{{ Auth::user()->email }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="text-gray-400">Status</span>
                                        <span
                                            class="font-medium {{ Auth::user()->status === 'active' ? 'text-green-400' : 'text-red-400' }}">
                                            {{ Auth::user()->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="text-gray-400">Terakhir Login</span>
                                        <span
                                            class="font-medium text-white">{{ Auth::user()->last_login_at ? \Carbon\Carbon::parse(Auth::user()->last_login_at)->diffForHumans() : 'Belum pernah login' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-[#131924] rounded-xl shadow-md overflow-hidden card-hover">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-white mb-6">Informasi Profil</h3>

                                <form id="profileForm">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="firstName"
                                                class="block text-sm font-medium text-gray-300 mb-1">Nama Depan</label>
                                            <input type="text" id="firstName" name="first_name"
                                                value="{{ Auth::user()->first_name }}"
                                                class="form-control w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                        <div>
                                            <label for="lastName"
                                                class="block text-sm font-medium text-gray-300 mb-1">Nama
                                                Belakang</label>
                                            <input type="text" id="lastName" name="last_name"
                                                value="{{ Auth::user()->last_name }}"
                                                class="form-control w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="email"
                                            class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                                        <input type="email" id="email" name="email"
                                            value="{{ Auth::user()->email }}"
                                            class="form-control w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    <div class="mb-4">
                                        <label for="username"
                                            class="block text-sm font-medium text-gray-300 mb-1">Username</label>
                                        <input type="text" id="username" name="username"
                                            value="{{ Auth::user()->username }}"
                                            class="form-control w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    <div class="flex justify-end mt-6">
                                        <button type="submit"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="border-t border-gray-700 p-6">
                                <h3 class="text-lg font-medium text-white mb-6">Ubah Password</h3>

                                <form id="passwordForm">
                                    <div class="mb-4">
                                        <label for="currentPassword"
                                            class="block text-sm font-medium text-gray-300 mb-1">Password Saat
                                            Ini</label>
                                        <input type="password" id="currentPassword" name="current_password"
                                            class="form-control w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="newPassword"
                                                class="block text-sm font-medium text-gray-300 mb-1">Password
                                                Baru</label>
                                            <input type="password" id="newPassword" name="new_password"
                                                class="form-control w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                        <div>
                                            <label for="confirmPassword"
                                                class="block text-sm font-medium text-gray-300 mb-1">Konfirmasi
                                                Password</label>
                                            <input type="password" id="confirmPassword"
                                                name="new_password_confirmation"
                                                class="form-control w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                    </div>

                                    <div class="text-xs text-gray-400 mb-4">
                                        Password minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka.
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="submit"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                            Ubah Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Helper functions
        function showLoading() {
            document.getElementById('loadingIndicator').classList.remove('hidden');
        }

        function hideLoading() {
            document.getElementById('loadingIndicator').classList.add('hidden');
        }

        function showError(message) {
            document.getElementById('errorMessage').innerHTML = message;
            document.getElementById('errorAlert').classList.remove('hidden');
        }

        function hideError() {
            document.getElementById('errorAlert').classList.add('hidden');
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

        async function updateProfile(profileData) {
            showLoading();

            try {
                const response = await fetch('{{ route('api.profile.update') }}', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(profileData)
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
                console.log('Profile updated successfully:', data);

                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Profil berhasil diperbarui',
                    timer: 2000,
                    showConfirmButton: false
                });

                // Reload page to reflect changes
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } catch (error) {
                console.error('Error updating profile:', error);
                showError(error.message || 'Terjadi kesalahan saat memperbarui profil');
            } finally {
                hideLoading();
            }
        }

        async function changePassword(passwordData) {
            showLoading();

            try {
                const response = await fetch('{{ route('api.profile.change-password') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(passwordData)
                });

                if (response.status === 422) {
                    const errorData = await response.json();
                    let errorMessages = [];
                    for (const field in errorData.errors) {
                        errorMessages.push(...errorData.errors[field]);
                    }
                    throw new Error(errorMessages.join('<br>') || 'Validasi password gagal');
                }

                const data = await handleApiResponse(response);

                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Password berhasil diubah',
                    timer: 2000,
                    showConfirmButton: false
                });

                // Reset form
                document.getElementById('passwordForm').reset();
            } catch (error) {
                console.error('Error changing password:', error);
                showError(error.message || 'Gagal mengubah password');
            } finally {
                hideLoading();
            }
        }

        // Form validation
        function validatePassword(password) {
            const minLength = 8;
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumbers = /\d/.test(password);

            return password.length >= minLength && hasUpperCase && hasLowerCase && hasNumbers;
        }

        // Event listeners
        document.getElementById('profileForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = {
                first_name: document.getElementById('firstName').value.trim(),
                last_name: document.getElementById('lastName').value.trim(),
                email: document.getElementById('email').value.trim(),
                username: document.getElementById('username').value.trim()
            };

            await updateProfile(formData);
        });

        document.getElementById('passwordForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const passwordData = {
                current_password: document.getElementById('currentPassword').value,
                new_password: document.getElementById('newPassword').value,
                new_password_confirmation: document.getElementById('confirmPassword').value
            };

            // Validation
            if (passwordData.new_password !== passwordData.new_password_confirmation) {
                showError('Password baru dan konfirmasi password tidak cocok');
                return;
            }

            if (!validatePassword(passwordData.new_password)) {
                showError('Password minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka');
                return;
            }

            await changePassword(passwordData);
        });

        // Sidebar toggle functionality
        let isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true' || true;

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
