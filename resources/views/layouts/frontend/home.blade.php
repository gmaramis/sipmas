@extends('layouts.frontend.app')

@section('title', 'Beranda - SIPMAS')

@section('content')
<!-- Hero Section -->
<div class="relative min-h-screen flex items-center bg-gradient-to-br from-polri-blue to-polri-red">
    <div class="container mx-auto px-6 py-32 relative z-10">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2">
                <h1 class="text-6xl font-bold text-white mb-6 leading-tight">
                    Layanan Pengaduan Masyarakat <span class="text-polri-red">Digital</span>
                </h1>
                <p class="text-gray-200 text-xl mb-8 leading-relaxed">
                    Sampaikan pengaduan Anda dengan mudah dan aman. Kami siap membantu menyelesaikan permasalahan Anda dengan cepat dan profesional.
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('register') }}" class="bg-polri-red text-white px-8 py-4 rounded-lg hover:bg-red-700 transition duration-300 transform hover:scale-105 text-center font-semibold shadow-lg">
                        Buat Pengaduan
                    </a>
                    <a href="{{ route('about') }}" class="border-2 border-white text-white px-8 py-4 rounded-lg hover:bg-white hover:text-polri-blue transition duration-300 transform hover:scale-105 text-center font-semibold">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 mt-12 md:mt-0 flex justify-center items-center">
                <div class="relative flex justify-center items-center w-full">
                    <div class="absolute -inset-4 bg-polri-red rounded-full opacity-20 blur-2xl"></div>
                    <img src="{{ asset('img/polri-presisi.png') }}" alt="Logo Polri Presisi" class="w-3/5 md:w-1/2 w-40 mx-auto rounded-full shadow-2xl hover:scale-105 transition-transform duration-300 transform hover:rotate-3 relative z-10 floating">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Section -->
<div class="relative py-20 bg-polri-blue">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div class="p-6 transform hover:scale-105 transition duration-300">
                <div class="text-5xl font-bold mb-2 text-white">10K+</div>
                <p class="text-gray-300 text-lg">Pengaduan Ditangani</p>
            </div>
            <div class="p-6 transform hover:scale-105 transition duration-300">
                <div class="text-5xl font-bold mb-2 text-white">24/7</div>
                <p class="text-gray-300 text-lg">Layanan Aktif</p>
            </div>
            <div class="p-6 transform hover:scale-105 transition duration-300">
                <div class="text-5xl font-bold mb-2 text-white">98%</div>
                <p class="text-gray-300 text-lg">Kepuasan Pengguna</p>
            </div>
            <div class="p-6 transform hover:scale-105 transition duration-300">
                <div class="text-5xl font-bold mb-2 text-white">1 Jam</div>
                <p class="text-gray-300 text-lg">Waktu Respon Rata-rata</p>
            </div>
        </div>
    </div>
</div>

<!-- Humas Polri Section -->
<div class="relative py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 mb-8 md:mb-0 flex justify-center items-center">
                <div class="relative flex justify-center items-center w-full">
                    <div class="absolute -inset-4 bg-polri-red rounded-full opacity-20 blur-2xl"></div>
                    <img src="{{ asset('img/humas-polri.png') }}" alt="Humas Polri" class="w-2/5 md:w-2/5 w-32 mx-auto rounded-full shadow-2xl hover:scale-105 transition-transform duration-300 transform hover:-rotate-3 relative z-10 floating">
                </div>
            </div>
            <div class="md:w-1/2 md:pl-12 flex flex-col items-center md:items-start">
                <h2 class="text-5xl font-bold text-polri-blue mb-6">
                    Humas Polri
                </h2>
                <p class="text-gray-700 text-xl mb-8 leading-relaxed">
                    Humas Polri siap melayani dan memberikan informasi terkait pengaduan masyarakat. Kami berkomitmen untuk memberikan pelayanan yang profesional dan transparan.
                </p>
                <div class="flex space-x-4 w-full justify-center md:justify-start">
                    <a href="{{ route('contact') }}" class="bg-polri-blue text-white px-8 py-4 rounded-lg hover:bg-polri-red transition duration-300 transform hover:scale-105 font-semibold shadow-lg">
                        Hubungi Humas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Prosedur Pelaporan Section -->
<div class="relative py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-5xl font-bold text-center text-polri-blue mb-4">
            Prosedur Pelaporan yang Mudah & Aman
        </h2>
        <p class="text-gray-600 text-center mb-12 max-w-3xl mx-auto text-xl">
            Kami memastikan setiap pengaduan ditangani dengan cepat, profesional, dan transparan melalui prosedur yang terstandarisasi.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="bg-polri-blue text-white w-20 h-20 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6">1</div>
                <h3 class="text-2xl font-semibold mb-4 text-polri-blue text-center">Daftar Akun</h3>
                <p class="text-gray-600 text-center text-lg">Buat akun dengan data diri yang valid untuk memastikan keamanan</p>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="bg-polri-blue text-white w-20 h-20 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6">2</div>
                <h3 class="text-2xl font-semibold mb-4 text-polri-blue text-center">Isi Formulir</h3>
                <p class="text-gray-600 text-center text-lg">Lengkapi detail pengaduan dengan jelas dan lengkap</p>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="bg-polri-blue text-white w-20 h-20 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6">3</div>
                <h3 class="text-2xl font-semibold mb-4 text-polri-blue text-center">Verifikasi</h3>
                <p class="text-gray-600 text-center text-lg">Tim kami akan memverifikasi dan memproses pengaduan Anda</p>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="bg-polri-blue text-white w-20 h-20 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6">4</div>
                <h3 class="text-2xl font-semibold mb-4 text-polri-blue text-center">Tindak Lanjut</h3>
                <p class="text-gray-600 text-center text-lg">Dapatkan update status pengaduan melalui sistem</p>
            </div>
        </div>
    </div>
</div>
@endsection 