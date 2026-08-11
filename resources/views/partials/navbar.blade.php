<nav class="bg-white shadow-sm sticky top-0 z-30 border-b border-gray-200">
    <div class="px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="hidden lg:block">
                <h1 class="text-xl font-bold text-gray-800">
                    @yield('page-title', 'Dashboard')
                </h1>
                <p class="text-sm text-gray-500">@yield('page-subtitle', 'Selamat datang, Bendahara!')</p>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <div class="hidden md:flex items-center gap-2 text-sm text-gray-600">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>{{ date('l, d F Y') }}</span>
            </div>
            
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="flex items-center gap-2 p-1.5 hover:bg-gray-100 rounded-lg transition">
                    <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm">
                        {{ Auth::user() ? strtoupper(substr(Auth::user()->name, 0, 2)) : 'B' }}
                    </div>
                </button>
                
                <div x-show="open" 
                     @click.away="open = false"
                     class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-1 z-50">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="font-semibold text-sm">{{ Auth::user() ? Auth::user()->name : 'Bendahara' }}</p>
                        <p class="text-xs text-gray-500">Bendahara</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>