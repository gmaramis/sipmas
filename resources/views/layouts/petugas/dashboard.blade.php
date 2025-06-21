@extends('layouts.petugas.app')

@section('title', 'Dashboard Petugas - SIPMAS')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8 pt-16">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Petugas</h1>
        <p class="text-gray-600">Selamat datang, {{ $user->name }}!</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Assigned -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-clipboard-list text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Ditugaskan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalAssigned }}</p>
                </div>
            </div>
        </div>
        
        <!-- Pending -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Menunggu</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingAssigned }}</p>
                </div>
            </div>
        </div>
        
        <!-- Processed -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-cogs text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Diproses</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $processedAssigned }}</p>
                </div>
            </div>
        </div>
        
        <!-- Completed -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $completedAssigned }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Assigned Complaints -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Pengaduan yang Ditugaskan</h2>
            </div>
            <div class="p-6">
                @if($assignedComplaints->count() > 0)
                    <div class="space-y-4">
                        @foreach($assignedComplaints as $complaint)
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
                                <div class="mt-3">
                                    <a href="{{ route('petugas.complaints.show', $complaint) }}" 
                                       class="text-sm text-polri-blue hover:text-blue-700">
                                        Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($totalAssigned > 5)
                        <div class="mt-4 text-center">
                            <a href="{{ route('petugas.complaints') }}" 
                               class="text-sm text-polri-blue hover:text-blue-700">
                                Lihat Semua Pengaduan <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-clipboard-list text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">Belum ada pengaduan yang ditugaskan</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Recent Complaints -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Pengaduan Terbaru</h2>
            </div>
            <div class="p-6">
                @if($recentComplaints->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentComplaints as $complaint)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-medium text-gray-900">{{ $complaint->title }}</h3>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $complaint->status_badge_class }}">
                                        {{ $complaint->status_label }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($complaint->description, 100) }}</p>
                                <div class="flex justify-between items-center text-xs text-gray-500 mb-2">
                                    <span>{{ $complaint->user->name }}</span>
                                    <span>{{ $complaint->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">
                                        @if($complaint->assignedPetugas)
                                            <i class="fas fa-user-shield mr-1"></i>
                                            {{ $complaint->assignedPetugas->pangkat }} {{ $complaint->assignedPetugas->nama }}
                                        @else
                                            <i class="fas fa-user-clock mr-1"></i>
                                            Belum ditugaskan
                                        @endif
                                    </span>
                                    <a href="{{ route('petugas.complaints.show', $complaint) }}" 
                                       class="text-sm text-polri-blue hover:text-blue-700">
                                        Detail <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-clipboard-list text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">Belum ada pengaduan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('petugas.complaints') }}" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-clipboard-list text-xl"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">Lihat Semua Pengaduan</h3>
                    <p class="text-sm text-gray-600">Kelola semua pengaduan</p>
                </div>
            </a>
            
            <a href="{{ route('petugas.complaints') }}?assigned=unassigned" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="fas fa-user-plus text-xl"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">Pengaduan Belum Ditugaskan</h3>
                    <p class="text-sm text-gray-600">Lihat pengaduan yang belum ditugaskan</p>
                </div>
            </a>
            
            <a href="{{ route('petugas.statistics') }}" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-chart-bar text-xl"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">Statistik</h3>
                    <p class="text-sm text-gray-600">Lihat statistik pengaduan</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection 