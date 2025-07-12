@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Poin Literasi Manual</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.literacy_points.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="member_id" class="form-label">Pilih Anggota <span class="text-danger">*</span></label>
                        <select name="member_id" id="member_id" class="form-select @error('member_id') is-invalid @enderror" required>
                            <option value="">Pilih Anggota</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->user->name }} ({{ $member->member_id_number ?? 'No ID' }}) - {{ $member->total_points ?? 0 }} poin
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="activity_type" class="form-label">Jenis Aktivitas <span class="text-danger">*</span></label>
                        <select name="activity_type" id="activity_type" class="form-select @error('activity_type') is-invalid @enderror" required>
                            <option value="">Pilih Aktivitas</option>
                            <option value="Peminjaman Buku" {{ old('activity_type') == 'Peminjaman Buku' ? 'selected' : '' }}>Peminjaman Buku</option>
                            <option value="Peminjaman Buku Adiwiyata" {{ old('activity_type') == 'Peminjaman Buku Adiwiyata' ? 'selected' : '' }}>Peminjaman Buku Adiwiyata</option>
                            <option value="Ulasan Buku" {{ old('activity_type') == 'Ulasan Buku' ? 'selected' : '' }}>Ulasan Buku</option>
                            <option value="Kegiatan Lingkungan" {{ old('activity_type') == 'Kegiatan Lingkungan' ? 'selected' : '' }}>Kegiatan Lingkungan</option>
                            <option value="Workshop Adiwiyata" {{ old('activity_type') == 'Workshop Adiwiyata' ? 'selected' : '' }}>Workshop Adiwiyata</option>
                            <option value="Penulisan Artikel" {{ old('activity_type') == 'Penulisan Artikel' ? 'selected' : '' }}>Penulisan Artikel</option>
                            <option value="Lainnya" {{ old('activity_type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('activity_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="points" class="form-label">Jumlah Poin <span class="text-danger">*</span></label>
                        <input type="number" name="points" id="points" class="form-control @error('points') is-invalid @enderror" value="{{ old('points', 10) }}" min="1" max="100" required>
                        @error('points')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Poin akan ditambahkan ke total poin anggota</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Aktivitas</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Jelaskan aktivitas yang dilakukan anggota">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Tambah Poin
                        </button>
                        <a href="{{ route('admin.literacy_points.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
