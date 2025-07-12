@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0">Manajemen Poin Literasi</h2>
    <a href="{{ route('admin.literacy_points.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Tambah Poin Manual
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        @if($literacyPoints->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Anggota</th>
                            <th>Aktivitas</th>
                            <th>Poin</th>
                            <th>Deskripsi</th>
                            <th>Tanggal</th>
                            <th>Total Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($literacyPoints as $point)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $point->member->user->name ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $point->member->member_id_number ?? '-' }}</small>
                            </td>
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
                            <td>
                                <strong class="text-success">{{ $point->member->total_points ?? 0 }}</strong>
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
            <div class="text-center py-5">
                <i class="bi bi-star display-1 text-muted"></i>
                <h5 class="mt-3 text-muted">Belum ada data poin literasi</h5>
                <p class="text-muted">Mulai dengan menambahkan poin literasi manual</p>
                <a href="{{ route('admin.literacy_points.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Tambah Poin Pertama
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Statistik Poin Literasi -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Poin</h6>
                        <h3 class="mb-0">{{ $literacyPoints->sum('points') }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-star-fill display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Anggota Aktif</h6>
                        <h3 class="mb-0">{{ $literacyPoints->unique('member_id')->count() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-people-fill display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Aktivitas</h6>
                        <h3 class="mb-0">{{ $literacyPoints->count() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-activity display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
