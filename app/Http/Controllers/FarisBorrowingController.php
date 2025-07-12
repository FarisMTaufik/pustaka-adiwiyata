<?php

namespace App\Http\Controllers;

use App\Models\FarisBorrowing;
use App\Models\FarisBook;
use App\Models\FarisMember;
use App\Models\FarisLiteracyPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class FarisBorrowingController extends Controller
{
    public function requestBorrow(Request $request, FarisBook $book)
    {
        $member = Auth::user()->member;

        if (!$member) {
            return back()->with('error', 'Anda belum terdaftar sebagai anggota. Silakan hubungi pustakawan.');
        }

        if ($book->available_quantity <= 0) {
            return back()->with('error', 'Buku ini sedang tidak tersedia. Anda bisa mereservasinya.');
        }

        $existingBorrowing = FarisBorrowing::where('book_id', $book->id)
            ->where('member_id', $member->id)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->first();

        if ($existingBorrowing) {
            return back()->with('error', 'Anda sudah meminjam buku ini.');
        }

        FarisBorrowing::create([
            'book_id' => $book->id,
            'member_id' => $member->id,
            'borrow_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(7),
            'status' => 'borrowed',
        ]);

        $book->decrement('available_quantity');

        return back()->with('success', 'Peminjaman buku berhasil!');
    }

    public function index(Request $request)
    {
        Gate::authorize('admin');

        $query = FarisBorrowing::with('book', 'member.user');

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })->orWhereHas('member.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $borrowings = $query->latest()->paginate(10);
        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function returnBook(FarisBorrowing $borrowing)
    {
        Gate::authorize('admin');

        if ($borrowing->status === 'returned') {
            return back()->with('info', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        $borrowing->update([
            'return_date' => Carbon::now(),
            'status' => 'returned',
        ]);

        $fineAmount = 0;
        if (Carbon::parse($borrowing->return_date)->greaterThan($borrowing->due_date)) {
            $daysLate = Carbon::parse($borrowing->return_date)->diffInDays($borrowing->due_date);
            $fineAmount = $daysLate * 500;
            $borrowing->update(['fine_amount' => $fineAmount]);
        }

        $borrowing->book->increment('available_quantity');

        if ($borrowing->book->theme) {
            $points = 10;
            FarisLiteracyPoint::create([
                'member_id' => $borrowing->member_id,
                'activity_type' => 'Peminjaman Buku Adiwiyata',
                'points' => $points,
                'reference_id' => $borrowing->id,
                'description' => 'Peminjaman dan pengembalian buku: ' . $borrowing->book->title,
            ]);
            $borrowing->member->increment('total_points', $points);
        }

        $firstReservation = $borrowing->book->reservations()
            ->where('status', 'pending')
            ->orderBy('reservation_date')
            ->first();

        if ($firstReservation) {
            $firstReservation->update(['status' => 'ready_for_pickup']);
            return back()->with('success', 'Buku berhasil dikembalikan. Denda: Rp ' . number_format($fineAmount, 0, ',', '.') . '. Buku sekarang tersedia untuk reservasi berikutnya.');
        }

        return back()->with('success', 'Buku berhasil dikembalikan. Denda: Rp ' . number_format($fineAmount, 0, ',', '.'));
    }

    public function cancelBorrowing(FarisBorrowing $borrowing)
    {
        Gate::authorize('admin');

        if ($borrowing->status === 'borrowed' || $borrowing->status === 'overdue') {
            $borrowing->book->increment('available_quantity');
        }
        $borrowing->delete();

        return back()->with('success', 'Peminjaman berhasil dibatalkan.');
    }
}
