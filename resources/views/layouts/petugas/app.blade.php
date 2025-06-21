<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPMAS - Petugas')</title>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        .polri-blue { color: #1e40af; }
        .bg-polri-blue { background-color: #1e40af; }
        .border-polri-blue { border-color: #1e40af; }
        .hover\:bg-polri-blue:hover { background-color: #1e40af; }
        .focus\:ring-polri-blue:focus { --tw-ring-color: #1e40af; }
        .focus\:border-polri-blue:focus { border-color: #1e40af; }
    </style>
</head>
<body class="bg-gray-100">
    @include('layouts.admin.partials.sidebar')
    <div class="ml-64 min-h-screen flex flex-col">
        @include('layouts.admin.partials.topbar')
        <main class="flex-1 p-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
        @include('layouts.partials.backend.footer')
    </div>
</body>
</html> 