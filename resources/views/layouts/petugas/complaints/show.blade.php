@extends('layouts.petugas.app')

@section('title', 'Detail Pengaduan - SIPMAS')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pengaduan</h1>
            <p class="text-gray-600">Informasi lengkap pengaduan masyarakat</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('petugas.complaints') }}" 
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Complaint Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Pengaduan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <p class="text-gray-900">{{ $complaint->title }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                        {{ ucfirst(str_replace('_', ' ', $complaint->category)) }}
                    </span>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <p class="text-gray-900">{{ $complaint->location }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $complaint->status_badge_class }}">
                        {{ $complaint->status_label }}
                    </span>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Diajukan</label>
                    <p class="text-gray-900">{{ $complaint->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                @if($complaint->processed_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Diproses</label>
                        <p class="text-gray-900">{{ $complaint->processed_at->format('d/m/Y H:i') }}</p>
                    </div>
                @endif
                
                @if($complaint->completed_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <p class="text-gray-900">{{ $complaint->completed_at->format('d/m/Y H:i') }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Description -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Deskripsi Kejadian</h2>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $complaint->description }}</p>
            </div>
        </div>
        
        <!-- Evidence Photos -->
        @if($complaint->evidence_photos && count($complaint->evidence_photos) > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Foto Bukti Kejadian</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4" id="photoGallery">
                    @foreach($complaint->evidence_photos as $index => $photo)
                        <div class="relative group cursor-pointer" onclick="openPhotoModal({{ $index }})">
                            <img src="{{ asset('storage/' . $photo) }}" 
                                 alt="Bukti {{ $index + 1 }}" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200 group-hover:border-polri-blue transition duration-200">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition duration-200 flex items-center justify-center">
                                <span class="text-white text-xs opacity-0 group-hover:opacity-100 transition duration-200">Foto {{ $index + 1 }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-sm text-gray-500 mt-4">
                    <i class="fas fa-info-circle mr-1"></i>
                    Klik foto untuk melihat dalam ukuran penuh
                </p>
            </div>
        @endif
        
        <!-- Admin Response -->
        @if($complaint->admin_response)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Respon Admin</h2>
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $complaint->admin_response }}</p>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Reporter Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Pelapor</h2>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <p class="text-gray-900">{{ $complaint->user->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <p class="text-gray-900">{{ $complaint->user->email }}</p>
                </div>
                @if($complaint->user->phone)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                        <p class="text-gray-900">{{ $complaint->user->phone }}</p>
                    </div>
                @endif
                @if($complaint->user->address)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <p class="text-gray-900">{{ $complaint->user->address }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Assignment Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Penugasan</h2>
            @if($complaint->assignedPetugas)
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Petugas</label>
                        <p class="text-gray-900">{{ $complaint->assignedPetugas->pangkat }} {{ $complaint->assignedPetugas->nama }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unit Kerja</label>
                        <p class="text-gray-900">{{ $complaint->assignedPetugas->unit_kerja }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                        <p class="text-gray-900">{{ $complaint->assignedPetugas->jabatan }}</p>
                    </div>
                    
                    @if($complaint->assigned_petugas_id == $petugas->id)
                        <form method="POST" action="{{ route('petugas.complaints.assign', $complaint) }}" class="mt-4">
                            @csrf
                            <input type="hidden" name="action" value="unassign">
                            <button type="submit" class="w-full px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition duration-300">
                                <i class="fas fa-user-minus mr-2"></i>Batalkan Penugasan
                            </button>
                        </form>
                    @endif
                </div>
            @else
                <p class="text-gray-500 mb-4">Belum ditugaskan</p>
                <form method="POST" action="{{ route('petugas.complaints.assign', $complaint) }}">
                    @csrf
                    <input type="hidden" name="action" value="assign">
                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                        <i class="fas fa-user-plus mr-2"></i>Tugaskan ke Saya
                    </button>
                </form>
            @endif
        </div>
        
        <!-- Status Update -->
        @if($complaint->assigned_petugas_id == $petugas->id)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Update Status</h2>
                <form method="POST" action="{{ route('petugas.complaints.update-status', $complaint) }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" name="status" 
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent">
                                <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="processed" {{ $complaint->status == 'processed' ? 'selected' : '' }}>Diproses</option>
                                <option value="completed" {{ $complaint->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="admin_response" class="block text-sm font-medium text-gray-700 mb-1">Respon (Opsional)</label>
                            <textarea id="admin_response" name="admin_response" rows="4" 
                                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent"
                                      placeholder="Berikan respon atau catatan untuk pengaduan ini...">{{ $complaint->admin_response }}</textarea>
                        </div>
                        
                        <button type="submit" class="w-full px-4 py-2 bg-polri-blue text-white rounded-lg hover:bg-blue-700 transition duration-300">
                            <i class="fas fa-save mr-2"></i>Update Status
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>

<!-- Photo Modal -->
<div id="photoModal" class="fixed inset-0 bg-black bg-opacity-75 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Foto Bukti</h3>
            <button onclick="closePhotoModal()" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="relative">
            <img id="modalPhoto" src="" alt="" class="w-full h-auto rounded-lg">
            <button onclick="previousPhoto()" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button onclick="nextPhoto()" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        <div class="mt-4 text-center">
            <span id="photoCounter" class="text-sm text-gray-500"></span>
        </div>
    </div>
</div>

<script>
    const photos = @json($complaint->evidence_photo_urls ?? []);
    let currentPhotoIndex = 0;
    
    function openPhotoModal(index) {
        currentPhotoIndex = index;
        updateModalPhoto();
        document.getElementById('photoModal').classList.remove('hidden');
    }
    
    function closePhotoModal() {
        document.getElementById('photoModal').classList.add('hidden');
    }
    
    function previousPhoto() {
        if (photos.length > 1) {
            currentPhotoIndex = (currentPhotoIndex - 1 + photos.length) % photos.length;
            updateModalPhoto();
        }
    }
    
    function nextPhoto() {
        if (photos.length > 1) {
            currentPhotoIndex = (currentPhotoIndex + 1) % photos.length;
            updateModalPhoto();
        }
    }
    
    function updateModalPhoto() {
        const modalPhoto = document.getElementById('modalPhoto');
        const photoCounter = document.getElementById('photoCounter');
        
        modalPhoto.src = photos[currentPhotoIndex];
        photoCounter.textContent = `${currentPhotoIndex + 1} dari ${photos.length}`;
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('photoModal');
        if (event.target == modal) {
            closePhotoModal();
        }
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', function(event) {
        if (document.getElementById('photoModal').classList.contains('hidden')) return;
        
        if (event.key === 'Escape') {
            closePhotoModal();
        } else if (event.key === 'ArrowLeft') {
            previousPhoto();
        } else if (event.key === 'ArrowRight') {
            nextPhoto();
        }
    });
</script>
@endsection 