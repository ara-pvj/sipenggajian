<!-- Tombol Toggle Sidebar -->
<button id="sidebarToggle" 
        class="fixed top-4 left-4 z-50 p-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl lg:hidden">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<!-- Overlay -->
<div id="sidebarOverlay" 
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 hidden transition-opacity duration-300 lg:hidden">
</div>

<!-- Sidebar -->
<aside id="sidebar" 
       class="fixed z-50 w-[288px] h-screen bg-gradient-to-b from-blue-800 via-blue-700 to-blue-600 text-white flex flex-col transition-transform duration-300 ease-in-out shadow-2xl">
    
    <!-- Tombol Close -->
    <button id="closeSidebar" 
            class="absolute top-4 right-4 p-2 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition lg:hidden">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <!-- Header -->
    <div class="flex flex-col items-center py-8 px-4 border-b border-white/10">
        <img src="{{ asset('images/logo.png') }}" 
             alt="Logo" 
             class="w-20 h-20 object-contain mb-3">
        <h2 class="font-bold text-2xl tracking-wider">SIPENGGAJIAN</h2>
        <p class="text-blue-200 text-sm mt-1 font-light">SMP Roudhotul Mardhiyyah</p>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-1.5">

    @php
    $role = Auth::user()->role;
    @endphp

        <div class="mb-4 px-3 text-xs font-semibold text-blue-200 uppercase tracking-wider">
            Menu Utama
        </div>
        
        @if($role == 'bendahara')
        <a href="{{ route('dashboard.bendahara') }}"
        class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('dashboard.bendahara') ? 'bg-white/20 shadow-lg' : '' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 3l9 7.5M5.5 9.5V21h13V9.5M9 21v-7h6v7"/></svg>
        <span class="font-medium">Dashboard</span>
    </a>
    @endif

        @if($role == 'tata_usaha')
        <a href="{{ route('dashboard.tatausaha') }}"
        class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('dashboard.tatausaha') ? 'bg-white/20 shadow-lg' : '' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 3l9 7.5M5.5 9.5V21h13V9.5M9 21v-7h6v7"/></svg>
        <span class="font-medium">Dashboard</span>
    </a>
    @endif

    @if($role == 'kurikulum')
            <a href="{{ route('dashboard.kurikulum') }}"
            class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('dashboard.kurikulum') ? 'bg-white/20 shadow-lg' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 3l9 7.5M5.5 9.5V21h13V9.5M9 21v-7h6v7"/></svg>
            <span class="font-medium">Dashboard</span>
            </a>
        @endif

        @if($role == 'tata_usaha')
        <a href="{{ route('pegawai.index') }}" 
           class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('pegawai.*') ? 'bg-white/20 shadow-lg' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="9" cy="8" r="4"/><path stroke-width="1.8" stroke-linecap="round" d="M2.5 21a6.5 6.5 0 0 1 13 0M16 4.5a4 4 0 0 1 0 7.5M17 15h1a4 4 0 0 1 4 4v2"/></svg>
            <span class="font-medium">Data Pegawai</span>
        </a>

                <a href="{{ route('akun.index') }}"
           class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('akun.*') ? 'bg-white/20 shadow-lg' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M15 7a4 4 0 1 0-8 0 4 4 0 0 0 8 0ZM3 21a6 6 0 0 1 12 0M16 11h5M18.5 8.5v5"/>
            </svg>
            <span class="font-medium">Pengelolaan Akun</span>
        </a>
        
        <a href="{{ route('absensi.index') }}" 
   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('absensi.index') ? 'bg-white/20 shadow-lg' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="4" y="3" width="16" height="18" rx="2"/><path stroke-width="1.8" stroke-linecap="round" d="M8 8h8M8 12h8M8 16h5"/></svg>
            <span class="font-medium">Absensi</span>
        </a>

        <a href="{{ route('absensi.rekap') }}"
class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('absensi.rekap') ? 'bg-white/20 shadow-lg' : '' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="5" y="4" width="14" height="17" rx="2"/><path stroke-width="1.8" stroke-linecap="round" d="M9 4V3h6v1M8 9h8M8 13h8M8 17h5"/></svg>
    <span class="font-medium">Rekap Absensi</span>
