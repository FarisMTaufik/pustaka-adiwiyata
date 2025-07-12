@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0">Laporan & Statistik</h2>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-outline-primary" onclick="window.print()">
            <i class="bi bi-printer"></i> Cetak Laporan
        </button>
        <a href="#" class="btn btn-outline-success">
            <i class="bi bi-download"></i> Export Excel
        </a>
    </div>
</div>

<!-- Statistik Utama -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Buku</h6>
                        <h3 class="mb-0">{{ $totalBooks ?? 0 }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-book display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Anggota</h6>
                        <h3 class="mb-0">{{ $totalMembers ?? 0 }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-people display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Peminjaman Aktif</h6>
                        <h3 class="mb-0">{{ $activeBorrowings ?? 0 }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-journal-check display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Reservasi Pending</h6>
                        <h3 class="mb-0">{{ $pendingReservations ?? 0 }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-calendar-clock display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Adiwiyata -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-leaf"></i> Statistik Adiwiyata</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-success">{{ $adiwiyataBooks ?? 0 }}</h4>
                            <small class="text-muted">Buku Adiwiyata</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-success">{{ $adiwiyataBorrowings ?? 0 }}</h4>
                            <small class="text-muted">Peminjaman Adiwiyata</small>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-success">{{ $totalLiteracyPoints ?? 0 }}</h4>
                            <small class="text-muted">Total Poin Literasi</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-success">{{ $activeMembers ?? 0 }}</h4>
                            <small class="text-muted">Anggota Aktif</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-graph-up"></i> Aktivitas Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @forelse($recentActivities ?? [] as $activity)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $activity->member->user->name ?? 'Unknown' }}</strong>
                            <br><small class="text-muted">{{ $activity->activity_type ?? 'Activity' }}</small>
                        </div>
                        <span class="badge bg-success">+{{ $activity->points ?? 0 }}</span>
                    </div>
                    @empty
                    <div class="text-center py-3">
                        <i class="bi bi-activity text-muted"></i>
                        <p class="text-muted mb-0">Belum ada aktivitas terbaru</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Laporan Detail -->
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-table"></i> Buku Terpopuler</h5>
            </div>
            <div class="card-body">
                @if(isset($popularBooks) && $popularBooks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Rank</th>
                                <th>Judul Buku</th>
                                <th>Kategori</th>
                                <th>Dipinjam</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($popularBooks as $index => $book)
                            <tr>
                                <td>
                                    @if($index < 3)
                                        <span class="badge bg-warning text-dark">#{{ $index + 1 }}</span>
                                    @else
                                        <span class="text-muted">#{{ $index + 1 }}</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $book->title ?? 'Unknown' }}</strong><br>
                                    <small class="text-muted">{{ $book->author ?? 'Unknown' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $book->category->name ?? 'Unknown' }}</span>
                                </td>
                                <td>{{ $book->borrow_count ?? 0 }}x</td>
                                <td>
                                    @if(isset($book->avg_rating))
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $book->avg_rating)
                                                    <i class="bi bi-star-fill"></i>
                                                @else
                                                    <i class="bi bi-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <small class="text-muted">{{ number_format($book->avg_rating, 1) }}/5</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-book text-muted display-4"></i>
                    <p class="text-muted mt-2">Belum ada data buku terpopuler</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-trophy"></i> Top Anggota</h5>
            </div>
            <div class="card-body">
                @if(isset($topMembers) && $topMembers->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($topMembers as $index => $member)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            @if($index < 3)
                                <span class="badge bg-warning text-dark me-2">#{{ $index + 1 }}</span>
                            @else
                                <span class="text-muted me-2">#{{ $index + 1 }}</span>
                            @endif
                            <div>
                                <strong>{{ $member->user->name ?? 'Unknown' }}</strong><br>
                                <small class="text-muted">{{ $member->member_id_number ?? 'No ID' }}</small>
                            </div>
                        </div>
                        <span class="badge bg-success">{{ $member->total_points ?? 0 }} poin</span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-trophy text-muted display-4"></i>
                    <p class="text-muted mt-2">Belum ada data top anggota</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Footer Laporan -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-body text-center">
                <small class="text-muted">
                    Laporan ini dibuat pada {{ now()->format('d/m/Y H:i:s') }} oleh {{ Auth::user()->name ?? 'Admin' }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
