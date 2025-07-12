@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 text-center">
                Tentang Pustaka Adiwiyata
            </h2>

            <div class="prose dark:prose-invert max-w-none">
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-6">
                    Pustaka Adiwiyata adalah sistem manajemen perpustakaan yang dirancang khusus untuk mendukung program Adiwiyata di sekolah.
                    Sistem ini mengintegrasikan pengelolaan koleksi buku dengan fitur-fitur yang mendorong literasi dan kesadaran lingkungan.
                </p>

                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Fitur Utama</h3>
                <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 mb-6 space-y-2">
                    <li>Katalog buku digital dengan kategori Adiwiyata</li>
                    <li>Sistem peminjaman dan reservasi buku</li>
                    <li>Tracking poin literasi untuk anggota</li>
                    <li>Sistem ulasan dan rating buku</li>
                    <li>Dashboard admin untuk manajemen perpustakaan</li>
                    <li>Notifikasi otomatis untuk peminjaman dan pengembalian</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Program Adiwiyata</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Adiwiyata adalah program dari Kementerian Lingkungan Hidup yang bertujuan untuk menciptakan sekolah yang peduli dan berbudaya lingkungan.
                    Pustaka Adiwiyata mendukung program ini dengan menyediakan koleksi buku yang berkaitan dengan lingkungan, konservasi, dan keberlanjutan.
                </p>

                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Kontak</h3>
                <p class="text-gray-700 dark:text-gray-300">
                    Untuk informasi lebih lanjut, silakan hubungi administrator perpustakaan sekolah Anda.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
