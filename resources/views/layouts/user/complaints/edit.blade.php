@extends('layouts.user.app')

@section('title', 'Edit Pengaduan - SIPMAS')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Edit Pengaduan</h1>
    <p class="text-gray-600">Perbarui informasi pengaduan Anda</p>
</div>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('user.complaints.update', $complaint) }}" method="POST" enctype="multipart/form-data" id="complaintForm">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Pengaduan *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $complaint->title) }}" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent @error('title') border-red-500 @enderror" 
                               placeholder="Contoh: Pencurian Motor di Jalan Raya" required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
                        <select id="category" name="category" 
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent @error('category') border-red-500 @enderror" required>
                            <option value="">Pilih Kategori</option>
                            <option value="kriminal" {{ old('category', $complaint->category) == 'kriminal' ? 'selected' : '' }}>Kriminal</option>
                            <option value="lalu_lintas" {{ old('category', $complaint->category) == 'lalu_lintas' ? 'selected' : '' }}>Lalu Lintas</option>
                            <option value="narkoba" {{ old('category', $complaint->category) == 'narkoba' ? 'selected' : '' }}>Narkoba</option>
                            <option value="korupsi" {{ old('category', $complaint->category) == 'korupsi' ? 'selected' : '' }}>Korupsi</option>
                            <option value="lainnya" {{ old('category', $complaint->category) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Kejadian *</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $complaint->location) }}" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent @error('location') border-red-500 @enderror" 
                               placeholder="Contoh: Jl. Raya Manado - Tomohon, Tondano" required>
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="space-y-6">
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kejadian *</label>
                        <textarea id="description" name="description" rows="6" 
                                  class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent @error('description') border-red-500 @enderror" 
                                  placeholder="Jelaskan detail kejadian yang Anda alami..." required>{{ old('description', $complaint->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Current Photos -->
            @if($complaint->evidence_photos && count($complaint->evidence_photos) > 0)
                <div class="mt-8">
                    <label class="block text-sm font-medium text-gray-700 mb-4">Foto Bukti Saat Ini</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
                        @foreach($complaint->evidence_photos as $index => $photo)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $photo) }}" 
                                     alt="Bukti {{ $index + 1 }}" 
                                     class="w-full h-24 object-cover rounded-lg border border-gray-200">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition duration-200 flex items-center justify-center">
                                    <span class="text-white text-xs opacity-0 group-hover:opacity-100 transition duration-200">Foto {{ $index + 1 }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-sm text-gray-500">Foto di atas akan tetap tersimpan. Anda dapat menambahkan foto baru di bawah ini.</p>
                </div>
            @endif
            
            <!-- New Photo Upload Section -->
            <div class="mt-8">
                <label class="block text-sm font-medium text-gray-700 mb-4">Tambahkan Foto Bukti Baru (Opsional)</label>
                <div id="photoUploadContainer" class="space-y-4">
                    <!-- Photo upload slots will be added here dynamically -->
                </div>
                
                <div class="mt-4">
                    <button type="button" id="addPhotoBtn" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-300">
                        <i class="fas fa-plus mr-2"></i>Tambah Foto Bukti
                    </button>
                    <p class="text-sm text-gray-500 mt-2">Maksimal 5 foto total (termasuk yang sudah ada), masing-masing maksimal 2MB</p>
                </div>
                
                @error('evidence_photos')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @error('evidence_photos.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Guidelines -->
            <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-2">Panduan Edit Pengaduan:</h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Hanya pengaduan dengan status "Menunggu" yang dapat diedit</li>
                    <li>• Foto yang sudah ada akan tetap tersimpan</li>
                    <li>• Anda dapat menambahkan foto bukti baru</li>
                    <li>• Pastikan informasi yang diperbarui akurat</li>
                </ul>
            </div>
            
            <!-- Submit Buttons -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('user.complaints.show', $complaint) }}" 
                   class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-polri-blue text-white rounded-lg hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let photoCount = 0;
    const maxPhotos = 5;
    const currentPhotoCount = {{ $complaint->evidence_photos ? count($complaint->evidence_photos) : 0 }};
    
    // Initialize with one photo slot if no current photos
    document.addEventListener('DOMContentLoaded', function() {
        if (currentPhotoCount === 0) {
            addPhotoSlot();
        }
    });
    
    // Add photo upload button event listener
    document.getElementById('addPhotoBtn').addEventListener('click', function() {
        if (photoCount + currentPhotoCount < maxPhotos) {
            addPhotoSlot();
        } else {
            alert('Maksimal 5 foto bukti total yang dapat diunggah.');
        }
    });
    
    function addPhotoSlot() {
        if (photoCount + currentPhotoCount >= maxPhotos) return;
        
        photoCount++;
        const container = document.getElementById('photoUploadContainer');
        
        const photoSlot = document.createElement('div');
        photoSlot.className = 'photo-slot border-2 border-dashed border-gray-300 rounded-lg p-4';
        photoSlot.id = `photo-slot-${photoCount}`;
        
        photoSlot.innerHTML = `
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-medium text-gray-700">Foto Bukti Baru ${photoCount}</h4>
                <button type="button" onclick="removePhotoSlot(${photoCount})" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="flex items-center">
                <div class="w-32 h-32 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden mr-4">
                    <img id="preview-${photoCount}" src="" alt="" class="hidden w-full h-full object-cover">
                    <div id="placeholder-${photoCount}" class="text-center p-4">
                        <i class="fas fa-camera text-gray-400 text-2xl mb-2"></i>
                        <p class="text-sm text-gray-500">Upload foto</p>
                    </div>
                </div>
                <div class="flex-1">
                    <input type="file" id="evidence_photos_${photoCount}" name="evidence_photos[]" accept="image/*" 
                           class="hidden" onchange="previewImage(this, ${photoCount})">
                    <button type="button" onclick="document.getElementById('evidence_photos_${photoCount}').click()" 
                            class="bg-white px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-polri-blue">
                        Pilih Foto
                    </button>
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB</p>
                </div>
            </div>
        `;
        
        container.appendChild(photoSlot);
        
        // Update add button state
        const addBtn = document.getElementById('addPhotoBtn');
        if (photoCount + currentPhotoCount >= maxPhotos) {
            addBtn.disabled = true;
            addBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }
    
    function removePhotoSlot(slotNumber) {
        const slot = document.getElementById(`photo-slot-${slotNumber}`);
        if (slot) {
            slot.remove();
            photoCount--;
            
            // Reorder remaining slots
            reorderPhotoSlots();
            
            // Update add button state
            const addBtn = document.getElementById('addPhotoBtn');
            if (photoCount + currentPhotoCount < maxPhotos) {
                addBtn.disabled = false;
                addBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
    }
    
    function reorderPhotoSlots() {
        const slots = document.querySelectorAll('.photo-slot');
        slots.forEach((slot, index) => {
            const slotNumber = index + 1;
            slot.id = `photo-slot-${slotNumber}`;
            
            // Update title
            const title = slot.querySelector('h4');
            title.textContent = `Foto Bukti Baru ${slotNumber}`;
            
            // Update remove button
            const removeBtn = slot.querySelector('button[onclick*="removePhotoSlot"]');
            if (removeBtn) {
                removeBtn.onclick = () => removePhotoSlot(slotNumber);
            }
            
            // Update file input
            const fileInput = slot.querySelector('input[type="file"]');
            fileInput.id = `evidence_photos_${slotNumber}`;
            fileInput.onchange = (e) => previewImage(e.target, slotNumber);
            
            // Update preview elements
            const preview = slot.querySelector('img');
            const placeholder = slot.querySelector('div[id^="placeholder"]');
            if (preview) preview.id = `preview-${slotNumber}`;
            if (placeholder) placeholder.id = `placeholder-${slotNumber}`;
            
            // Update button onclick
            const selectBtn = slot.querySelector('button[onclick*="getElementById"]');
            selectBtn.onclick = () => document.getElementById(`evidence_photos_${slotNumber}`).click();
        });
    }
    
    function previewImage(input, slotNumber) {
        const preview = document.getElementById(`preview-${slotNumber}`);
        const placeholder = document.getElementById(`placeholder-${slotNumber}`);
        const file = input.files[0];
        
        if (file) {
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                input.value = '';
                return;
            }
            
            // Validate file type
            if (!file.type.match('image.*')) {
                alert('File harus berupa gambar.');
                input.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    }
</script>
@endsection 