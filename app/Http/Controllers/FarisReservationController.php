<?php

namespace App\Http\Controllers;

use App\Models\FarisReservation;
use App\Models\FarisBook;
use App\Models\FarisMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class FarisReservationController extends Controller
{
    public function store(Request $request, FarisBook $book)
    {
        $member = Auth::user()->member;

        if (!$member) {
            return back()->with('error', 'Anda belum terdaftar sebagai anggota. Silakan hubungi pustakawan.');
        }

        if ($book->available_quantity > 0) {
            return back()->with('error', 'Buku ini tersedia, silakan pinjam langsung.');
        }

        $existingReservation = FarisReservation::where('book_id', $book->id)
            ->where('member_id', $member->id)
            ->whereIn('status', ['pending', 'ready_for_pickup'])
            ->first();

        if ($existingReservation) {
            return back()->with('info', 'Anda sudah mereservasi buku ini atau reservasi Anda sedang dalam proses.');
        }

        FarisReservation::create([
            'book_id' => $book->id,
            'member_id' => $member->id,
            'reservation_date' => Carbon::now(),
            'expiration_date' => Carbon::now()->addDays(3),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Buku berhasil direservasi. Anda akan diberitahu jika buku tersedia.');
    }

    public function index(Request $request)
    {
        Gate::authorize('admin');

        $query = FarisReservation::with('book', 'member.user');

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

        $reservations = $query->latest()->paginate(10);
        return view('admin.reservations.index', compact('reservations'));
    }

    public function markReadyForPickup(FarisReservation $reservation)
    {
        Gate::authorize('admin');

        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Reservasi tidak dalam status "pending".');
        }

        $reservation->update([
            'status' => 'ready_for_pickup',
            'expiration_date' => Carbon::now()->addDays(3),
        ]);

        return back()->with('success', 'Reservasi berhasil ditandai siap diambil. Anggota telah diberitahu.');
    }

    public function cancelReservation(FarisReservation $reservation)
    {
        Gate::authorize('admin');

        $reservation->update(['status' => 'cancelled']);
        return back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
}
