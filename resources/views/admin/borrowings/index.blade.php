@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0">Daftar Peminjaman Buku</h2>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if (session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        @if($borrowings->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Denda</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrowings as $borrowing)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $borrowing->member->user->name ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $borrowing->member->member_id_number ?? '-' }}</small>
                            </td>
                            <td>
                                <strong>{{ $borrowing->book->title ?? '-' }}</strong><br>
                                <small class="text-muted">ISBN: {{ $borrowing->book->isbn ?? '-' }}</small>
                            </td>
                            <td>{{ $borrowing->borrow_date ? $borrowing->borrow_date->format('d/m/Y') : '-' }}</td>
                            <td>{{ $borrowing->due_date ? $borrowing->due_date->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($borrowing->status === 'borrowed')
                                    <span class="badge bg-primary">Dipinjam</span>
                                @elseif($borrowing->status === 'overdue')
                                    <span class="badge bg-danger">Terlambat</span>
                                @elseif($borrowing->status === 'returned')
                                    <span class="badge bg-success">Dikembalikan</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($borrowing->status) }}</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($borrowing->fine_amount ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if($borrowing->status === 'borrowed' || $borrowing->status === 'overdue')
                                        <form method="POST" action="{{ route('admin.borrowings.return', $borrowing) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi pengembalian buku?')">
                                                <i class="bi bi-arrow-90deg-left"></i> Kembalikan
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.borrowings.cancel', $borrowing) }}" class="d-inline ms-1">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Batalkan peminjaman ini?')">
                                                <i class="bi bi-x-circle"></i> Batalkan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $borrowings->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-journal-x display-1 text-muted"></i>
                <h5 class="mt-3 text-muted">Belum ada data peminjaman</h5>
            </div>
        @endif
    </div>
</div>
@endsection
