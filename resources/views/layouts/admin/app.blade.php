<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Panel - Sistem Pengaduan Masyarakat Polres Minahasa">
    <meta name="keywords" content="admin, pengaduan, polres, minahasa, sipmas, polri">
    <meta name="author" content="Polres Minahasa">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - SIPMAS')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/polres-minahasa.png') }}">
    
    <!-- Preload resources -->
    <link rel="preload" href="{{ asset('img/polres-minahasa.png') }}" as="image">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Socket.IO -->
    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
    
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
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Loading state -->
    <div class="loading" id="loading">
        <img src="{{ asset('img/polres-minahasa.png') }}" alt="Loading...">
    </div>

    <!-- Main content -->
    <div class="content">
        <!-- Sidebar -->
        @include('layouts.admin.partials.sidebar')

        <!-- Main Content -->
        <div class="ml-64 min-h-screen flex flex-col">
            <!-- Topbar -->
            @include('layouts.admin.partials.topbar')

            <!-- Page Content -->
            <main class="flex-1 p-8">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('layouts.admin.partials.footer')
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toastNotification" class="toast-notification">
        <div class="toast-content">
            <div class="toast-header">
                <i class="fas fa-bell"></i>
            </div>
            <div class="toast-body">
                <p id="toastMessage" class="toast-message"></p>
                <p id="toastTime" class="toast-time"></p>
            </div>
            <button onclick="closeToast()" class="toast-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/admin.js') }}"></script>
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

        // Inisialisasi Socket.IO
        const socket = io('http://localhost:3000');

        // Variabel untuk menyimpan notifikasi
        let notifications = [];
        let unreadCount = 0;

        // Fungsi untuk menampilkan toast notification
        function showToast(message) {
            const toast = document.getElementById('toastNotification');
            const toastMessage = document.getElementById('toastMessage');
            const toastTime = document.getElementById('toastTime');
            
            toastMessage.textContent = message;
            toastTime.textContent = new Date().toLocaleTimeString();
            
            toast.classList.add('show');
            
            // Otomatis tutup setelah 5 detik
            setTimeout(() => {
                closeToast();
            }, 5000);
        }

        // Fungsi untuk menutup toast
        function closeToast() {
            const toast = document.getElementById('toastNotification');
            toast.classList.remove('show');
        }

        // Fungsi untuk menambahkan notifikasi ke dropdown
        function addNotification(notification) {
            const notificationList = document.getElementById('notificationList');
            const notificationElement = document.createElement('div');
            notificationElement.className = 'notification-item';
            notificationElement.innerHTML = `
                <div class="notification-content">
                    <div class="notification-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="notification-text">
                        <p class="notification-message">${notification.message}</p>
                        <p class="notification-time">${notification.time}</p>
                    </div>
                </div>
            `;
            notificationList.insertBefore(notificationElement, notificationList.firstChild);
        }

        // Event listener untuk tombol notifikasi
        document.addEventListener('DOMContentLoaded', function() {
            const notificationButton = document.getElementById('notificationButton');
            if (notificationButton) {
                notificationButton.addEventListener('click', function() {
                    const dropdown = document.getElementById('notificationDropdown');
                    dropdown.classList.toggle('show');
                });
            }
        });

        // Event listener untuk WebSocket
        socket.on('connect', () => {
            console.log('Terhubung ke server');
            showToast('Terhubung ke server');
        });

        socket.on('disconnect', () => {
            console.log('Terputus dari server');
            showToast('Terputus dari server');
        });

        socket.on('new_complaint', function(data) {
            // Update badge
            unreadCount++;
            const badge = document.getElementById('notificationBadge');
            if (badge) {
                badge.textContent = unreadCount;
                badge.classList.remove('hidden');
            }

            // Tambahkan notifikasi baru
            const notification = {
                message: `Pengaduan baru dari ${data.pelapor} (${data.jenis})`,
                time: new Date().toLocaleTimeString()
            };
            notifications.unshift(notification);
            addNotification(notification);

            // Tampilkan toast
            showToast(`Pengaduan baru dari ${data.pelapor}`);
        });

        // Tutup dropdown ketika klik di luar
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('notificationDropdown');
            const button = document.getElementById('notificationButton');
            if (dropdown && button && !dropdown.contains(event.target) && !button.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Cek status server saat halaman dimuat
        window.addEventListener('load', async () => {
            try {
                const response = await fetch('http://localhost:3000/api/status');
                const data = await response.json();
                if (data.status === 'online') {
                    showToast('Server online');
                }
            } catch (error) {
                console.error('Gagal terhubung ke server:', error);
                showToast('Gagal terhubung ke server');
            }
        });

        // Handle image loading errors
        document.querySelectorAll('img').forEach(img => {
            img.onerror = function() {
                this.src = '{{ asset("img/polres-minahasa.png") }}';
                this.alt = 'Gambar tidak tersedia';
            };
        });
    </script>
    @stack('scripts')
</body>
</html> 