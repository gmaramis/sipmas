@extends('layouts.petugas.app')

@section('title', 'Daftar Pengaduan - SIPMAS')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Daftar Pengaduan</h1>
            <p class="text-gray-600">Kelola semua pengaduan masyarakat</p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('petugas.complaints') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengaduan..." 
                   class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
        
        <select name="category" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent">
            <option value="">Semua Kategori</option>
            <option value="kriminal" {{ request('category') == 'kriminal' ? 'selected' : '' }}>Kriminal</option>
            <option value="lalu_lintas" {{ request('category') == 'lalu_lintas' ? 'selected' : '' }}>Lalu Lintas</option>
            <option value="narkoba" {{ request('category') == 'narkoba' ? 'selected' : '' }}>Narkoba</option>
            <option value="korupsi" {{ request('category') == 'korupsi' ? 'selected' : '' }}>Korupsi</option>
            <option value="lainnya" {{ request('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select>
        
        <select name="status" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
            <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Diproses</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
        </select>
        
        <select name="assigned" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent">
            <option value="">Semua Penugasan</option>
            <option value="me" {{ request('assigned') == 'me' ? 'selected' : '' }}>Ditugaskan ke Saya</option>
            <option value="unassigned" {{ request('assigned') == 'unassigned' ? 'selected' : '' }}>Belum Ditugaskan</option>
        </select>
        
        <div class="md:col-span-4 flex justify-end space-x-2">
            <button type="submit" class="px-4 py-2 bg-polri-blue text-white rounded-lg hover:bg-blue-700 transition duration-300">
                <i class="fas fa-search mr-2"></i>Filter
            </button>
            <a href="{{ route('petugas.complaints') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Complaints List -->
<div class="bg-white rounded-lg shadow-md">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-800">Daftar Pengaduan</h2>
    </div>
    
    <div class="overflow-x-auto">
        @if($complaints->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petugas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($complaints as $complaint)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $complaint->title }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($complaint->description, 50) }}</div>
                                <div class="text-sm text-gray-400">{{ $complaint->location }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $complaint->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $complaint->user->email }}</div>
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
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($complaint->assignedPetugas)
                                    <div class="text-sm text-gray-900">
                                        {{ $complaint->assignedPetugas->pangkat }} {{ $complaint->assignedPetugas->nama }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $complaint->assignedPetugas->unit_kerja }}</div>
                                @else
                                    <span class="text-sm text-gray-400">Belum ditugaskan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $complaint->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('petugas.complaints.show', $complaint) }}" 
                                   class="text-polri-blue hover:text-blue-700 mr-3" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(!$complaint->assignedPetugas)
                                    <form method="POST" action="{{ route('petugas.complaints.assign', $complaint) }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="action" value="assign">
                                        <button type="submit" class="text-green-600 hover:text-green-900 mr-3" title="Tugaskan ke Saya">
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    </form>
                                @elseif($complaint->assigned_petugas_id == $petugas->id)
                                    <form method="POST" action="{{ route('petugas.complaints.assign', $complaint) }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="action" value="unassign">
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-900 mr-3" title="Batalkan Penugasan">
                                            <i class="fas fa-user-minus"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $complaints->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-clipboard-list text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pengaduan</h3>
                <p class="text-gray-500">Belum ada pengaduan yang sesuai dengan filter yang dipilih.</p>
            </div>
        @endif
    </div>
</div>
@endsection 