<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FarisMember;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class FarisMemberController extends Controller
{
    public function index()
    {
        $members = FarisMember::with('user')->latest()->paginate(10);
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'member_id_number' => 'nullable|string|unique:faris_members,member_id_number|max:50',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'role' => ['required', Rule::in(['member', 'admin'])],
            'total_points' => 'nullable|integer|min:0',
        ]);

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Create member for the user
        $member = FarisMember::create([
            'user_id' => $user->id,
            'member_id_number' => $request->member_id_number,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'total_points' => $request->total_points ?? 0,
        ]);

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function show(FarisMember $member)
    {
        $member->load('user', 'borrowings.book', 'literacyPoints');
        return view('admin.members.show', compact('member'));
    }

    public function edit(FarisMember $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, FarisMember $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($member->user->id ?? ''),
            'password' => 'nullable|string|min:8',
            'member_id_number' => 'nullable|string|unique:faris_members,member_id_number,' . $member->id . '|max:50',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'role' => ['required', Rule::in(['member', 'admin'])],
            'total_points' => 'required|integer|min:0',
        ]);

        // Update member data
        $member->update($request->all());

        // Update user data
        if ($member->user) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $member->user->update($userData);
        }

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy(FarisMember $member)
    {
        $member->delete();
        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus!');
    }
}
