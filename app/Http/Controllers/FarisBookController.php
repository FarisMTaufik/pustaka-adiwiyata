<?php

namespace App\Http\Controllers;

use App\Models\FarisBook;
use App\Models\FarisCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FarisBookController extends Controller
{
    public function index()
    {
        $books = FarisBook::with('category')->latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $categories = FarisCategory::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:faris_books,isbn|max:20',
            'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:faris_categories,id',
            'theme' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('cover_image');
        $data['available_quantity'] = $request->quantity;

        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('book_covers', 'public');
            $data['cover_image'] = $imagePath;
        }

        FarisBook::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show(FarisBook $book)
    {
        return view('admin.books.show', compact('book'));
    }

    public function edit(FarisBook $book)
    {
        $categories = FarisCategory::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, FarisBook $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:faris_books,isbn,' . $book->id . '|max:20',
            'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:faris_categories,id',
            'theme' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('cover_image');
        $quantityDifference = $request->quantity - $book->quantity;
        $data['available_quantity'] = $book->available_quantity + $quantityDifference;
        if ($data['available_quantity'] < 0) {
            $data['available_quantity'] = 0;
        }

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $imagePath = $request->file('cover_image')->store('book_covers', 'public');
            $data['cover_image'] = $imagePath;
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(FarisBook $book)
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }
}
