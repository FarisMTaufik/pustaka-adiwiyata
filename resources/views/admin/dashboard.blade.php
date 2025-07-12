@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">
            Dashboard Admin
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm p-6 text-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Total Buku</h3>
                <p class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">{{ $totalBooks }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm p-6 text-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Total Anggota</h3>
                <p class="text-4xl font-bold text-green-600 dark:text-green-400">{{ $totalMembers }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm p-6 text-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Buku Dipinjam</h3>
                <p class="text-4xl font-bold text-yellow-600 dark:text-yellow-400">{{ $borrowedBooks }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm p-6 text-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Buku Terlambat</h3>
                <p class="text-4xl font-bold text-red-600 dark:text-red-400">{{ $overdueBooks }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm p-6 text-center col-span-full md:col-span-2 lg:col-span-2 mx-auto w-full">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Reservasi Tertunda</h3>
                <p class="text-4xl font-bold text-purple-600 dark:text-purple-400">{{ $pendingReservations }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Statistik Peminjaman Bulanan</h3>
                <canvas id="borrowingChart"></canvas>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Anggota Paling Aktif (Poin Literasi)</h3>
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($topMembers as $member)
                        <li class="py-3 flex justify-between items-center">
                            <span class="text-gray-900 dark:text-gray-100">{{ $member->user->name ?? 'N/A' }}</span>
                            <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $member->total_points }} Poin</span>
                        </li>
                    @empty
                        <p class="text-gray-600 dark:text-gray-400">Belum ada data anggota aktif.</p>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('admin.reports') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                Lihat Laporan Lengkap
            </a>
        </div>
    </div>
</div>

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('borrowingChart').getContext('2d');
        const borrowingStats = @json($borrowingStats);

        const labels = borrowingStats.map(stat => {
            const date = new Date(2000, stat.month - 1, 1); // Tahun dummy, bulan asli
            return date.toLocaleString('id-ID', { month: 'long' });
        });
        const data = borrowingStats.map(stat => stat.total_borrowings);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Peminjaman'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // Hide legend
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
