<?php

namespace App\Http\Controllers;

use App\Models\FarisCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FarisCategoryController extends Controller
{
    public function index()
    {
        $categories = FarisCategory::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:faris_categories,name|max:255',
            'theme' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        FarisCategory::create($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(FarisCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, FarisCategory $category)
    {
        $request->validate([
            'name' => 'required|string|unique:faris_categories,name,' . $category->id . '|max:255',
            'theme' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(FarisCategory $category)
    {
        if ($category->books()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kategori karena masih ada buku yang terkait.');
        }
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
