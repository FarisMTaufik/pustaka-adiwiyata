@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0">Profile Anggota</h2>
    <div class="btn-group" role="group">
        <a href="{{ route('books.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-book"></i> Katalog Buku
        </a>
        <a href="#" class="btn btn-outline-success">
            <i class="bi bi-star"></i> Riwayat Poin
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<!-- Informasi Profile -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person-circle"></i> Informasi Profile</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D6EFD&color=fff&size=100"
                             alt="Profile" class="img-fluid rounded-circle mb-3">
                    </div>
                    <div class="col-sm-8">
                        <h6 class="text-muted mb-1">Nama Lengkap</h6>
                        <p class="fw-bold mb-2">{{ Auth::user()->name }}</p>

                        <h6 class="text-muted mb-1">Email</h6>
                        <p class="mb-2">{{ Auth::user()->email }}</p>

                        <h6 class="text-muted mb-1">Nomor Anggota</h6>
                        <p class="mb-2">{{ $member->member_id_number ?? 'Belum diatur' }}</p>

                        <h6 class="text-muted mb-1">Alamat</h6>
                        <p class="mb-2">{{ $member->address ?? 'Belum diisi' }}</p>

                        <h6 class="text-muted mb-1">No. HP</h6>
                        <p class="mb-2">{{ $member->phone_number ?? 'Belum diisi' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-star-fill"></i> Statistik Literasi</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h3 class="text-success fw-bold">{{ $member->total_points ?? 0 }}</h3>
                            <small class="text-muted">Total Poin Literasi</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h3 class="text-primary fw-bold">{{ $borrowings->whereIn('status', ['borrowed', 'overdue'])->count() }}</h3>
                        <small class="text-muted">Buku Dipinjam</small>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h3 class="text-danger fw-bold">{{ $borrowings->where('status', 'overdue')->count() }}</h3>
                            <small class="text-muted">Buku Terlambat</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h3 class="text-warning fw-bold">Rp {{ number_format($borrowings->where('status', 'overdue')->sum('fine_amount'), 0, ',', '.') }}</h3>
                        <small class="text-muted">Total Denda</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Buku yang Sedang Dipinjam -->
<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-journal-check"></i> Buku yang Sedang Dipinjam</h5>
    </div>
    <div class="card-body">
        @if($borrowings->whereIn('status', ['borrowed', 'overdue'])->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrowings->whereIn('status', ['borrowed', 'overdue']) as $borrowing)
                        <tr>
                            <td>
                                <strong>{{ $borrowing->book->title ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $borrowing->book->author ?? 'Unknown' }}</small>
                            </td>
                            <td>{{ $borrowing->borrow_date ? \Carbon\Carbon::parse($borrowing->borrow_date)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $borrowing->due_date ? \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($borrowing->status === 'borrowed')
                                    <span class="badge bg-primary">Dipinjam</span>
                                @elseif($borrowing->status === 'overdue')
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($borrowing->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($borrowing->fine_amount > 0)
                                    <span class="text-danger fw-bold">Rp {{ number_format($borrowing->fine_amount, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $literacyPoints->links() }}
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-journal-x display-1 text-muted"></i>
                <h5 class="mt-3 text-muted">Tidak ada buku yang sedang dipinjam</h5>
                <p class="text-muted">Mulai meminjam buku dari katalog kami</p>
                <a href="{{ route('books.index') }}" class="btn btn-primary">
                    <i class="bi bi-book"></i> Lihat Katalog
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Riwayat Poin Literasi -->
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-star"></i> Riwayat Poin Literasi</h5>
    </div>
    <div class="card-body">
        @if($literacyPoints->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tipe Aktivitas</th>
                            <th>Poin</th>
                            <th>Deskripsi</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($literacyPoints as $point)
                        <tr>
                            <td>
                                <span class="badge bg-primary">{{ $point->activity_type }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success">+{{ $point->points }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $point->description ?? '-' }}</small>
                            </td>
                            <td>{{ $point->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else
            <div class="text-center py-4">
                <i class="bi bi-star display-1 text-muted"></i>
                <h5 class="mt-3 text-muted">Belum ada riwayat poin literasi</h5>
                <p class="text-muted">Mulai berpartisipasi dalam kegiatan literasi untuk mendapatkan poin</p>
                <a href="{{ route('books.index') }}" class="btn btn-success">
                    <i class="bi bi-book"></i> Mulai Membaca
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
