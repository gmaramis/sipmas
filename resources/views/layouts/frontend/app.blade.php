<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Pengaduan Masyarakat Polres Minahasa - Layanan pengaduan digital yang aman dan terpercaya">
    <meta name="keywords" content="pengaduan, polres, minahasa, sipmas, polri">
    <meta name="author" content="Polres Minahasa">
    <meta name="robots" content="index, follow">
    <title>@yield('title', 'Sistem Pengaduan Masyarakat - Polres')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/polres-minahasa.png') }}">
    
    <!-- Preload resources -->
    <link rel="preload" href="{{ asset('img/polres-minahasa.png') }}" as="image">
    <link rel="preload" href="https://cdn.tailwindcss.com" as="script">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'polri-blue': '#0A1F44',
                        'polri-red': '#C8102E',
                    }
                }
            }
        }
    </script>
    <style>
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.3s ease-in-out;
        }
        .loading img {
            width: 100px;
            height: auto;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        .content {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .content.loaded {
            opacity: 1;
        }
    </style>
    @yield('additional_css')
</head>
<body class="bg-gray-100">
    <!-- Loading state -->
    <div class="loading" id="loading">
        <img src="{{ asset('img/polres-minahasa.png') }}" alt="Loading...">
    </div>

    <!-- Main content -->
    <div class="content">
        <!-- Navbar -->
        <nav class="bg-polri-blue text-white shadow-lg fixed w-full z-50 backdrop-blur-md bg-opacity-90">
            <div class="container mx-auto px-6 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{ asset('img/polres-minahasa.png') }}" alt="Logo Polres Minahasa" class="h-12 w-auto mr-4 object-contain hover:opacity-90 transition-opacity duration-300">
                        <div class="flex flex-col">
                            <span class="text-xl font-bold">SIPMAS</span>
                            <span class="text-xs text-gray-300">Polres Minahasa</span>
                        </div>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button type="button" id="mobile-menu-button" class="text-white hover:text-gray-200 focus:outline-none focus:text-gray-200">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Desktop menu -->
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('home') }}" class="hover:text-gray-200">Beranda</a>
                        <a href="{{ route('about') }}" class="hover:text-gray-200">Tentang</a>
                        <a href="{{ route('contact') }}" class="hover:text-gray-200">Kontak</a>
                        <a href="{{ route('login') }}" class="bg-white text-polri-blue px-4 py-2 rounded-md hover:bg-gray-100">Masuk</a>
                        <a href="{{ route('register') }}" class="border border-white px-4 py-2 rounded-md hover:bg-polri-red">Daftar</a>
                    </div>
                </div>
                <!-- Mobile menu -->
                <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
                    <div class="flex flex-col space-y-4">
                        <a href="{{ route('home') }}" class="hover:text-gray-200">Beranda</a>
                        <a href="{{ route('about') }}" class="hover:text-gray-200">Tentang</a>
                        <a href="{{ route('contact') }}" class="hover:text-gray-200">Kontak</a>
                        <a href="{{ route('login') }}" class="bg-white text-polri-blue px-4 py-2 rounded-md hover:bg-gray-100 text-center">Masuk</a>
                        <a href="{{ route('register') }}" class="border border-white px-4 py-2 rounded-md hover:bg-polri-red text-center">Daftar</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        @yield('content')

        <!-- Footer -->
        <footer class="bg-polri-blue text-white py-12">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">SIPMAS</h3>
                        <p class="text-gray-300">Sistem Pengaduan Masyarakat Polres Minahasa</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-4">Tautan</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white">Beranda</a></li>
                            <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-white">Tentang</a></li>
                            <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white">Kontak</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-4">Kontak</h3>
                        <ul class="space-y-2 text-gray-300">
                            <li>Jl. Raya Manado - Tomohon</li>
                            <li>Minahasa, Sulawesi Utara</li>
                            <li>Telp: (0431) 123456</li>
                            <li>Email: info@sipmas.minahasa.polri.go.id</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-4">Ikuti Kami</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-300 hover:text-white">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                    <p>&copy; {{ date('Y') }} SIPMAS - Polres Minahasa. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/frontend.js') }}"></script>
    <script>
        // Handle loading state
        window.addEventListener('load', function() {
            const loading = document.getElementById('loading');
            const content = document.querySelector('.content');
            
            setTimeout(() => {
                loading.style.opacity = '0';
                content.classList.add('loaded');
                setTimeout(() => {
                    loading.style.display = 'none';
                }, 300);
            }, 500);
        });

        // Handle mobile menu
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Handle image loading errors
        document.querySelectorAll('img').forEach(img => {
            img.onerror = function() {
                this.src = '{{ asset("img/polres-minahasa.png") }}';
                this.alt = 'Gambar tidak tersedia';
            };
        });
    </script>
    @yield('additional_js')
</body>
</html> 