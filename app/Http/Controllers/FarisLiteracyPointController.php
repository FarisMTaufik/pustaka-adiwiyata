<?php

// app/Http/Controllers/AdiwiyataLiteracyPointController.php (Untuk Admin)
namespace App\Http\Controllers;

use App\Models\FarisLiteracyPoint;
use App\Models\FarisMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate; // Untuk Gate

class FarisLiteracyPointController extends Controller
{
    /**
     * Tampilkan daftar poin literasi (log) di admin.
     */
    public function index()
    {
        $literacyPoints = FarisLiteracyPoint::with('member.user')->latest()->paginate(10);
        return view('admin.literacy_points.index', compact('literacyPoints'));
    }

    /**
     * Tampilkan form untuk menambahkan poin literasi secara manual.
     */
    public function create() // Menggunakan create untuk form
    {
        $members = FarisMember::with('user')->get();
        return view('admin.literacy_points.create', compact('members'));
    }

    /**
     * Simpan poin literasi yang ditambahkan secara manual.
     */
    public function store(Request $request) // Menggunakan store untuk menyimpan
    {
        $request->validate([
            'member_id' => 'required|exists:faris_members,id',
            'activity_type' => 'required|string|max:255',
            'points' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $member = FarisMember::find($request->member_id);
        if ($member) {
            FarisLiteracyPoint::create($request->all());
            $member->increment('total_points', $request->points);
            return redirect()->route('admin.literacy_points.index')->with('success', 'Poin literasi berhasil ditambahkan!');
        }

        return back()->with('error', 'Anggota tidak ditemukan.');
    }
}
