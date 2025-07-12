@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-4">Detail Buku</h2>
                <div class="row">
                    <div class="col-md-4 text-center mb-3 mb-md-0">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover Buku" class="img-thumbnail mb-2" style="max-width: 180px;">
                        @else
                            <div class="bg-light border rounded d-flex align-items-center justify-content-center" style="width:180px;height:240px;">No Cover</div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless mb-0">
                            <tr><th>Judul</th><td>{{ $book->title }}</td></tr>
                            <tr><th>Penulis</th><td>{{ $book->author }}</td></tr>
                            <tr><th>ISBN</th><td>{{ $book->isbn ?? '-' }}</td></tr>
                            <tr><th>Kategori</th><td>{{ $book->category->name ?? '-' }}</td></tr>
                            <tr><th>Tahun Terbit</th><td>{{ $book->publication_year ?? '-' }}</td></tr>
                            <tr><th>Stok</th><td>{{ $book->available_quantity }} / {{ $book->quantity }}</td></tr>
                            <tr><th>Tema Adiwiyata</th><td>{{ $book->theme ?? '-' }}</td></tr>
                            <tr><th>Deskripsi</th><td>{{ $book->description ?? '-' }}</td></tr>
                        </table>
                        <div class="mt-3">
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
