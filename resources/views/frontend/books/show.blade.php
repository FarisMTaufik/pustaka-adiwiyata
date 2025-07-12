@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">
                Detail Buku: {{ $book->title }}
            </h2>

            <div class="flex flex-col md:flex-row gap-6">
                <div class="md:w-1/3 flex justify-center">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-64 h-96 object-cover rounded-lg shadow-lg">
                    @else
                        <img src="https://placehold.co/256x384/cccccc/333333?text=No+Cover" alt="No Cover" class="w-64 h-96 object-cover rounded-lg shadow-lg">
                    @endif
                </div>
                <div class="md:w-2/3">
                    <h1 class="text-3xl font-bold mb-2">{{ $book->title }}</h1>
                    <p class="text-xl text-gray-700 dark:text-gray-300 mb-2">Penulis: {{ $book->author }}</p>
                    <p class="text-md text-gray-600 dark:text-gray-400 mb-1">ISBN: {{ $book->isbn ?? '-' }}</p>
                    <p class="text-md text-gray-600 dark:text-gray-400 mb-1">Tahun Terbit: {{ $book->publication_year ?? '-' }}</p>
                    <p class="text-md text-gray-600 dark:text-gray-400 mb-1">Kategori: {{ $book->category->name ?? 'N/A' }}</p>
                    @if($book->theme)
                        <p class="text-md text-gray-600 dark:text-gray-400 mb-1">Tema Adiwiyata: <span class="inline-block bg-green-200 text-green-800 text-sm px-2 py-1 rounded-full dark:bg-green-700 dark:text-green-200">{{ $book->theme }}</span></p>
                    @endif
                    <p class="text-md text-gray-600 dark:text-gray-400 mb-4">Stok Tersedia: <span class="font-bold">{{ $book->available_quantity }}</span> / {{ $book->quantity }}</p>

                    <p class="text-gray-800 dark:text-gray-200 mb-6">{{ $book->description ?? 'Tidak ada deskripsi.' }}</p>

                    @auth
                        @if($book->available_quantity > 0)
                            <form action="{{ route('borrow.request', $book) }}" method="POST" class="inline-block mr-2">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition ease-in-out duration-150 shadow-md">
                                    Pinjam Buku Ini
                                </button>
                            </form>
                        @else
                            <form action="{{ route('reserve.store', $book) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-500 dark:hover:bg-blue-600 transition ease-in-out duration-150 shadow-md">
                                    Reservasi Buku Ini
                                </button>
                            </form>
                        @endif
                    @else
                        <p class="text-gray-600 dark:text-gray-400">Login untuk meminjam atau mereservasi buku.</p>
                    @endauth

                    <h3 class="text-2xl font-semibold mt-8 mb-4">Ulasan Pembaca</h3>
                    @auth
                        <div class="mb-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700 shadow-sm">
                            <h4 class="text-lg font-medium mb-2">Berikan Ulasan Anda</h4>
                            <form action="{{ route('reviews.store', $book) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rating (1-5)</label>
                                    <select name="rating" id="rating" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 p-2">
                                        <option value="5">5 Bintang - Sangat Bagus</option>
                                        <option value="4">4 Bintang - Bagus</option>
                                        <option value="3">3 Bintang - Cukup</option>
                                        <option value="2">2 Bintang - Kurang</option>
                                        <option value="1">1 Bintang - Buruk</option>
                                    </select>
                                    @error('rating')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Komentar</label>
                                    <textarea name="comment" id="comment" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 p-2"></textarea>
                                    @error('comment')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition ease-in-out duration-150 shadow-md">
                                    Kirim Ulasan
                                </button>
                            </form>
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-gray-400">Login untuk memberikan ulasan.</p>
                    @endauth

                    @forelse ($reviews as $review)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 last:border-b-0">
                            <div class="flex items-center mb-2">
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $review->member->user->name ?? 'Anonim' }}</p>
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                    @for ($i = 0; $i < $review->rating; $i++)
                                        ⭐
                                    @endfor
                                </span>
                                <span class="ml-auto text-xs text-gray-500 dark:text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-800 dark:text-gray-200">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <p class="text-gray-600 dark:text-gray-400">Belum ada ulasan untuk buku ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
