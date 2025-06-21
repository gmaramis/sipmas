@extends('layouts.petugas.app')

@section('title', 'Statistik - SIPMAS')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Statistik Pengaduan</h1>
    <p class="text-gray-600">Analisis data pengaduan masyarakat</p>
</div>

<!-- Overall Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-clipboard-list text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Pengaduan</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalComplaints }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Menunggu</p>
                <p class="text-2xl font-bold text-gray-900">{{ $pendingComplaints }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-cogs text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Diproses</p>
                <p class="text-2xl font-bold text-gray-900">{{ $processedComplaints }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Selesai</p>
                <p class="text-2xl font-bold text-gray-900">{{ $completedComplaints }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-600">
                <i class="fas fa-times-circle text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Ditolak</p>
                <p class="text-2xl font-bold text-gray-900">{{ $rejectedComplaints }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Personal Statistics -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-user-shield text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Ditugaskan ke Saya</p>
                <p class="text-2xl font-bold text-gray-900">{{ $assignedToMe }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Menunggu (Saya)</p>
                <p class="text-2xl font-bold text-gray-900">{{ $pendingAssigned }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-cogs text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Diproses (Saya)</p>
                <p class="text-2xl font-bold text-gray-900">{{ $processedAssigned }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Selesai (Saya)</p>
                <p class="text-2xl font-bold text-gray-900">{{ $completedAssigned }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Category Statistics -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Statistik Kategori</h2>
        <div class="space-y-4">
            @foreach($categoryStats as $category)
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">
                        {{ ucfirst(str_replace('_', ' ', $category->category)) }}
                    </span>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-polri-blue h-2 rounded-full" style="width: {{ ($category->count / $totalComplaints) * 100 }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $category->count }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Monthly Statistics -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Statistik Bulanan ({{ date('Y') }})</h2>
        <div class="space-y-4">
            @php
                $months = [
                    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                    7 => 'Jul', 8 => 'Ags', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                ];
                $maxCount = $monthlyStats->max('count') ?: 1;
            @endphp
            
            @foreach($months as $monthNum => $monthName)
                @php
                    $monthData = $monthlyStats->where('month', $monthNum)->first();
                    $count = $monthData ? $monthData->count : 0;
                @endphp
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700 w-12">{{ $monthName }}</span>
                    <div class="flex items-center flex-1">
                        <div class="w-full bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($count / $maxCount) * 100 }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 w-8 text-right">{{ $count }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="mt-8 bg-white rounded-lg shadow-md">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-800">Aktivitas Terbaru</h2>
    </div>
    <div class="p-6">
        @if($recentActivity->count() > 0)
            <div class="space-y-4">
                @foreach($recentActivity as $complaint)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-medium text-gray-900">{{ $complaint->title }}</h3>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $complaint->status_badge_class }}">
                                {{ $complaint->status_label }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">{{ Str::limit($complaint->description, 100) }}</p>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>{{ $complaint->user->name }}</span>
                            <span>{{ $complaint->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="mt-2">
                            <span class="text-xs text-gray-500">
                                @if($complaint->assignedPetugas)
                                    <i class="fas fa-user-shield mr-1"></i>
                                    {{ $complaint->assignedPetugas->pangkat }} {{ $complaint->assignedPetugas->nama }}
                                @else
                                    <i class="fas fa-user-clock mr-1"></i>
                                    Belum ditugaskan
                                @endif
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-chart-bar text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-500">Belum ada aktivitas</p>
            </div>
        @endif
    </div>
</div>
@endsection 