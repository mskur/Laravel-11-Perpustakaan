<html lang="en">
<head>
    <img src="{{ asset('storage/img/book.png') }}" alt="favicon" class="favicon" style="display:none;">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .sidebar {
            transition: width 0.3s;
        }
        .sidebar-collapsed {
            width: 64px;
        }
        .sidebar-expanded {
            width: 256px;
        }
        .sidebar-collapsed .sidebar-text {
            display: none;
        }
        .sidebar-expanded .sidebar-text {
            display: inline;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar sidebar-expanded bg-white h-screen shadow-md fixed top-0 left-0 h-full overflow-y-auto">
            <div class="flex items-center justify-between h-16 border-b px-4">
                <img src="https://storage.googleapis.com/a1aa/image/TYbD889Iz154i43k6585zzO0SxZRk6jjrk1M1-OkQ7o.jpg" alt="Logo" class="h-10">
                <button onclick="toggleSidebar()" class="text-gray-500 focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <nav class="mt-10">
                <a href="{{ route('dashboardAdmin') }}" 
                class="flex items-center py-2 px-8 {{ Request::routeIs('dashboardAdmin') ? 'bg-gray-200 text-gray-700 md:font-bold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <span class="sidebar-text">Dashboards</span>
                </a>

                <a href="{{ route('booksAdmin.index') }}" 
                class="flex items-center py-2 px-8 {{ Request::routeIs('booksAdmin.index', 'booksAdmin.create', 'booksAdmin.edit') ? 'bg-gray-200 text-gray-700 md:font-bold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-journal-whills mr-3"></i>
                    <span class="sidebar-text">Buku</span>
                </a>

                <a href="{{ route('categoryAdmin.index') }}" 
                class="flex items-center py-2 px-8 {{ Request::routeIs('categoryAdmin.index', 'categoryAdmin.create', 'categoryAdmin.edit') ? 'bg-gray-200 text-gray-700 md:font-bold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-boxes mr-2.5"></i>
                    <span class="sidebar-text">Kategori</span>
                </a>

                <a href="#" class="flex items-center py-2 px-8 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-box mr-3"></i>
                    <span class="sidebar-text">Product</span>
                </a>
                <a href="#" class="flex items-center py-2 px-8 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-puzzle-piece mr-3"></i>
                    <span class="sidebar-text">UI Elements</span>
                </a>
                <a href="#" class="flex items-center py-2 px-8 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-file mr-3"></i>
                    <span class="sidebar-text">Pages</span>
                </a>
                <a href="#" class="flex items-center py-2 px-8 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-calendar-alt mr-3"></i>
                    <span class="sidebar-text">Calendar</span>
                </a>
                <a href="#" class="flex items-center py-2 px-8 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-edit mr-3"></i>
                    <span class="sidebar-text">Forms</span>
                </a>
                <a href="#" class="flex items-center py-2 px-8 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-table mr-3"></i>
                    <span class="sidebar-text">Tables</span>
                </a>
                <a href="{{ route('usersAdmin.index') }}" class="flex items-center py-2 px-8 {{ Request::routeIs('usersAdmin.index', 'usersAdmin.create', 'usersAdmin.edit') ? 'bg-gray-200 text-gray-700 md:font-bold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-user-friends mr-2"></i>
                    <span class="sidebar-text">Users</span>
                </a>
                @if(session('role') === 'superadmin')
                <a href="{{ route('adminaction.index') }}" class="flex items-center py-2 px-8 {{ Request::routeIs('adminaction.index', 'adminaction.create', 'adminaction.edit') ? 'bg-gray-200 text-gray-700 md:font-bold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-solid fa-user-tie mr-3"></i>
                    <span class="sidebar-text">Admin</span>
                </a>
                @endif
            </nav>
        </div>
        <!-- Main Content -->
        <div class="main-content flex-1 p-6 ml-64 overflow-auto transition-all duration-300">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <i class="fas fa-home text-gray-500 mr-2"></i>
                    <span class="text-gray-500">Home</span>
                    @yield('beforeTitle')
                    <i class="fas fa-chevron-right text-gray-500 mx-2"></i>
                    <span class="text-gray-700">@yield('title')</span>
                </div>
                <div class="flex items-center relative">
                    <div class="ml-4">
                        <span class="ml-2 text-gray-700">{{ session('nama_user') }}</span>
                    </div>
                    <div class="ml-4 relative">
                        <button onclick="toggleProfileMenu()" class="focus:outline-none">
                            <img src="{{ session('foto_user') ? asset('storage/' . session('foto_user')) : 'https://ui-avatars.com/api/?name='.urlencode(session('foto_user')).'&background=random' }}" alt="User Avatar" class="h-10 w-10 rounded-full">
                        </button>
                        <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                            <a href="{{ route('getUser') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="{{ route('logoutUser') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Stats -->

            @yield('content')
            @yield('scripts')
            
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"></script>
    <script>
        // JavaScript for sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.querySelector('.main-content'); // Ambil konten utama
        
        function toggleSidebar() {
            if (sidebar.classList.contains('sidebar-expanded')) {
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapsed');
                mainContent.classList.remove('ml-64');
                mainContent.classList.add('ml-16');
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
                mainContent.classList.remove('ml-16');
                mainContent.classList.add('ml-64');
            }
        }

        // JavaScript for profile menu toggle
        const profileMenu = document.getElementById('profileMenu');
        const toggleProfileMenu = () => {
            profileMenu.classList.toggle('hidden');
        };

        // Close profile menu when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.focus:outline-none')) {
                if (!profileMenu.classList.contains('hidden')) {
                    profileMenu.classList.add('hidden');
                }
            }
        };
    </script>

</body>
</html>


