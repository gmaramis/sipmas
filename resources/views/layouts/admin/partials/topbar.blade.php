<!-- Topbar -->
<header class="w-full bg-gradient-to-r from-polri-red via-red-600 to-red-800 shadow-lg z-30">
    <div class="flex justify-between items-center px-8 py-4">
        <!-- Left Side -->
        <div>
            @if(Auth::user() && Auth::user()->hasRole('admin'))
                <h1 class="text-2xl font-bold text-white">@yield('page-title', 'Dashboard Admin')</h1>
                <p class="text-red-100 text-sm">Selamat datang kembali, {{ Auth::user()->name ?? 'Admin' }}</p>
            @elseif(Auth::user() && Auth::user()->hasRole('petugas'))
                <h1 class="text-2xl font-bold text-white">@yield('page-title', 'Dashboard Petugas')</h1>
                <p class="text-red-100 text-sm">Selamat bertugas, {{ Auth::user()->name ?? 'Petugas' }}</p>
            @elseif(Auth::user() && Auth::user()->hasRole('user'))
                <h1 class="text-2xl font-bold text-white">@yield('page-title', 'Dashboard Pengguna')</h1>
                <p class="text-red-100 text-sm">Halo, {{ Auth::user()->name ?? 'Pengguna' }}</p>
            @endif
        </div>

        <!-- Right Side -->
        <div class="flex items-center space-x-6">
            <!-- Notifications -->
            <div class="relative">
                <button id="notificationButton" class="bg-white/10 backdrop-blur-sm p-2 rounded-lg hover:bg-white/20 relative transition-colors duration-200">
                    <i class="fas fa-bell text-white text-lg"></i>
                    <span id="notificationBadge" class="absolute -top-1 -right-1 bg-polri-blue text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
                </button>
                <!-- Notification Dropdown -->
                <div id="notificationDropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl hidden z-50 border border-gray-100">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Notifikasi</h3>
                    </div>
                    <div id="notificationList" class="max-h-96 overflow-y-auto">
                        <!-- Notifications will be added here -->
                    </div>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="flex items-center space-x-3 relative">
                <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white shadow-md">
                    <i class="fas fa-user text-lg"></i>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center space-x-2">
                        <span class="text-white font-medium text-sm">{{ Auth::user()->name ?? 'User' }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" title="Logout" class="text-white hover:text-red-400 px-2 py-1 rounded transition">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                    <div class="relative">
                        <button id="profileDropdownButton" class="text-xs text-red-200 hover:text-white transition-colors focus:outline-none">Menu <i class="fas fa-caret-down ml-1"></i></button>
                        <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100">
                            @if(Auth::user() && Auth::user()->hasRole('admin'))
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Profil
                                </a>
                            @elseif(Auth::user() && Auth::user()->hasRole('petugas'))
                                <a href="{{ route('petugas.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Profil
                                </a>
                            @elseif(Auth::user() && Auth::user()->hasRole('user'))
                                <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Profil
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<script>
// Dropdown profile
const profileBtn = document.getElementById('profileDropdownButton');
const profileDropdown = document.getElementById('profileDropdown');
if(profileBtn && profileDropdown) {
    profileBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        profileDropdown.classList.toggle('hidden');
    });
    document.addEventListener('click', function(e) {
        if (!profileDropdown.contains(e.target) && !profileBtn.contains(e.target)) {
            profileDropdown.classList.add('hidden');
        }
    });
}
// Notifikasi toggle
const notifBtn = document.getElementById('notificationButton');
const notifDropdown = document.getElementById('notificationDropdown');
if(notifBtn && notifDropdown) {
    notifBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        notifDropdown.classList.toggle('hidden');
    });
    document.addEventListener('click', function(e) {
        if (!notifDropdown.contains(e.target) && !notifBtn.contains(e.target)) {
            notifDropdown.classList.add('hidden');
        }
    });
}
</script> 