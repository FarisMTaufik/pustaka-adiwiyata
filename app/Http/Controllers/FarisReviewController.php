<?php

namespace App\Http\Controllers;

use App\Models\FarisReview;
use App\Models\FarisBook;
use App\Models\FarisMember;
use App\Models\FarisLiteracyPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarisReviewController extends Controller
{
    public function store(Request $request, FarisBook $book)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $member = Auth::user()->member;

        if (!$member) {
            return back()->with('error', 'Anda belum terdaftar sebagai anggota.');
        }

        $existingReview = FarisReview::where('book_id', $book->id)
            ->where('member_id', $member->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk buku ini.');
        }

        FarisReview::create([
            'book_id' => $book->id,
            'member_id' => $member->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $points = 5;
        FarisLiteracyPoint::create([
            'member_id' => $member->id,
            'activity_type' => 'Ulasan Buku',
            'points' => $points,
            'reference_id' => $book->id,
            'description' => 'Ulasan untuk buku: ' . $book->title,
        ]);
        $member->increment('total_points', $points);

        return back()->with('success', 'Ulasan Anda berhasil ditambahkan!');
    }
}