</a>
    @endif

        @if($role == 'kurikulum')

        <a href="{{ route('tahun-pelajaran.index') }}"
        class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('tahun-pelajaran.*') ? 'bg-white/20 shadow-lg' : '' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.8" stroke-linejoin="round" d="M4 5l4-1v16l-4 1V5ZM8 4l4 1v16l-4-1M12 5l4-1v16l-4 1M16 4l4 1v16l-4-1"/></svg>
        <span class="font-medium">Tahun Pelajaran</span>
    </a>

        <a href="{{ route('jadwal-mengajar.index') }}"
        class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('jadwal-mengajar.*') ? 'bg-white/20 shadow-lg' : '' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3.5" y="5" width="17" height="16" rx="2"/><path stroke-width="1.8" stroke-linecap="round" d="M7 3v4M17 3v4M3.5 9h17M8 13h3M13 13h3M8 17h3"/></svg>
        <span class="font-medium">Jadwal Mengajar</span>
    </a>

    @endif

        @if(in_array($role, ['guru', 'staff']))

<a href="{{ route('dashboard.guru') }}"
class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('dashboard.guru') ? 'bg-white/20 shadow-lg' : '' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 3l9 7.5M5.5 9.5V21h13V9.5M9 21v-7h6v7"/></svg>
    <span class="font-medium">Dashboard</span>
</a>

@endif

    @if($role == 'kepala_sekolah')
<a href="{{ route('dashboard.kepala') }}"
class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('dashboard.kepala') ? 'bg-white/20 shadow-lg' : '' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 3l9 7.5M5.5 9.5V21h13V9.5M9 21v-7h6v7"/></svg>
    <span class="font-medium">Dashboard</span>
</a>

<a href="{{ route('absensi.rekap') }}"
class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('absensi.rekap') ? 'bg-white/20 shadow-lg' : '' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="5" y="4" width="14" height="17" rx="2"/><path stroke-width="1.8" stroke-linecap="round" d="M9 4V3h6v1M8 9h8M8 13h8M8 17h5"/></svg>
    <span class="font-medium">Rekap Absensi</span>
</a>

<a href="{{ route('laporan.index') }}"
class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('laporan.*') ? 'bg-white/20 shadow-lg' : '' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.8" stroke-linecap="round" d="M4 20V10M10 20V4M16 20v-7M22 20H2"/></svg>
    <span class="font-medium">Laporan</span>
</a>
@endif


        @if($role == 'bendahara')
        <div class="my-4 border-t border-white/10"></div>
        
        <div class="mb-4 px-3 text-xs font-semibold text-blue-200 uppercase tracking-wider">
            Keuangan
        </div>

    <a href="{{ route('komponen.index') }}" 
   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('komponen.*') ? 'bg-white/20 shadow-lg' : '' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path stroke-width="1.8" stroke-linecap="round" d="M19 12a7 7 0 0 0-.2-1.7l1.4-1.1-2-2-1.2 1.4A7 7 0 0 0 15.4 8L15 6h-3l-.4 2a7 7 0 0 0-1.6.6L8.8 7.2l-2 2 1.4 1.1A7 7 0 0 0 8 12c0 .6.1 1.2.2 1.7l-1.4 1.1 2 2 1.2-1.4c.5.3 1 .5 1.6.6l.4 2h3l.4-2a7 7 0 0 0 1.6-.6l1.2 1.4 2-2-1.4-1.1c.1-.5.2-1.1.2-1.7Z"/></svg>
    <span class="font-medium">Komponen Penggajian</span>
</a>

        <a href="{{ route('penggajian.index') }}" 
           class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('penggajian.*') ? 'bg-white/20 shadow-lg' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="12" cy="12" r="3"/><path stroke-width="1.8" stroke-linecap="round" d="M7 9h.01M17 15h.01"/></svg>
            <span class="font-medium">Penggajian</span>
        </a>

        <a href="{{ route('slip.index') }}" 
           class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('slip.*') ? 'bg-white/20 shadow-lg' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.8" stroke-linejoin="round" d="M6 3h8l4 4v14H6zM14 3v5h4"/><path stroke-width="1.8" stroke-linecap="round" d="M9 13h6M9 17h6"/></svg>
            <span class="font-medium">Slip Gaji</span>
        </a>

        <a href="{{ route('laporan.index') }}" 
           class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('laporan.*') ? 'bg-white/20 shadow-lg' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.8" stroke-linecap="round" d="M4 20V10M10 20V4M16 20v-7M22 20H2"/></svg>
            <span class="font-medium">Laporan</span>
        </a>
    @endif

    </nav>

    <!-- Footer -->
    <div class="border-t border-white/10 p-4 relative z-50">
        <div class="bg-white/5 rounded-xl p-4 mb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-lg font-bold">
                    {{ strtoupper(substr(Auth::user()->pegawai->nama ?? Auth::user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm truncate">{{ Auth::user()->pegawai->nama ?? Auth::user()->name }}</p>
                    <p class="text-blue-200 text-xs truncate">{{ ucwords(str_replace('_', ' ', Auth::user()->role)) }}</p>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 bg-red-500/20 hover:bg-red-500/30 text-red-100 rounded-xl py-3 font-semibold transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>
