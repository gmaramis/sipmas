@extends('layouts.user.app')

@section('title', 'Profil - SIPMAS')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Profil</h1>
    <p class="text-gray-600">Kelola informasi profil Anda</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Profile Information -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Profil</h2>
        
        <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent @error('phone') border-red-500 @enderror" 
                           placeholder="Contoh: 081234567890">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea id="address" name="address" rows="3" 
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent @error('address') border-red-500 @enderror" 
                              placeholder="Masukkan alamat lengkap">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" class="w-full bg-polri-blue text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    
    <!-- Change Password -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Ubah Password</h2>
        
        <form action="{{ route('user.profile.password') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                    <input type="password" id="current_password" name="current_password" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent @error('current_password') border-red-500 @enderror" required>
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" id="password" name="password" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent @error('password') border-red-500 @enderror" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-polri-blue focus:border-transparent" required>
                </div>
                
                <button type="submit" class="w-full bg-polri-red text-white px-6 py-2 rounded-lg hover:bg-red-700 transition duration-300">
                    <i class="fas fa-key mr-2"></i>Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Account Information -->
<div class="mt-8 bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Akun</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="font-semibold text-gray-800 mb-2">Detail Akun</h3>
            <div class="space-y-2 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>ID Pengguna:</span>
                    <span class="font-medium">{{ $user->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Bergabung Sejak:</span>
                    <span class="font-medium">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Terakhir Login:</span>
                    <span class="font-medium">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
        
        <div>
            <h3 class="font-semibold text-gray-800 mb-2">Keamanan</h3>
            <div class="space-y-2 text-sm text-gray-600">
                <div class="flex items-center">
                    <i class="fas fa-shield-alt text-green-500 mr-2"></i>
                    <span>Akun terverifikasi</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-lock text-blue-500 mr-2"></i>
                    <span>Password dienkripsi</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-user-shield text-purple-500 mr-2"></i>
                    <span>Role: {{ $user->roles->first()->name ?? 'User' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Danger Zone -->
<div class="mt-8 bg-red-50 border border-red-200 rounded-lg p-6">
    <h2 class="text-xl font-bold text-red-800 mb-4">Zona Berbahaya</h2>
    <p class="text-red-600 mb-4">Tindakan ini tidak dapat dibatalkan. Pastikan Anda benar-benar yakin.</p>
    
    <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300" 
            onclick="if(confirm('Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.')) { /* TODO: Implement account deletion */ }">
        <i class="fas fa-trash mr-2"></i>Hapus Akun
    </button>
</div>
@endsection 