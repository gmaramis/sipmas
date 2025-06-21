@extends('layouts.frontend.app')

@section('title', 'Tentang Kami - SIPMAS')

@section('content')
<!-- Hero Section -->
<div class="relative py-20 bg-gradient-to-br from-polri-blue to-polri-red">
    <div class="container mx-auto px-6">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-white mb-6">Tentang SIPMAS</h1>
            <p class="text-xl text-gray-200 max-w-3xl mx-auto">
                Sistem Informasi Pengaduan Masyarakat (SIPMAS) adalah platform digital yang memudahkan masyarakat dalam menyampaikan pengaduan secara online.
            </p>
        </div>
    </div>
</div>

<!-- Visi & Misi Section -->
<div class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="bg-gray-50 p-8 rounded-xl shadow-lg">
                <h2 class="text-3xl font-bold text-polri-blue mb-6">Visi</h2>
                <p class="text-gray-700 text-lg leading-relaxed">
                    Menjadi platform pengaduan masyarakat terpercaya yang mendukung terwujudnya pelayanan publik yang transparan, akuntabel, dan responsif.
                </p>
            </div>
            <div class="bg-gray-50 p-8 rounded-xl shadow-lg">
                <h2 class="text-3xl font-bold text-polri-blue mb-6">Misi</h2>
                <ul class="text-gray-700 text-lg leading-relaxed space-y-4">
                    <li class="flex items-start">
                        <span class="text-polri-red mr-2">•</span>
                        Menyediakan platform pengaduan yang mudah diakses dan aman
                    </li>
                    <li class="flex items-start">
                        <span class="text-polri-red mr-2">•</span>
                        Memastikan setiap pengaduan ditangani dengan cepat dan profesional
                    </li>
                    <li class="flex items-start">
                        <span class="text-polri-red mr-2">•</span>
                        Meningkatkan transparansi dalam penanganan pengaduan
                    </li>
                    <li class="flex items-start">
                        <span class="text-polri-red mr-2">•</span>
                        Membangun kepercayaan masyarakat terhadap layanan publik
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Tim Kami Section -->
<div class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center text-polri-blue mb-4">Tim SIPMAS</h2>
        <p class="text-gray-600 text-center mb-12 max-w-3xl mx-auto text-lg">
            Kami didukung oleh tim profesional yang berdedikasi untuk memberikan pelayanan terbaik kepada masyarakat.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden">
                    <img src="{{ asset('img/team-1.jpg') }}" alt="Tim SIPMAS" class="w-full h-full object-cover">
                </div>
                <h3 class="text-2xl font-semibold text-center text-polri-blue mb-2">Kepala Humas</h3>
                <p class="text-gray-600 text-center">Memimpin dan mengkoordinasikan seluruh aktivitas Humas Polri</p>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden">
                    <img src="{{ asset('img/team-2.jpg') }}" alt="Tim SIPMAS" class="w-full h-full object-cover">
                </div>
                <h3 class="text-2xl font-semibold text-center text-polri-blue mb-2">Admin SIPMAS</h3>
                <p class="text-gray-600 text-center">Mengelola dan memastikan sistem berjalan dengan baik</p>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden">
                    <img src="{{ asset('img/team-3.jpg') }}" alt="Tim SIPMAS" class="w-full h-full object-cover">
                </div>
                <h3 class="text-2xl font-semibold text-center text-polri-blue mb-2">Petugas Layanan</h3>
                <p class="text-gray-600 text-center">Menangani dan memproses pengaduan masyarakat</p>
            </div>
        </div>
    </div>
</div>

<!-- Sejarah Section -->
<div class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-4xl font-bold text-center text-polri-blue mb-8">Sejarah SIPMAS</h2>
            <div class="space-y-8">
                <div class="flex items-start">
                    <div class="bg-polri-blue text-white w-12 h-12 rounded-full flex items-center justify-center text-xl font-bold mr-6 flex-shrink-0">1</div>
                    <div>
                        <h3 class="text-2xl font-semibold text-polri-blue mb-2">Awal Mula</h3>
                        <p class="text-gray-700 text-lg leading-relaxed">
                            SIPMAS diluncurkan pada tahun 2025 sebagai inisiatif modernisasi layanan pengaduan masyarakat di lingkungan Polri. Sistem ini dirancang untuk memberikan kemudahan akses bagi masyarakat dalam menyampaikan pengaduan.
                        </p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-polri-blue text-white w-12 h-12 rounded-full flex items-center justify-center text-xl font-bold mr-6 flex-shrink-0">2</div>
                    <div>
                        <h3 class="text-2xl font-semibold text-polri-blue mb-2">Perkembangan</h3>
                        <p class="text-gray-700 text-lg leading-relaxed">
                            Sejak peluncurannya, SIPMAS terus dikembangkan dengan fitur-fitur baru untuk meningkatkan kualitas layanan, keamanan data, dan kemudahan penggunaan bagi masyarakat.
                        </p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-polri-blue text-white w-12 h-12 rounded-full flex items-center justify-center text-xl font-bold mr-6 flex-shrink-0">3</div>
                    <div>
                        <h3 class="text-2xl font-semibold text-polri-blue mb-2">Masa Depan</h3>
                        <p class="text-gray-700 text-lg leading-relaxed">
                            SIPMAS berkomitmen untuk terus berinovasi dalam memberikan layanan pengaduan yang lebih baik, cepat, dan transparan bagi masyarakat Indonesia.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 