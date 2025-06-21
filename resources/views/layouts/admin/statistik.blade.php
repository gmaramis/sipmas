@extends('layouts.admin.app')

@section('title', 'Statistik - SIPMAS')

@section('content')
<div class="p-8">
    <!-- Top Navigation -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Statistik</h1>
            <p class="text-gray-600">Analisis data pengaduan</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <button id="notificationButton" class="bg-white p-2 rounded-lg shadow-md hover:bg-gray-50 relative transition-colors duration-200">
                    <i class="fas fa-bell text-gray-600"></i>
                    <span class="absolute -top-1 -right-1 bg-polri-red text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                </button>
            </div>
            <select class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent shadow-md">
                <option value="week">Minggu Ini</option>
                <option value="month">Bulan Ini</option>
                <option value="year">Tahun Ini</option>
            </select>
            <button class="bg-polri-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 shadow-md">
                <i class="fas fa-download mr-2"></i>Export Data
            </button>
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 rounded-full bg-polri-blue flex items-center justify-center text-white shadow-md">
                    <i class="fas fa-user"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-800 font-medium">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-polri-red hover:text-red-700">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500">Total Pengaduan</p>
                    <p class="text-2xl font-bold">{{ $totalComplaints }}</p>
                    <p class="text-sm {{ $complaintGrowth >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        {{ $complaintGrowth >= 0 ? '+' : '' }}{{ number_format($complaintGrowth, 1) }}% dari bulan lalu
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500">Selesai</p>
                    <p class="text-2xl font-bold">{{ $completedComplaints }}</p>
                    <p class="text-sm text-green-500">
                        {{ $totalComplaints > 0 ? number_format(($completedComplaints / $totalComplaints) * 100, 1) : 0 }}% tingkat penyelesaian
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500">Dalam Proses</p>
                    <p class="text-2xl font-bold">{{ $processedComplaints }}</p>
                    <p class="text-sm text-yellow-500">Sedang ditangani</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-500">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500">Total Pengguna</p>
                    <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                    <p class="text-sm text-blue-500">{{ $totalPetugas }} petugas aktif</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Trend Pengaduan -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Trend Pengaduan</h2>
            <canvas id="trendChart" height="300"></canvas>
        </div>
        <!-- Jenis Pengaduan -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Jenis Pengaduan</h2>
            <canvas id="typeChart" height="300"></canvas>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Lokasi Pengaduan -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Lokasi Pengaduan</h2>
            <canvas id="locationChart" height="300"></canvas>
        </div>
        <!-- Waktu Respon -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Waktu Respon</h2>
            <canvas id="responseChart" height="300"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data untuk grafik trend pengaduan
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const monthlyData = @json($monthlyStats);
    const trendData = {
        labels: monthlyData.map(item => monthNames[item.month - 1]),
        datasets: [{
            label: 'Pengaduan',
            data: monthlyData.map(item => item.count),
            borderColor: '#0A1F44',
            tension: 0.1
        }]
    };

    // Data untuk grafik jenis pengaduan
    const categoryData = @json($categoryStats);
    const typeData = {
        labels: categoryData.map(item => item.category.replace('_', ' ').toUpperCase()),
        datasets: [{
            data: categoryData.map(item => item.count),
            backgroundColor: ['#0A1F44', '#C8102E', '#4CAF50', '#FFC107', '#9C27B0']
        }]
    };

    // Data untuk grafik lokasi
    const locationData = @json($locationStats);
    const locationChartData = {
        labels: locationData.map(item => item.location),
        datasets: [{
            data: locationData.map(item => item.count),
            backgroundColor: ['#0A1F44', '#C8102E', '#4CAF50', '#FFC107', '#9C27B0']
        }]
    };

    // Data untuk grafik waktu respon
    const responseData = @json($responseTimeStats);
    const responseChartData = {
        labels: responseData.map(item => item.response_time),
        datasets: [{
            label: 'Jumlah Kasus',
            data: responseData.map(item => item.count),
            backgroundColor: '#0A1F44'
        }]
    };

    // Konfigurasi grafik
    const trendChart = new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: trendData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    const typeChart = new Chart(document.getElementById('typeChart'), {
        type: 'pie',
        data: typeData,
        options: {
            responsive: true
        }
    });

    const locationChart = new Chart(document.getElementById('locationChart'), {
        type: 'pie',
        data: locationChartData,
        options: {
            responsive: true
        }
    });

    const responseChart = new Chart(document.getElementById('responseChart'), {
        type: 'bar',
        data: responseChartData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Event listener untuk filter periode
    document.querySelector('select').addEventListener('change', function() {
        // Implementasi logika filter periode
        console.log('Period changed:', this.value);
    });
</script>
@endsection 