@extends('layouts.admin.app')

@section('title', 'Dashboard - Admin SIPMAS')

@section('content')
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <!-- Total Pengaduan -->
        <div class="stat-card stat-card-blue">
            <div class="stat-content">
                <div class="stat-info">
                    <p class="stat-label">Total Pengaduan</p>
                    <h3 class="stat-value">{{ number_format($totalComplaints) }}</h3>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
            </div>
            <div class="stat-footer">
                <span class="stat-growth {{ $growthPercentage >= 0 ? 'positive' : 'negative' }}">
                    {{ $growthPercentage >= 0 ? '+' : '' }}{{ number_format($growthPercentage, 1) }}%
                </span>
                <span class="stat-period">dari bulan lalu</span>
            </div>
        </div>

        <!-- Pengaduan Selesai -->
        <div class="stat-card stat-card-green">
            <div class="stat-content">
                <div class="stat-info">
                    <p class="stat-label">Pengaduan Selesai</p>
                    <h3 class="stat-value">{{ number_format($completedComplaints) }}</h3>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="stat-footer">
                <span class="stat-completion">{{ number_format($completionRate, 1) }}% selesai</span>
            </div>
        </div>

        <!-- Pengaduan Diproses -->
        <div class="stat-card stat-card-yellow">
            <div class="stat-content">
                <div class="stat-info">
                    <p class="stat-label">Sedang Diproses</p>
                    <h3 class="stat-value">{{ number_format($processingComplaints) }}</h3>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="stat-footer">
                <span class="stat-info">Perlu tindak lanjut</span>
            </div>
        </div>

        <!-- Rata-rata Waktu Respon -->
        <div class="stat-card stat-card-purple">
            <div class="stat-content">
                <div class="stat-info">
                    <p class="stat-label">Rata-rata Respon</p>
                    <h3 class="stat-value">{{ number_format($averageResponseTime, 1) }} jam</h3>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-stopwatch"></i>
                </div>
            </div>
            <div class="stat-footer">
                <span class="stat-info">Waktu pemrosesan</span>
            </div>
        </div>
    </div>

    <!-- Recent Complaints -->
    <div class="mt-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Pengaduan Terbaru</h2>
            <a href="{{ route('admin.pengaduan') }}" class="text-blue-600 hover:text-blue-800">
                Lihat Semua
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pelapor
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Judul
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Petugas
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentComplaints as $complaint)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $complaint->user->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $complaint->title }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($complaint->description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($complaint->status == 'completed') bg-green-100 text-green-800
                                    @elseif($complaint->status == 'processed') bg-blue-100 text-blue-800
                                    @elseif($complaint->status == 'rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($complaint->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $complaint->assignedPetugas->nama ?? 'Belum ditugaskan' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $complaint->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.pengaduan.show', $complaint->id) }}" 
                                   class="text-blue-600 hover:text-blue-900">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada pengaduan terbaru
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Charts -->
    <div class="charts-grid">
        <div class="card">
            <div class="card-header">
                <h3>Statistik Pengaduan Bulanan</h3>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" width="400" height="200"></canvas>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>Jenis Pengaduan</h3>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .card {
        @apply bg-white rounded-lg shadow-md;
    }

    .card-header {
        @apply px-6 py-4 border-b border-gray-200;
    }

    .card-header h3 {
        @apply text-lg font-semibold text-gray-800;
    }

    .card-body {
        @apply p-6;
    }

    .stat-card {
        @apply bg-white rounded-lg shadow-md p-6;
    }

    .stat-content {
        @apply flex justify-between items-start;
    }

    .stat-info {
        @apply flex-grow;
    }

    .stat-label {
        @apply text-gray-600 text-sm font-medium mb-1;
    }

    .stat-value {
        @apply text-2xl font-bold text-gray-900;
    }

    .stat-icon {
        @apply p-3 rounded-full text-2xl;
    }

    .stat-footer {
        @apply mt-4 text-sm;
    }

    .stat-growth {
        @apply font-medium;
    }

    .stat-growth.positive {
        @apply text-green-600;
    }

    .stat-growth.negative {
        @apply text-red-600;
    }

    .stat-period {
        @apply text-gray-500 ml-1;
    }

    .stat-completion {
        @apply text-green-600 font-medium;
    }

    .stat-card-blue .stat-icon {
        @apply bg-blue-100 text-blue-600;
    }

    .stat-card-green .stat-icon {
        @apply bg-green-100 text-green-600;
    }

    .stat-card-yellow .stat-icon {
        @apply bg-yellow-100 text-yellow-600;
    }

    .stat-card-purple .stat-icon {
        @apply bg-purple-100 text-purple-600;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Statistics Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = @json($monthlyStats);
    
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: Object.keys(monthlyData),
            datasets: [{
                label: 'Jumlah Pengaduan',
                data: Object.values(monthlyData),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Category Statistics Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryData = @json($categoryStats);
    
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(categoryData),
            datasets: [{
                data: Object.values(categoryData),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(236, 72, 153, 0.8)'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endpush 