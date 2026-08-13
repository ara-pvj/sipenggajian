<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPENGGAJIAN - @yield('title', 'Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Vite JS -->
    @vite(['resources/js/app.js'])
</head>

    <!-- ===== SIDEBAR ===== -->
<body class="bg-gray-100">

    @include('partials.sidebar')
    
    <!-- ===== MAIN CONTENT ===== -->
    <div class="ml-0 lg:ml-[288px] min-h-screen bg-gray-100">
        
        <!-- Navbar -->
        <div class="bg-white shadow-sm sticky top-0 z-30 border-b border-gray-200">
            <div class="px-4 md:px-6 py-4 flex justify-between items-center">
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-sm text-gray-500">@yield('page-subtitle', 'Selamat datang, ' . Auth::user()->name . '!')</p>
                </div>
                <div class="text-sm text-gray-500 hidden md:block">
                    📅 {{ date('l, d F Y') }}
                </div>
            </div>
        </div>
        
        <!-- Content -->
<div class="p-4 md:p-6">

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')

</div>
    
    <!-- Overlay -->
    <!-- Sidebar Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('aside');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('sidebarClose');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        // Hamburger → buka sidebar
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                openSidebar();
            });
        }

        // X → tutup sidebar
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                closeSidebar();
            });
        }

        // Klik area luar → tutup sidebar
        if (overlay) {
            overlay.addEventListener('click', function() {
                closeSidebar();
            });
        }

        // Kalau layar kembali desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                closeSidebar();
            }
        });
    });
</script>
    
    @stack('scripts')
</body>
</html>