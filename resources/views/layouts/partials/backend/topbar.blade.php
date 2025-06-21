<!-- Topbar Tailwind -->
<header class="fixed top-0 left-64 right-0 z-50 h-16 bg-white shadow-sm border-b border-gray-200 flex items-center px-8 justify-between">
    <!-- Judul dan Selamat Datang -->
    <div>
        <h1 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
        <p class="text-gray-600 text-sm hidden md:block">Selamat datang, {{ Auth::user()->name ?? 'User' }}</p>
    </div>
    <!-- Notifikasi dan Profil -->
    <div class="flex items-center space-x-4">
        <!-- Notifikasi -->
        <div class="relative">
            <button id="notificationButton" class="bg-white p-2 rounded-lg shadow-md hover:bg-gray-50 relative transition-colors duration-200">
                <i class="fas fa-bell text-gray-600"></i>
                <span id="notificationBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
            </button>
            <!-- Dropdown Notifikasi -->
            <div id="notificationDropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl hidden z-50 border border-gray-100">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Notifikasi</h3>
                </div>
                <div id="notificationList" class="max-h-96 overflow-y-auto">
                    <!-- Notifikasi akan ditambahkan di sini -->
                </div>
            </div>
        </div>
        <!-- Profil User -->
        <div class="relative">
            <button id="userMenuButton" class="flex items-center space-x-2 focus:outline-none">
                <div class="w-10 h-10 rounded-full bg-polri-blue flex items-center justify-center text-white shadow-md">
                    <i class="fas fa-user"></i>
                </div>
                <span class="text-gray-800 font-medium hidden md:block">{{ Auth::user()->name ?? 'User' }}</span>
            </button>
            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100">
                <a href="{{ route(Auth::user()->hasRole('admin') ? 'profile.edit' : (Auth::user()->hasRole('petugas') ? 'petugas.profile' : 'user.profile')) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-user mr-2"></i>Profil
                </a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
<script>
// User menu toggle
const userMenuBtn = document.getElementById('userMenuButton');
const userMenu = document.getElementById('userMenu');
userMenuBtn && userMenuBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    userMenu.classList.toggle('hidden');
});
document.addEventListener('click', function(e) {
    if (userMenu && !userMenu.contains(e.target) && !userMenuBtn.contains(e.target)) {
        userMenu.classList.add('hidden');
    }
});
// Notifikasi toggle
const notifBtn = document.getElementById('notificationButton');
const notifDropdown = document.getElementById('notificationDropdown');
notifBtn && notifBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    notifDropdown.classList.toggle('hidden');
});
document.addEventListener('click', function(e) {
    if (notifDropdown && !notifDropdown.contains(e.target) && !notifBtn.contains(e.target)) {
        notifDropdown.classList.add('hidden');
    }
});
</script> 