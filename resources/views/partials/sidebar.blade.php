<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            transition: all 0.3s ease;
            width: 250px;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.expanded {
            width: 250px;
        }

        .nav-item {
            transition: all 0.3s ease;
        }

        .nav-item:hover {
            background-color: rgba(99, 102, 241, 0.3);
        }

        .nav-item.active {
            background-color: rgba(99, 102, 241, 0.5);
        }

        .nav-text {
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar.collapsed .user-info {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .toggle-btn {
            transition: transform 0.3s ease;
        }

        .toggle-btn.collapsed {
            transform: rotate(180deg);
        }

        .user-avatar {
            transition: all 0.3s ease;
        }

        .logo-text {
            transition: opacity 0.3s ease;
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
    </style>
</head>
<body>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar bg-gradient-to-b from-indigo-700 to-indigo-800 text-white flex-shrink-0 collapsed relative h-full">
            <div class="flex flex-col h-full">
                <!-- Top part of sidebar (logo and menu) -->
                <div class="flex-1 overflow-y-auto">
                    <div class="p-4 flex items-center justify-between border-b border-indigo-600">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-boxes text-2xl text-indigo-200"></i>
                            <span class="text-xl font-bold logo-text text-indigo-50">
                                InventorySys
                            </span>
                        </div>
                        <button
                            id="toggleSidebar"
                            class="text-indigo-200 hover:text-white focus:outline-none toggle-btn collapsed transition-colors"
                            onclick="toggleSidebarState()"
                        >
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    </div>
                    <nav class="p-4">
                        <div class="space-y-2">
                            <a href="/dashboard" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-indigo-800/30 nav-item glow-effect {{ request()->is('dashboard') ? 'bg-indigo-800/50 active' : '' }}">
                                <i class="fas fa-tachometer-alt text-indigo-200"></i>
                                <span class="nav-text font-medium text-indigo-50">
                                    Dashboard
                                </span>
                            </a>
                            <a href="/databarang" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-indigo-800/30 nav-item glow-effect {{ request()->is('databarang') ? 'bg-indigo-800/50 active' : '' }}">
                                <i class="fas fa-box text-indigo-200"></i>
                                <span class="nav-text font-medium text-indigo-50">
                                    Data Barang
                                </span>
                            </a>
                            <a href="/peminjaman" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-indigo-800/30 nav-item glow-effect {{ request()->is('peminjaman') ? 'bg-indigo-800/50 active' : '' }}">
                                <i class="fas fa-exchange-alt text-indigo-200"></i>
                                <span class="nav-text font-medium text-indigo-50">
                                    Peminjaman
                                </span>
                            </a>
                            <a href="/laporan" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-indigo-800/30 nav-item glow-effect {{ request()->is('laporan') ? 'bg-indigo-800/50 active' : '' }}">
                                <i class="fas fa-chart-bar text-indigo-200"></i>
                                <span class="nav-text font-medium text-indigo-50">
                                    Laporan
                                </span>
                            </a>
                            <a href="/pengguna" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-indigo-800/30 nav-item glow-effect {{ request()->is('pengguna') ? 'bg-indigo-800/50 active' : '' }}">
                                <i class="fas fa-users-cog text-indigo-200"></i>
                                <span class="nav-text font-medium text-indigo-50">
                                    Pengguna
                                </span>
                            </a>
                        </div>
                    </nav>
                </div>

                <!-- Bottom part of sidebar (user info and logout) -->
                <div class="w-full p-4 border-t border-indigo-600">
                    <div class="flex items-center space-x-2 mb-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-600/30 flex items-center justify-center user-avatar border-2 border-indigo-400/50">
                            <i class="fas fa-user text-indigo-200"></i>
                        </div>
                        <div class="user-info">
                            <div class="font-medium text-indigo-50">
                                {{ Auth::user()->username ?? 'Admin' }}
                            </div>
                            <div class="text-xs text-indigo-300">
                                {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Pengguna' }}
                            </div>
                        </div>
                    </div>
                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full flex items-center justify-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition-colors duration-300"
                        >
                            <i class="fas fa-sign-out-alt text-indigo-200"></i>
                            <span class="nav-text font-medium text-indigo-50">
                                Logout
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let isCollapsed = true;

        function toggleSidebarState() {
            isCollapsed = !isCollapsed;
            const sidebar = document.getElementById("sidebar");
            const toggleBtn = document.getElementById("toggleSidebar");

            if (isCollapsed) {
                sidebar.classList.add("collapsed");
                sidebar.classList.remove("expanded");
                toggleBtn.classList.add("collapsed");
                toggleBtn.querySelector('i').className = 'fas fa-chevron-left';
            } else {
                sidebar.classList.add("expanded");
                sidebar.classList.remove("collapsed");
                toggleBtn.classList.remove("collapsed");
                toggleBtn.querySelector('i').className = 'fas fa-chevron-right';
            }
        }
    </script>
</body>
</html>
