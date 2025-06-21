@extends('layouts.user.app')

@section('title', 'Pengaduan Saya - SIPMAS')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Pengaduan Saya</h1>
            <p class="text-gray-600">Kelola semua pengaduan yang telah Anda ajukan</p>
        </div>
        <a href="{{ route('user.complaints.create') }}" class="bg-polri-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
            <i class="fas fa-plus mr-2"></i>Ajukan Pengaduan Baru
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="relative">
            <input type="text" id="searchInput" placeholder="Cari pengaduan..." 
                   class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
        <select id="categoryFilter" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent">
            <option value="">Semua Kategori</option>
            <option value="kriminal">Kriminal</option>
            <option value="lalu_lintas">Lalu Lintas</option>
            <option value="narkoba">Narkoba</option>
            <option value="korupsi">Korupsi</option>
            <option value="lainnya">Lainnya</option>
        </select>
        <select id="statusFilter" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent">
            <option value="">Semua Status</option>
            <option value="pending">Menunggu</option>
            <option value="processed">Diproses</option>
            <option value="completed">Selesai</option>
            <option value="rejected">Ditolak</option>
        </select>
    </div>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto Bukti</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($complaints as $complaint)
                        <tr class="hover:bg-gray-50 transition-colors duration-200 complaint-row" 
                            data-title="{{ strtolower($complaint->title) }}"
                            data-category="{{ $complaint->category }}"
                            data-status="{{ $complaint->status }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $complaint->title }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($complaint->description, 50) }}</div>
                                <div class="text-sm text-gray-400">{{ $complaint->location }}</div>
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
                                @if($complaint->evidence_photos && count($complaint->evidence_photos) > 0)
                                    <div class="flex space-x-1">
                                        @foreach(array_slice($complaint->evidence_photos, 0, 3) as $index => $photo)
                                            <div class="relative">
                                                <img src="{{ asset('storage/' . $photo) }}" 
                                                     alt="Bukti {{ $index + 1 }}" 
                                                     class="w-8 h-8 rounded object-cover border border-gray-200">
                                                @if($index === 2 && count($complaint->evidence_photos) > 3)
                                                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded flex items-center justify-center">
                                                        <span class="text-white text-xs">+{{ count($complaint->evidence_photos) - 3 }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">{{ count($complaint->evidence_photos) }} foto</p>
                                @else
                                    <span class="text-gray-400 text-sm">Tidak ada foto</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $complaint->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('user.complaints.show', $complaint) }}" 
                                   class="text-polri-blue hover:text-blue-700 mr-3" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($complaint->status === 'pending')
                                    <a href="{{ route('user.complaints.edit', $complaint) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 mr-3" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteComplaint({{ $complaint->id }})" 
                                            class="text-red-600 hover:text-red-900" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $complaints->links() }}
            </div>
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

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Konfirmasi Hapus</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin menghapus pengaduan ini? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300">
                    Batal
                </button>
                <button id="confirmDeleteBtn" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Search and filter functionality
    document.getElementById('searchInput').addEventListener('input', filterComplaints);
    document.getElementById('categoryFilter').addEventListener('change', filterComplaints);
    document.getElementById('statusFilter').addEventListener('change', filterComplaints);
    
    function filterComplaints() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const categoryFilter = document.getElementById('categoryFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;
        
        const rows = document.querySelectorAll('.complaint-row');
        
        rows.forEach(row => {
            const title = row.getAttribute('data-title');
            const category = row.getAttribute('data-category');
            const status = row.getAttribute('data-status');
            
            const matchesSearch = title.includes(searchTerm);
            const matchesCategory = !categoryFilter || category === categoryFilter;
            const matchesStatus = !statusFilter || status === statusFilter;
            
            if (matchesSearch && matchesCategory && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    // Delete functionality
    let complaintToDelete = null;
    
    function deleteComplaint(complaintId) {
        complaintToDelete = complaintId;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        complaintToDelete = null;
    }
    
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (complaintToDelete) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/user/complaints/${complaintToDelete}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    });
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('deleteModal');
        if (event.target == modal) {
            closeDeleteModal();
        }
    }
</script>
@endsection 