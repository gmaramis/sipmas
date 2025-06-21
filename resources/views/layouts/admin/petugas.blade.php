@extends('layouts.admin.app')

@section('title', 'Petugas Penanganan - SIPMAS')

@section('content')
<div class="p-8">
    <!-- Top Navigation -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Petugas Penanganan</h1>
            <p class="text-gray-600">Manajemen data petugas penanganan pengaduan</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <button id="notificationButton" class="bg-white p-2 rounded-lg shadow-md hover:bg-gray-50 relative transition-colors duration-200">
                    <i class="fas fa-bell text-gray-600"></i>
                    <span class="absolute -top-1 -right-1 bg-polri-red text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                </button>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 rounded-full bg-polri-blue flex items-center justify-center text-white shadow-md">
                    <i class="fas fa-user"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-800 font-medium">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-polri-red hover:text-red-700">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Petugas Content -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Daftar Petugas Penanganan</h2>
                <p class="text-gray-600 mt-1">Kelola data petugas yang menangani pengaduan</p>
            </div>
            <button onclick="openAddPetugasModal()" class="bg-polri-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center shadow-md">
                <i class="fas fa-plus mr-2"></i>
                Tambah Petugas
            </button>
        </div>

        <!-- Filter Section -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <input type="text" placeholder="Cari petugas..." class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent shadow-sm">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <select class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent shadow-sm">
                    <option value="">Semua Pangkat</option>
                    <option value="Aiptu">Aiptu</option>
                    <option value="Bripka">Bripka</option>
                    <option value="Aipda">Aipda</option>
                    <option value="Bripda">Bripda</option>
                </select>
                <select class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent shadow-sm">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama & Pangkat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img src="https://via.placeholder.com/40" alt="Budi Santoso" class="h-10 w-10 rounded-full object-cover border-2 border-polri-blue">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Ajun Inspektur Polisi Satu (AIPTU) Budi Santoso</div>
                                    <div class="text-sm text-gray-500">NRP: 1234567890</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">0812-3456-7890</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="openEditPetugasModal(1)" class="text-polri-blue hover:text-blue-700 mr-3 transition-colors duration-200">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deletePetugas(1)" class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img src="https://via.placeholder.com/40" alt="Andi Wijaya" class="h-10 w-10 rounded-full object-cover border-2 border-polri-blue">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Brigadir Polisi Kepala (Bripka) Andi Wijaya</div>
                                    <div class="text-sm text-gray-500">NRP: 1234567891</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">0813-4567-8901</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="openEditPetugasModal(2)" class="text-polri-blue hover:text-blue-700 mr-3 transition-colors duration-200">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deletePetugas(2)" class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-6">
            <div class="text-sm text-gray-700">
                Menampilkan 1-2 dari 2 petugas
            </div>
            <div class="flex space-x-2">
                <button class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50 disabled:opacity-50 transition-colors duration-200" disabled>
                    <i class="fas fa-chevron-left mr-2"></i>
                    Previous
                </button>
                <button class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50 disabled:opacity-50 transition-colors duration-200" disabled>
                    Next
                    <i class="fas fa-chevron-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Petugas Modal -->
