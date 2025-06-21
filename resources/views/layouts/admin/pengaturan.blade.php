@extends('layouts.admin.app')

@section('title', 'Pengaturan - SIPMAS')

@section('content')
<div class="p-8">
    <!-- Top Navigation -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pengaturan</h1>
            <p class="text-gray-600">Konfigurasi sistem dan profil admin</p>
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

    <!-- Settings Content -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Profil Admin -->
        <form method="POST" action="{{ route('admin.pengaturan.update') }}" class="bg-white rounded-lg shadow-md p-6 mb-8">
            @csrf
            <h2 class="text-xl font-bold text-gray-800 mb-6">Profil Admin</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-polri-blue" value="{{ auth()->user()->name }}">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-polri-blue" value="{{ auth()->user()->email }}">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-polri-blue" placeholder="Kosongkan jika tidak ingin mengubah">
                </div>
                <button type="submit" class="bg-polri-blue text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>

        <!-- Pengaturan Sistem -->
        <form method="POST" action="{{ route('admin.pengaturan.sistem') }}" class="bg-white rounded-lg shadow-md p-6 mb-8">
            @csrf
            <h2 class="text-xl font-bold text-gray-800 mb-6">Pengaturan Sistem</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 mb-2">Nama Instansi</label>
                    <input type="text" name="instansi" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-polri-blue" value="Polres Minahasa">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Alamat</label>
                    <textarea name="alamat" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-polri-blue" rows="3">Jl. Raya Manado - Tomohon, Tondano, Minahasa</textarea>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="tel" name="telepon" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-polri-blue" value="(0431) 123456">
                </div>
                <button type="submit" class="bg-polri-blue text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>

        <!-- Notifikasi -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Pengaturan Notifikasi</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-800">Notifikasi Email</h3>
                        <p class="text-sm text-gray-600">Terima notifikasi melalui email</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-polri-blue"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-800">Notifikasi Browser</h3>
                        <p class="text-sm text-gray-600">Terima notifikasi di browser</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-polri-blue"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-800">Notifikasi WhatsApp</h3>
                        <p class="text-sm text-gray-600">Terima notifikasi melalui WhatsApp</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" id="whatsapp-toggle">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-polri-blue"></div>
                    </label>
                </div>
                <!-- Konfigurasi WhatsApp -->
                <div id="whatsapp-config" class="mt-4 p-4 border rounded-lg hidden">
                    <div class="space-y-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800 mb-2">Cara Setup WhatsApp:</h4>
                            <ol class="list-decimal list-inside text-sm text-blue-700 space-y-2">
                                <li>Daftar akun di <a href="https://fontewa.com" target="_blank" class="text-blue-600 hover:underline">fontewa.com</a></li>
                                <li>Pilih paket yang sesuai dengan kebutuhan</li>
                                <li>Dapatkan token dari dashboard</li>
                                <li>Masukkan token di bawah ini</li>
                            </ol>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Token</label>
                            <input type="text" id="whatsapp-token" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-polri-blue" placeholder="Masukkan token">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Nomor WhatsApp</label>
                            <input type="tel" id="phone-number" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-polri-blue" placeholder="Contoh: 6281234567890">
                        </div>
                        <div class="flex space-x-4">
                            <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                                <i class="fab fa-whatsapp mr-2"></i>Test WhatsApp
                            </button>
                            <button class="bg-polri-blue text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Backup & Restore -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Backup & Restore</h2>
            <div class="space-y-4">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">Backup Data</h3>
                    <p class="text-sm text-gray-600 mb-4">Buat salinan cadangan data sistem</p>
                    <button class="bg-polri-blue text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-download mr-2"></i>Download Backup
                    </button>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">Restore Data</h3>
                    <p class="text-sm text-gray-600 mb-4">Pulihkan data dari file backup</p>
                    <div class="flex space-x-4">
                        <input type="file" class="hidden" id="restore-file">
                        <label for="restore-file" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 cursor-pointer">
                            <i class="fas fa-upload mr-2"></i>Pilih File
                        </label>
                        <button class="bg-polri-red text-white px-6 py-2 rounded-lg hover:bg-red-700">
                            <i class="fas fa-undo mr-2"></i>Restore
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle WhatsApp Configuration
    const whatsappToggle = document.getElementById('whatsapp-toggle');
    const whatsappConfig = document.getElementById('whatsapp-config');

    whatsappToggle.addEventListener('change', function() {
        whatsappConfig.classList.toggle('hidden');
    });
</script>
@endsection 