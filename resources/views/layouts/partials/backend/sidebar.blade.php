<!-- Sidebar Tailwind -->
<aside class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-lg flex flex-col">
    <!-- Brand -->
    <div class="flex items-center h-16 px-6 border-b border-gray-200">
        <img src="{{ asset('img/polri-presisi.png') }}" class="h-8 w-auto" alt="Logo Polri">
        <span class="ml-3 text-xl font-bold text-gray-900">SIPMAS</span>
    </div>
    <!-- Nav -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        @if(Auth::user() && Auth::user()->hasRole('admin'))
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-polri-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </a>
            <a href="{{ route('admin.pengaduan') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.pengaduan*') ? 'bg-polri-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-file-alt mr-3"></i> Pengaduan
            </a>
            <a href="{{ route('admin.kategori') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.kategori*') ? 'bg-polri-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-tags mr-3"></i> Kategori
            </a>
            <a href="{{ route('admin.pengguna') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.pengguna*') ? 'bg-polri-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-users mr-3"></i> Pengguna
            </a>
            <a href="{{ route('admin.petugas') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.petugas*') ? 'bg-polri-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-user-shield mr-3"></i> Petugas
            </a>
            <a href="{{ route('admin.statistik') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.statistik*') ? 'bg-polri-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-chart-bar mr-3"></i> Statistik
            </a>
            <a href="{{ route('admin.pengaturan') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.pengaturan*') ? 'bg-polri-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-cog mr-3"></i> Pengaturan
            </a>
        @elseif(Auth::user() && Auth::user()->hasRole('petugas'))
            <a href="{{ route('petugas.dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('petugas.dashboard') ? 'bg-polri-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </a>
            <a href="{{ route('petugas.complaints') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('petugas.complaints*') ? 'bg-polri-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-clipboard-list mr-3"></i> Pengaduan
            </a>
            <a href="{{ route('petugas.statistics') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('petugas.statistics') ? 'bg-polri-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-chart-bar mr-3"></i> Statistik
            </a>
        @elseif(Auth::user() && Auth::user()->hasRole('user'))
            <a href="{{ route('user.dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-polri-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </a>
            <a href="{{ route('user.complaints.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('user.complaints*') ? 'bg-polri-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-clipboard-list mr-3"></i> Pengaduan Saya
            </a>
            <a href="{{ route('user.profile') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('user.profile') ? 'bg-polri-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-user mr-3"></i> Profil
            </a>
        @endif
    </nav>
    <div class="p-4 border-t border-gray-200 mt-auto">
        <div class="text-xs text-gray-500">
            <p class="font-medium">SIPMAS</p>
            <p>Polres Minahasa</p>
        </div>
    </div>
</aside> 