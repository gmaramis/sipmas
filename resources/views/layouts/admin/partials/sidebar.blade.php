<!-- Sidebar -->
<aside class="w-64 bg-polri-blue text-white h-screen fixed left-0 top-0 z-40">
    <div class="flex items-center justify-center h-16 border-b border-gray-700/50">
        <img src="{{ asset('img/polres-minahasa.png') }}" alt="Logo Polres Minahasa" class="h-10 w-auto mr-2">
        <span class="text-xl font-bold">SIPMAS</span>
    </div>
    <nav class="mt-6">
        <div class="px-4 space-y-2">
            @if(Auth::user() && Auth::user()->hasRole('admin'))
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-white {{ request()->routeIs('admin.dashboard') ? 'bg-polri-red' : 'hover:bg-gray-700/50' }} rounded-lg shadow-lg">
                    <i class="fas fa-home w-6"></i>
                    <span class="mx-4">Dashboard</span>
                </a>
                <a href="{{ route('admin.pengaduan') }}" class="flex items-center px-4 py-3 text-gray-300 {{ request()->routeIs('admin.pengaduan*') ? 'bg-polri-red' : 'hover:bg-gray-700/50' }} rounded-lg transition-colors duration-200">
                    <i class="fas fa-exclamation-circle w-6"></i>
                    <span class="mx-4">Pengaduan</span>
                </a>
                <a href="{{ route('admin.pengguna') }}" class="flex items-center px-4 py-3 text-gray-300 {{ request()->routeIs('admin.pengguna*') ? 'bg-polri-red' : 'hover:bg-gray-700/50' }} rounded-lg transition-colors duration-200">
                    <i class="fas fa-users w-6"></i>
                    <span class="mx-4">Pengguna</span>
                </a>
                <a href="{{ route('admin.statistik') }}" class="flex items-center px-4 py-3 text-gray-300 {{ request()->routeIs('admin.statistik*') ? 'bg-polri-red' : 'hover:bg-gray-700/50' }} rounded-lg transition-colors duration-200">
                    <i class="fas fa-chart-bar w-6"></i>
                    <span class="mx-4">Statistik</span>
                </a>
                <a href="{{ route('admin.petugas') }}" class="flex items-center px-4 py-3 text-gray-300 {{ request()->routeIs('admin.petugas*') ? 'bg-polri-red' : 'hover:bg-gray-700/50' }} rounded-lg transition-colors duration-200">
                    <i class="fas fa-user-shield w-6"></i>
                    <span class="mx-4">Petugas</span>
                </a>
                <a href="{{ route('admin.pengaturan') }}" class="flex items-center px-4 py-3 text-gray-300 {{ request()->routeIs('admin.pengaturan*') ? 'bg-polri-red' : 'hover:bg-gray-700/50' }} rounded-lg transition-colors duration-200">
                    <i class="fas fa-cog w-6"></i>
                    <span class="mx-4">Pengaturan</span>
                </a>
            @elseif(Auth::user() && Auth::user()->hasRole('petugas'))
                <a href="{{ route('petugas.dashboard') }}" class="flex items-center px-4 py-3 text-white {{ request()->routeIs('petugas.dashboard') ? 'bg-polri-red' : 'hover:bg-gray-700/50' }} rounded-lg shadow-lg">
                    <i class="fas fa-home w-6"></i>
                    <span class="mx-4">Dashboard</span>
                </a>
                <a href="{{ route('petugas.complaints') }}" class="flex items-center px-4 py-3 text-gray-300 {{ request()->routeIs('petugas.complaints*') ? 'bg-polri-red' : 'hover:bg-gray-700/50' }} rounded-lg transition-colors duration-200">
                    <i class="fas fa-clipboard-list w-6"></i>
                    <span class="mx-4">Pengaduan</span>
                </a>
                <a href="{{ route('petugas.statistics') }}" class="flex items-center px-4 py-3 text-gray-300 {{ request()->routeIs('petugas.statistics') ? 'bg-polri-red' : 'hover:bg-gray-700/50' }} rounded-lg transition-colors duration-200">
                    <i class="fas fa-chart-bar w-6"></i>
                    <span class="mx-4">Statistik</span>
                </a>
            @elseif(Auth::user() && Auth::user()->hasRole('user'))
                <a href="{{ route('user.dashboard') }}" class="flex items-center px-4 py-3 text-white {{ request()->routeIs('user.dashboard') ? 'bg-polri-red' : 'hover:bg-gray-700/50' }} rounded-lg shadow-lg">
                    <i class="fas fa-home w-6"></i>
                    <span class="mx-4">Dashboard</span>
                </a>
                <a href="{{ route('user.complaints.index') }}" class="flex items-center px-4 py-3 text-gray-300 {{ request()->routeIs('user.complaints*') ? 'bg-polri-red' : 'hover:bg-gray-700/50' }} rounded-lg transition-colors duration-200">
                    <i class="fas fa-clipboard-list w-6"></i>
                    <span class="mx-4">Pengaduan Saya</span>
                </a>
                <a href="{{ route('user.profile') }}" class="flex items-center px-4 py-3 text-gray-300 {{ request()->routeIs('user.profile') ? 'bg-polri-red' : 'hover:bg-gray-700/50' }} rounded-lg transition-colors duration-200">
                    <i class="fas fa-user w-6"></i>
                    <span class="mx-4">Profil</span>
                </a>
            @endif
        </div>
    </nav>
    <div class="mt-auto px-4 pb-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center w-full px-4 py-3 text-polri-red hover:bg-gray-100 rounded-lg transition-colors duration-200">
                <i class="fas fa-sign-out-alt w-6"></i>
                <span class="mx-4">Logout</span>
            </button>
        </form>
    </div>
</aside> 