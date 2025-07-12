@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-4">Detail Anggota</h2>
                <table class="table table-borderless mb-0">
                    <tr><th>Nama</th><td>{{ $member->user->name ?? '-' }}</td></tr>
                    <tr><th>Email</th><td>{{ $member->user->email ?? '-' }}</td></tr>
                    <tr><th>Nomor Anggota</th><td>{{ $member->member_id_number }}</td></tr>
                    <tr><th>Role</th><td>{{ $member->role }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $member->address }}</td></tr>
                    <tr><th>No. HP</th><td>{{ $member->phone_number }}</td></tr>
                    <tr><th>Total Poin</th><td>{{ $member->total_points }}</td></tr>
                </table>
                <div class="mt-3">
                    <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.members.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                    <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
