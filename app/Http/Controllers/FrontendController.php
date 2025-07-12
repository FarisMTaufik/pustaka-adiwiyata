<?php

// app/Http/Controllers/FrontendController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FarisBook;
use App\Models\FarisBorrowing;
use App\Models\FarisReview;
use App\Models\FarisLiteracyPoint;
use App\Models\FarisMember;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    /**
     * Tampilkan halaman beranda.
     */
    public function index()
    {
        $latestBooks = FarisBook::latest()->take(5)->get();
        return view('frontend.home', compact('latestBooks'));
    }

    /**
     * Tampilkan daftar buku.
     */
    public function books(Request $request)
    {
        $query = FarisBook::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('theme', 'like', "%{$search}%");
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $books = $query->paginate(10);
        return view('frontend.books.index', compact('books'));
    }

    /**
     * Tampilkan detail buku.
     */
    public function showBook(FarisBook $book)
    {
        $reviews = $book->reviews()->with('member.user')->latest()->get();
        return view('frontend.books.show', compact('book', 'reviews'));
    }

    /**
     * Tampilkan dashboard anggota.
     */
    public function dashboard()
    {
        $member = Auth::user()->member; // Pastikan user punya relasi member
        if (!$member) {
            // Jika user belum punya data member, buatkan. Ini bisa terjadi saat register
            $member = FarisMember::create([
                'user_id' => Auth::id(),
                'role' => 'member', // Default role
            ]);
        }

        $borrowings = $member->borrowings()->with('book')->latest()->get();
        $literacyPoints = $member->literacyPoints()->latest()->paginate(10);

        return view('dashboard', compact('borrowings', 'literacyPoints', 'member'));
    }

    /**
     * Tampilkan halaman tentang kami.
     */
    public function about()
    {
        return view('frontend.about');
    }
}
