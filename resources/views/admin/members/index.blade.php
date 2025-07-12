@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h4 mb-0">Daftar Anggota</h2>
    <a href="{{ route('admin.members.create') }}" class="btn btn-primary">Tambah Anggota</a>
</div>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Nomor Anggota</th>
                <th>Role</th>
                <th>Alamat</th>
                <th>No. HP</th>
                <th>Poin</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $member->user->name ?? '-' }}</td>
                    <td>{{ $member->user->email ?? '-' }}</td>
                    <td>{{ $member->member_id_number }}</td>
                    <td>{{ $member->role }}</td>
                    <td>{{ $member->address }}</td>
                    <td>{{ $member->phone_number }}</td>
                    <td>{{ $member->total_points }}</td>
                    <td>
                        <a href="{{ route('admin.members.show', $member) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.members.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada data anggota.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if(method_exists($members, 'links'))
    <div class="mt-3">{{ $members->links() }}</div>
@endif
@endsection
