@extends('layouts.admin.app')

@section('title', 'Pengaduan - Admin SIPMAS')

@section('content')
    <!-- Filter dan Pencarian -->
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-polri-blue focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="pending">Menunggu</option>
                        <option value="process">Diproses</option>
                        <option value="completed">Selesai</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-polri-blue focus:border-transparent">
                        <option value="">Semua Kategori</option>
                        <option value="kriminal">Kriminal</option>
                        <option value="lalu-lintas">Lalu Lintas</option>
                        <option value="narkoba">Narkoba</option>
                        <option value="korupsi">Korupsi</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-polri-blue focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                    <div class="relative">
                        <input type="text" placeholder="Cari pengaduan..." class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-polri-blue focus:border-transparent">
                        <button class="absolute right-2 top-2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Pengaduan -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Daftar Pengaduan</h2>
                <button class="bg-polri-blue text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200" onclick="exportData()">
                    <i class="fas fa-download mr-2"></i>
                    Export
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petugas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($complaints as $complaint)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $complaint->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $complaint->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $complaint->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $complaint->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $complaint->category }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $complaint->status_badge_class }}">
                                    {{ $complaint->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $complaint->assignedPetugas->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="viewDetail({{ $complaint->id }})" class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($complaint->status === 'pending')
                                    <button onclick="processComplaint({{ $complaint->id }})" class="text-green-600 hover:text-green-900" title="Proses Pengaduan">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button onclick="rejectComplaint({{ $complaint->id }})" class="text-red-600 hover:text-red-900" title="Tolak Pengaduan">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @elseif($complaint->status === 'processed')
                                    <button onclick="completeComplaint({{ $complaint->id }})" class="text-green-600 hover:text-green-900" title="Selesaikan">
                                        <i class="fas fa-check-double"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada pengaduan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    <span>Menampilkan 1-10 dari 50 pengaduan</span>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        <i class="fas fa-chevron-left mr-1"></i>
                        Sebelumnya
                    </button>
                    <div class="flex space-x-1">
                        <button class="px-3 py-2 text-sm font-medium text-white bg-polri-blue border border-polri-blue rounded-md">1</button>
                        <button class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">2</button>
                        <button class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">3</button>
                        <span class="px-3 py-2 text-sm text-gray-500">...</span>
                        <button class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">5</button>
                    </div>
                    <button class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Selanjutnya
                        <i class="fas fa-chevron-right ml-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Status Update -->
    <div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 id="modalTitle" class="text-lg font-medium text-gray-900">Update Status Pengaduan</h3>
                    <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="statusForm">
                    <div class="mb-4">
                        <label for="statusSelect" class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                        <select id="statusSelect" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-polri-blue focus:border-transparent" required>
                            <option value="">Pilih Status</option>
                            <option value="process">Diproses</option>
                            <option value="completed">Selesai</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="statusNote" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                        <textarea id="statusNote" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-polri-blue focus:border-transparent" rows="3" placeholder="Tambahkan catatan (opsional)"></textarea>
                    </div>
                </form>
                <div class="flex justify-end space-x-3">
                    <button onclick="closeStatusModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300">Batal</button>
                    <button onclick="updateStatus()" class="px-4 py-2 text-sm font-medium text-white bg-polri-blue border border-transparent rounded-md hover:bg-blue-700">Update Status</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let currentComplaintId = null;

    function viewDetail(id) {
        window.location.href = `/admin/pengaduan/${id}`;
    }

    function processComplaint(id) {
        currentComplaintId = id;
        document.getElementById('modalTitle').textContent = 'Proses Pengaduan';
        document.getElementById('statusSelect').value = 'process';
        document.getElementById('statusModal').classList.remove('hidden');
    }

    function completeComplaint(id) {
        currentComplaintId = id;
        document.getElementById('modalTitle').textContent = 'Selesaikan Pengaduan';
        document.getElementById('statusSelect').value = 'completed';
        document.getElementById('statusModal').classList.remove('hidden');
    }

    function rejectComplaint(id) {
        currentComplaintId = id;
        document.getElementById('modalTitle').textContent = 'Tolak Pengaduan';
        document.getElementById('statusSelect').value = 'rejected';
        document.getElementById('statusModal').classList.remove('hidden');
    }

    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
        document.getElementById('statusForm').reset();
        currentComplaintId = null;
    }

    function updateStatus() {
        const status = document.getElementById('statusSelect').value;
        const note = document.getElementById('statusNote').value;

        if (!status) {
            alert('Pilih status terlebih dahulu');
            return;
        }

        // Simulasi update status
        console.log(`Update status pengaduan ${currentComplaintId} menjadi ${status}`);
        console.log(`Catatan: ${note}`);

        // Tutup modal
        closeStatusModal();

        // Refresh halaman atau update UI
        showToast('Status pengaduan berhasil diperbarui');
    }

    function exportData() {
        // Simulasi export data
        console.log('Exporting data...');
        showToast('Data berhasil diexport');
    }
</script>
@endpush 