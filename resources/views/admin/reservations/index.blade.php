@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0">Manajemen Reservasi Buku</h2>
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

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reservations.index') }}" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" placeholder="Cari buku atau anggota..." value="{{ request('search') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="all">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Tertunda</option>
                    <option value="ready_for_pickup" {{ request('status') == 'ready_for_pickup' ? 'selected' : '' }}>Siap Diambil</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    <option value="fulfilled" {{ request('status') == 'fulfilled' ? 'selected' : '' }}>Terpenuhi</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 text-dark">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if($reservations->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Judul Buku</th>
                            <th>Anggota</th>
                            <th>Tanggal Reservasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>
                                <strong>{{ $reservation->book->title ?? 'N/A' }}</strong><br>
                                <small class="text-muted">ISBN: {{ $reservation->book->isbn ?? '-' }}</small>
                            </td>
                            <td>
                                <strong>{{ $reservation->member->user->name ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $reservation->member->member_id_number ?? '-' }}</small>
                            </td>
                            <td>{{ $reservation->reservation_date ? \Carbon\Carbon::parse($reservation->reservation_date)->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                @if($reservation->status === 'pending')
                                    <span class="badge bg-warning text-dark">Tertunda</span>
                                @elseif($reservation->status === 'ready_for_pickup')
                                    <span class="badge bg-info text-dark">Siap Diambil</span>
                                @elseif($reservation->status === 'cancelled')
                                    <span class="badge bg-secondary">Dibatalkan</span>
                                @elseif($reservation->status === 'fulfilled')
                                    <span class="badge bg-success">Terpenuhi</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $reservation->status)) }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if($reservation->status === 'pending')
                                        <form method="POST" action="{{ route('admin.reservations.mark_ready', $reservation) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-info" onclick="return confirm('Apakah Anda yakin ingin menandai reservasi ini siap diambil?')">
                                                <i class="bi bi-check-circle"></i> Siap Diambil
                                            </button>
                                        </form>
                                    @endif
                                    @if($reservation->status !== 'cancelled' && $reservation->status !== 'fulfilled')
                                        <form method="POST" action="{{ route('admin.reservations.cancel', $reservation) }}" class="d-inline ms-1">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                                                <i class="bi bi-x-circle"></i> Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $reservations->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x display-1 text-muted"></i>
                <h5 class="mt-3 text-muted">Belum ada reservasi buku</h5>
            </div>
        @endif
    </div>
</div>
@endsection