<div id="petugasModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800" id="modalTitle">Tambah Petugas</h3>
                <button onclick="closePetugasModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NRP</label>
                    <input type="text" placeholder="Contoh: 1234567890" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pangkat</label>
                    <select class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent" required>
                        <option value="">Pilih Pangkat</option>
                        <optgroup label="Perwira Tinggi">
                            <option value="Jenderal Polisi">Jenderal Polisi (Jend. Pol.)</option>
                            <option value="Komisaris Jenderal Polisi">Komisaris Jenderal Polisi (Komjen. Pol.)</option>
                            <option value="Inspektur Jenderal Polisi">Inspektur Jenderal Polisi (Irjen. Pol.)</option>
                            <option value="Brigadir Jenderal Polisi">Brigadir Jenderal Polisi (Brigjen. Pol.)</option>
                        </optgroup>
                        <optgroup label="Perwira Menengah">
                            <option value="Komisaris Besar Polisi">Komisaris Besar Polisi (Kombes. Pol.)</option>
                            <option value="Ajun Komisaris Besar Polisi">Ajun Komisaris Besar Polisi (AKBP)</option>
                            <option value="Komisaris Polisi">Komisaris Polisi (Kompol)</option>
                        </optgroup>
                        <optgroup label="Perwira Pertama">
                            <option value="Ajun Komisaris Polisi">Ajun Komisaris Polisi (AKP)</option>
                            <option value="Inspektur Polisi Satu">Inspektur Polisi Satu (IPTU)</option>
                            <option value="Inspektur Polisi Dua">Inspektur Polisi Dua (IPDA)</option>
                        </optgroup>
                        <optgroup label="Bintara Tinggi">
                            <option value="Ajun Inspektur Polisi Satu">Ajun Inspektur Polisi Satu (AIPTU)</option>
                            <option value="Ajun Inspektur Polisi Dua">Ajun Inspektur Polisi Dua (AIPDA)</option>
                        </optgroup>
                        <optgroup label="Bintara">
                            <option value="Brigadir Polisi Kepala">Brigadir Polisi Kepala (Bripka)</option>
                            <option value="Brigadir Polisi">Brigadir Polisi (Brip)</option>
                            <option value="Brigadir Polisi Satu">Brigadir Polisi Satu (Briptu)</option>
                            <option value="Brigadir Polisi Dua">Brigadir Polisi Dua (Bripda)</option>
                        </optgroup>
                        <optgroup label="Tamtama">
                            <option value="Ajun Brigadir Polisi">Ajun Brigadir Polisi (Abrip)</option>
                            <option value="Bhayangkara Dua">Bhayangkara Dua (Bharada)</option>
                            <option value="Bhayangkara Satu">Bhayangkara Satu (Bharatu)</option>
                            <option value="Bhayangkara">Bhayangkara (Bharat)</option>
                        </optgroup>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Petugas</label>
                    <div class="mt-1 flex items-center">
                        <div class="w-32 h-32 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                            <img id="preview" src="" alt="" class="hidden w-full h-full object-cover">
                            <div id="placeholder" class="text-center p-4">
                                <i class="fas fa-camera text-gray-400 text-2xl mb-2"></i>
                                <p class="text-sm text-gray-500">Upload foto</p>
                            </div>
                        </div>
                        <div class="ml-4">
                            <input type="file" id="photo" accept="image/*" class="hidden" onchange="previewImage(this)">
                            <button type="button" onclick="document.getElementById('photo').click()" class="bg-white px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-polri-blue">
                                Pilih Foto
                            </button>
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB</p>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                    <input type="tel" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent" required>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closePetugasModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-polri-blue text-white rounded-lg hover:bg-blue-700 transition duration-300">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAddPetugasModal() {
        document.getElementById('modalTitle').textContent = 'Tambah Petugas';
        document.getElementById('petugasModal').classList.remove('hidden');
    }

    function openEditPetugasModal(id) {
        document.getElementById('modalTitle').textContent = 'Edit Petugas';
        document.getElementById('petugasModal').classList.remove('hidden');
        // TODO: Load petugas data based on id
    }

    function closePetugasModal() {
        document.getElementById('petugasModal').classList.add('hidden');
    }

    function deletePetugas(id) {
        if (confirm('Apakah Anda yakin ingin menghapus petugas ini?')) {
            // TODO: Implement delete functionality
            alert('Petugas berhasil dihapus');
        }
    }

    function previewImage(input) {
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('placeholder');
        const file = input.files[0];
        
        if (file) {
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

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('petugasModal');
        if (event.target == modal) {
            closePetugasModal();
        }
    }
</script>
@endsection 