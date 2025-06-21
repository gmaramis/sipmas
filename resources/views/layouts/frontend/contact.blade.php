@extends('layouts.frontend.app')

@section('title', 'Kontak - SIPMAS')

@section('content')
<!-- Hero Section dengan Parallax -->
<div class="relative py-32">
    <div class="absolute inset-0 parallax" style="background-image: url('{{ asset('img/contact-bg.jpg') }}');"></div>
    <div class="absolute inset-0 bg-polri-blue opacity-90"></div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-white mb-4">Hubungi Kami</h1>
            <p class="text-gray-300 text-xl max-w-3xl mx-auto">
                Kami siap membantu Anda. Silakan hubungi kami melalui kontak di bawah ini atau isi formulir kontak.
            </p>
        </div>
    </div>
</div>

<!-- Kontak Section -->
<div class="py-20 bg-white">
    <div class="container mx-auto px-6">
        @if(session('success'))
        <div class="mb-8 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Informasi Kontak -->
            <div>
                <h2 class="text-4xl font-bold text-polri-blue mb-8">Informasi Kontak</h2>
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="bg-polri-blue p-3 rounded-full mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-polri-blue mb-1">Alamat</h3>
                            <p class="text-gray-600">Jl. Raya Manado - Tomohon<br>Minahasa, Sulawesi Utara</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="bg-polri-blue p-3 rounded-full mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-polri-blue mb-1">Telepon</h3>
                            <p class="text-gray-600">(0431) 123456</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="bg-polri-blue p-3 rounded-full mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-polri-blue mb-1">Email</h3>
                            <p class="text-gray-600">info@sipmas.minahasa.polri.go.id</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulir Kontak -->
            <div>
                <h2 class="text-4xl font-bold text-polri-blue mb-8">Kirim Pesan</h2>
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-polri-blue focus:border-transparent" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-polri-blue focus:border-transparent" required>
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                        <input type="text" name="subject" id="subject" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-polri-blue focus:border-transparent" required>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                        <textarea name="message" id="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-polri-blue focus:border-transparent" required></textarea>
                    </div>
                    <button type="submit" class="w-full bg-polri-blue text-white px-6 py-3 rounded-md hover:bg-polri-red transition duration-300">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Peta Section -->
<div class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-polri-blue mb-12 text-center">Lokasi Kami</h2>
        <div class="aspect-w-16 aspect-h-9">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.1234567890123!2d124.12345678901234!3d1.1234567890123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwMDcnMjQuNCJOIDEyNMKwMDcnMjQuNCJF!5e0!3m2!1sid!2sid!4v1234567890123!5m2!1sid!2sid" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
            </iframe>
        </div>
    </div>
</div>
@endsection 