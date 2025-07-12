@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 text-center">
                Selamat Datang di Pustaka Adiwiyata
            </h2>
            <p class="text-lg text-gray-700 dark:text-gray-300 mb-8 text-center">
                Sumber literasi dan inspirasi untuk program Adiwiyata di sekolah Anda.
            </p>

            <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Buku Terbaru</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @forelse ($latestBooks as $book)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex flex-col items-center text-center bg-gray-50 dark:bg-gray-700 shadow-sm">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-24 h-32 object-cover rounded mb-2 shadow-md">
                        @else
                            <img src="https://placehold.co/96x128/cccccc/333333?text=No+Cover" alt="No Cover" class="w-24 h-32 object-cover rounded mb-2 shadow-md">
                        @endif
                        <a href="{{ route('books.show', $book) }}" class="font-semibold text-blue-600 hover:underline dark:text-blue-400 dark:hover:text-blue-200">{{ $book->title }}</a>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $book->author }}</p>
                    </div>
                @empty
                    <p class="text-gray-700 dark:text-gray-300 col-span-full text-center">Belum ada buku terbaru.</p>
                @endforelse
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('books.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition ease-in-out duration-150 shadow-md">
                    Lihat Semua Buku
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
