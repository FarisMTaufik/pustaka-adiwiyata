<?php

// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FarisBook;
use App\Models\FarisMember;
use App\Models\FarisBorrowing;
use App\Models\FarisLiteracyPoint;
use App\Models\FarisReservation; // Import Reservation model
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate; // Untuk Gate

class AdminController extends Controller
{
    /**
     * Tampilkan dashboard admin.
     */
    public function index()
    {
        $totalBooks = FarisBook::count();
        $totalMembers = FarisMember::count();
        $borrowedBooks = FarisBorrowing::where('status', 'borrowed')->count();
        $overdueBooks = FarisBorrowing::where('status', 'overdue')->count();
        $pendingReservations = FarisReservation::where('status', 'pending')->count(); // Statistik reservasi

        // Statistik peminjaman per bulan
        $borrowingStats = FarisBorrowing::select(
                DB::raw('MONTH(borrow_date) as month'),
                DB::raw('COUNT(*) as total_borrowings')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Anggota paling aktif (berdasarkan total poin)
        $topMembers = FarisMember::with('user')
            ->orderByDesc('total_points')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBooks', 'totalMembers', 'borrowedBooks', 'overdueBooks', 'pendingReservations',
            'borrowingStats', 'topMembers'
        ));
    }

    /**
     * Tampilkan halaman laporan dan statistik.
     */
    public function reports()
    {
        // Contoh laporan: Buku terlaris
        $topBorrowedBooks = FarisBorrowing::select('book_id', DB::raw('count(*) as total_borrows'))
            ->groupBy('book_id')
            ->orderByDesc('total_borrows')
            ->with('book')
            ->take(10)
            ->get();

        // Contoh laporan: Anggota dengan denda tertinggi
        $membersWithFines = FarisBorrowing::select('member_id', DB::raw('sum(fine_amount) as total_fine'))
            ->where('fine_amount', '>', 0)
            ->groupBy('member_id')
            ->orderByDesc('total_fine')
            ->with('member.user')
            ->take(10)
            ->get();

        // Contoh laporan: Poin literasi per aktivitas
        $pointsByActivity = FarisLiteracyPoint::select('activity_type', DB::raw('sum(points) as total_points_earned'))
            ->groupBy('activity_type')
            ->get();

        return view('admin.reports', compact('topBorrowedBooks', 'membersWithFines', 'pointsByActivity'));
    }
}
