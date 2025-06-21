@extends('layouts.user.app')

@section('title', 'Dashboard - SIPMAS')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-600">Selamat datang, {{ $user->name }}!</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <i class="fas fa-exclamation-circle text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500">Total Pengaduan</p>
                <p class="text-2xl font-bold">{{ $totalComplaints }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500">Menunggu</p>
                <p class="text-2xl font-bold">{{ $pendingComplaints }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <i class="fas fa-cogs text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500">Diproses</p>
                <p class="text-2xl font-bold">{{ $processedComplaints }}</p>
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
            </div>
        </div>
    </div>
</div>

<!-- Recent Complaints -->
<div class="bg-white rounded-lg shadow-md">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Pengaduan Terbaru</h2>
            <a href="{{ route('user.complaints.index') }}" class="text-polri-blue hover:text-blue-700 text-sm font-medium">
                Lihat Semua
            </a>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        @if($complaints->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($complaints->take(5) as $complaint)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $complaint->title }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($complaint->description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ ucfirst(str_replace('_', ' ', $complaint->category)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $complaint->status_badge_class }}">
                                    {{ $complaint->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $complaint->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('user.complaints.show', $complaint) }}" class="text-polri-blue hover:text-blue-700 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($complaint->status === 'pending')
                                    <a href="{{ route('user.complaints.edit', $complaint) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center py-12">
                <i class="fas fa-exclamation-circle text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pengaduan</h3>
                <p class="text-gray-500 mb-4">Anda belum mengajukan pengaduan apapun.</p>
                <a href="{{ route('user.complaints.create') }}" class="bg-polri-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-plus mr-2"></i>Ajukan Pengaduan Pertama
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>
        <div class="space-y-3">
            <a href="{{ route('user.complaints.create') }}" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                <i class="fas fa-plus text-blue-500 mr-3"></i>
                <span class="text-blue-700 font-medium">Ajukan Pengaduan Baru</span>
            </a>
            <a href="{{ route('user.complaints.index') }}" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                <i class="fas fa-list text-green-500 mr-3"></i>
                <span class="text-green-700 font-medium">Lihat Semua Pengaduan</span>
            </a>
            <a href="{{ route('user.profile') }}" class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition duration-200">
                <i class="fas fa-user text-purple-500 mr-3"></i>
                <span class="text-purple-700 font-medium">Update Profil</span>
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi</h3>
        <div class="space-y-3 text-sm text-gray-600">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 mr-2 mt-1"></i>
                <p>Pengaduan akan diproses dalam waktu 1-3 hari kerja</p>
            </div>
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 mr-2 mt-1"></i>
                <p>Pastikan melampirkan foto bukti yang jelas</p>
            </div>
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 mr-2 mt-1"></i>
                <p>Anda dapat mengedit pengaduan yang masih dalam status "Menunggu"</p>
            </div>
        </div>
    </div>
</div>
@endsection 