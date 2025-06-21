@extends('layouts.user.app')

@section('title', 'Detail Pengaduan - SIPMAS')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pengaduan</h1>
            <p class="text-gray-600">Informasi lengkap pengaduan Anda</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('user.complaints.index') }}" 
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            @if($complaint->status === 'pending')
                <a href="{{ route('user.complaints.edit', $complaint) }}" 
                   class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition duration-300">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Complaint Details -->
    <div class="space-y-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Pengaduan</h2>
            <div class="space-y-4">
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
        
        <!-- Admin Response -->
        @if($complaint->admin_response)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Respon Admin</h2>
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $complaint->admin_response }}</p>
                </div>
            </div>
        @endif
        
        <!-- Assigned Petugas -->
        @if($complaint->assignedPetugas)
            <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500 mt-4">
                <h3 class="text-lg font-semibold text-blue-700 mb-2">Petugas Penanganan</h3>
                <p class="text-blue-800 font-medium">{{ $complaint->assignedPetugas->nama }}</p>
                <p class="text-blue-700 text-sm">Pangkat: {{ $complaint->assignedPetugas->pangkat }}</p>
                <p class="text-blue-700 text-sm">No. HP: {{ $complaint->assignedPetugas->no_hp }}</p>
            </div>
        @endif
    </div>
    
    <!-- Photo Gallery -->
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Foto Bukti Kejadian</h2>
            
            @if($complaint->evidence_photos && count($complaint->evidence_photos) > 0)
                <div class="grid grid-cols-2 gap-4" id="photoGallery">
                    @foreach($complaint->evidence_photos as $index => $photo)
                        <div class="relative group cursor-pointer" onclick="openPhotoModal({{ $index }})">
                            <img src="{{ asset('storage/' . $photo) }}" 
                                 alt="Bukti {{ $index + 1 }}" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200 group-hover:border-polri-blue transition duration-200">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition duration-200 flex items-center justify-center">
                                <i class="fas fa-search text-white opacity-0 group-hover:opacity-100 transition duration-200"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <p class="text-sm text-gray-500 mt-4">
                    <i class="fas fa-info-circle mr-1"></i>
                    Klik foto untuk melihat dalam ukuran penuh
                </p>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-image text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-500">Tidak ada foto bukti</p>
                </div>
            @endif
        </div>
        
        <!-- Status Timeline -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Timeline Status</h2>
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white text-sm">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900">Pengaduan Diajukan</p>
                        <p class="text-sm text-gray-500">{{ $complaint->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                
                @if($complaint->processed_at)
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-900">Sedang Diproses</p>
                            <p class="text-sm text-gray-500">{{ $complaint->processed_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                @endif
                
                @if($complaint->completed_at)
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white text-sm">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-900">Selesai Diproses</p>
                            <p class="text-sm text-gray-500">{{ $complaint->completed_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
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