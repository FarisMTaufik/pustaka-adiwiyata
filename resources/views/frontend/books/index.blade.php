@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">
                Katalog Buku
            </h2>

            <form method="GET" action="{{ route('books.index') }}" class="mb-6 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                <input type="text" name="search" placeholder="Cari judul, penulis, ISBN, tema..." value="{{ request('search') }}" class="flex-grow border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition ease-in-out duration-150 shadow-md">Cari</button>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($books as $book)
                    <div class="flex bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md p-4">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-24 h-32 object-cover rounded mr-4 shadow-sm">
                        @else
                            <img src="https://placehold.co/96x128/cccccc/333333?text=No+Cover" alt="No Cover" class="w-24 h-32 object-cover rounded mr-4 shadow-sm">
                        @endif
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                <a href="{{ route('books.show', $book) }}" class="hover:underline">{{ $book->title }}</a>
                            </h3>
                            <p class="text-gray-700 dark:text-gray-300">Penulis: {{ $book->author }}</p>
                            <p class="text-gray-700 dark:text-gray-300">Kategori: {{ $book->category->name ?? 'N/A' }}</p>
                            <p class="text-gray-700 dark:text-gray-300">Tersedia: {{ $book->available_quantity }} / {{ $book->quantity }}</p>
                            @if($book->theme)
                                <span class="inline-block bg-green-200 text-green-800 text-xs px-2 py-1 rounded-full mt-2 dark:bg-green-700 dark:text-green-200">Adiwiyata: {{ $book->theme }}</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-900 dark:text-gray-100 col-span-full text-center">Tidak ada buku yang ditemukan.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
