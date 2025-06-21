<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="User Dashboard - Sistem Pengaduan Masyarakat Polres Minahasa">
    <meta name="keywords" content="pengaduan, polres, minahasa, sipmas, polri">
    <meta name="author" content="Polres Minahasa">
    <title>@yield('title', 'SIPMAS - User')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/polres-minahasa.png') }}">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .polri-blue { color: #0A1F44; }
        .polri-red { color: #C8102E; }
        .bg-polri-blue { background-color: #0A1F44; }
        .bg-polri-red { background-color: #C8102E; }
        .border-polri-blue { border-color: #0A1F44; }
        .hover\:bg-polri-blue:hover { background-color: #0A1F44; }
        .hover\:bg-polri-red:hover { background-color: #C8102E; }
    </style>
    @yield('additional_css')
</head>
<body class="bg-gray-100">
    @include('layouts.admin.partials.sidebar')
    <div class="ml-64 min-h-screen flex flex-col">
        @include('layouts.admin.partials.topbar')
        <main class="flex-1 p-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Handle notification button
        document.addEventListener('DOMContentLoaded', function() {
            const notificationButton = document.getElementById('notificationButton');
            if (notificationButton) {
                notificationButton.addEventListener('click', function() {
                    // TODO: Implement notification dropdown
                    console.log('Notification clicked');
                });
            }
        });
    </script>
    @yield('additional_js')

    <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit" class="text-sm text-polri-red hover:text-red-700 bg-transparent border-0 p-0 m-0 cursor-pointer">
            Logout
        </button>
    </form>
</body>
</html> 