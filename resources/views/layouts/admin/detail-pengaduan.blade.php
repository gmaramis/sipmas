@extends('layouts.admin.app')
@section('title', 'Detail Pengaduan - Admin SIPMAS')
@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pengaduan</h1>
            <p class="text-gray-600">Informasi lengkap pengaduan #{{ $complaint->id }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.pengaduan') }}" 
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Status Card -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Status Pengaduan</h2>
                    <p class="text-gray-600">ID: #{{ $complaint->id }}</p>
                </div>
                <span class="px-4 py-2 {{ $complaint->status_badge_class }} rounded-full font-medium">
                    {{ $complaint->status_label }}
                </span>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600">Progress</span>
                        <span class="text-sm font-medium text-gray-800">
                            @switch($complaint->status)
                                @case('pending')
                                    25%
                                    @break
                                @case('processed')
                                    50%
                                    @break
                                @case('completed')
                                    100%
                                    @break
                                @default
                                    0%
                            @endswitch
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full 
                            @switch($complaint->status)
                                @case('pending')
                                    bg-yellow-500 w-1/4
                                    @break
                                @case('processed')
                                    bg-blue-500 w-1/2
                                    @break
                                @case('completed')
                                    bg-green-500 w-full
                                    @break
                                @default
                                    bg-red-500 w-0
                            @endswitch
                        "></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Complaint Details -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Pengaduan</h2>
            <div class="space-y-6">
                <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
                    <h3 class="text-lg font-semibold text-blue-700 mb-2">Judul Pengaduan</h3>
                    <p class="text-blue-800 font-medium">{{ $complaint->title }}</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
                    <h3 class="text-lg font-semibold text-green-700 mb-2">Deskripsi</h3>
                    <p class="text-green-800">{{ $complaint->description }}</p>
                </div>
                <div class="bg-purple-50 rounded-lg p-4 border-l-4 border-purple-500">
                    <h3 class="text-lg font-semibold text-purple-700 mb-2">Lokasi</h3>
                    <p class="text-purple-800 font-medium">{{ $complaint->location }}</p>
                </div>
                @if($complaint->attachments)
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Bukti Pendukung</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach(json_decode($complaint->attachments) as $attachment)
                            <img src="{{ asset('storage/' . $attachment) }}" 
                                 alt="Bukti Pengaduan" 
                                 class="w-full h-48 object-cover rounded-lg">
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Timeline Pengaduan</h2>
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-800">Pengaduan Diterima</p>
                        <p class="text-sm text-gray-600">{{ $complaint->created_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
                @if($complaint->processed_at)
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-shield text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-800">Diproses</p>
                        <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($complaint->processed_at)->format('d F Y, H:i') }}</p>
                        @if($complaint->assignedPetugas)
                        <p class="text-sm text-gray-600">Petugas: {{ $complaint->assignedPetugas->name }}</p>
                        @endif
                    </div>
                </div>
                @endif
                @if($complaint->completed_at)
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-double text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-800">Selesai</p>
                        <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($complaint->completed_at)->format('d F Y, H:i') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Informasi Petugas Penanganan -->
        @if($complaint->assignedPetugas)
        <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500 mb-6">
            <h3 class="text-lg font-semibold text-blue-700 mb-2">Petugas Penanganan</h3>
            <p class="text-blue-800 font-medium">{{ $complaint->assignedPetugas->nama }}</p>
            <p class="text-blue-700 text-sm">Pangkat: {{ $complaint->assignedPetugas->pangkat }}</p>
            <p class="text-blue-700 text-sm">No. HP: {{ $complaint->assignedPetugas->no_hp }}</p>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Reporter Info -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Pelapor</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600">Nama</p>
                    <p class="font-medium text-gray-800">{{ $complaint->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-medium text-gray-800">{{ $complaint->user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">No. Telepon</p>
                    <p class="font-medium text-gray-800">{{ $complaint->user->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Alamat</p>
                    <p class="font-medium text-gray-800">{{ $complaint->user->address ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Tindakan</h2>
            <div class="space-y-3">
                @if($complaint->status === 'pending')
                <button onclick="openStatusModal('processed')"
                        class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-check mr-2"></i>Proses Pengaduan
                </button>
                <button onclick="openStatusModal('rejected')"
                        class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300">
                    <i class="fas fa-times mr-2"></i>Tolak Pengaduan
                </button>
                @elseif($complaint->status === 'processed')
                <button onclick="openStatusModal('completed')"
                        class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                    <i class="fas fa-check-double mr-2"></i>Selesaikan Pengaduan
                </button>
                @endif
            </div>
        </div>

        <!-- Notes -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Catatan Admin</h2>
            <div class="space-y-4">
                @if($complaint->admin_response)
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Admin</p>
                        <p class="text-sm text-gray-600">{{ $complaint->admin_response }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $complaint->updated_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
                @endif
            </div>
            <form action="{{ route('admin.pengaduan.update-status', $complaint->id) }}" method="POST" class="mt-4">
                @csrf
                @method('PUT')
                <textarea name="admin_response" 
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                          rows="3" 
                          placeholder="Tambah catatan..."></textarea>
                <button type="submit" 
                        class="mt-2 w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    Kirim Catatan
                </button>
            </form>
        </div>

        @if(in_array($complaint->status, ['pending','processed']))
            <div class="mt-4">
                <button onclick="openAssignPetugasModal()" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-300">
                    <i class="fas fa-user-shield mr-2"></i>Ganti Petugas
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-bold text-gray-800 mb-4" id="modalTitle">Update Status Pengaduan</h3>
            <form id="statusForm" action="{{ route('admin.pengaduan.update-status', $complaint->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" id="modalStatus">
                <div id="petugasSelectWrapper" style="display:none;">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Petugas Penanganan</label>
                    <select name="petugas_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Petugas</option>
                        @foreach($petugas as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <textarea name="admin_response" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="3" placeholder="Tambahkan catatan (opsional)"></textarea>
                </div>
                <div class="flex justify-end space-x-3 mt-4">
                    <button type="button" onclick="closeStatusModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ganti Petugas -->
<div id="assignPetugasModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white min-h-[200px] max-h-screen overflow-y-auto">
        <div class="mt-3">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Ganti Petugas Penanganan</h3>
            <form action="{{ route('admin.pengaduan.assign-petugas', $complaint->id) }}" method="POST">
                @csrf
                @method('PUT')
                <label for="petugas_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Petugas Baru</label>
                <select id="petugas_id" name="petugas_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="">Pilih Petugas</option>
                    @foreach($petugas as $p)
                        <option value="{{ $p->id }}" @if($complaint->assigned_petugas_id == $p->id) selected @endif>{{ $p->nama }}</option>
                    @endforeach
                </select>
                <div class="flex justify-end space-x-3 mt-4">
                    <button type="button" onclick="closeAssignPetugasModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border rounded-md hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-bold rounded-md bg-green-600 text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openStatusModal(status) {
        console.log('openStatusModal terpanggil dengan status:', status);
        document.getElementById('statusModal').classList.remove('hidden');
        document.getElementById('modalStatus').value = status;
        document.getElementById('modalTitle').textContent =
            status === 'processed' ? 'Proses Pengaduan' :
            status === 'rejected' ? 'Tolak Pengaduan' :
            status === 'completed' ? 'Selesaikan Pengaduan' : 'Update Status Pengaduan';
        // Tampilkan select petugas hanya jika status processed
        document.getElementById('petugasSelectWrapper').style.display = (status === 'processed') ? 'block' : 'none';
    }
    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
        document.getElementById('statusForm').reset();
    }
    function openAssignPetugasModal() {
        document.getElementById('assignPetugasModal').classList.remove('hidden');
    }
    function closeAssignPetugasModal() {
        document.getElementById('assignPetugasModal').classList.add('hidden');
    }
</script>
@endpush