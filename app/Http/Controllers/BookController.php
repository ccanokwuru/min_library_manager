<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('authors', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%")
                    ->orWhere('publisher', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('feilds', 'like', "%{$search}%");
            });
        }

        if ($request->has('author')) {
            $author = $request->input('author');
            $query->where('authors', 'like', "%{$author}%");
        }

        if ($request->has('availability')) {
            $query->where('is_available', $request->input('availability'));
        }

        $books = $query->latest()->paginate(10);
        if ($request->is('api/*')) {
            // Request is coming from API route
            return response()->json([
                'books' => $books,
            ]);;
        }
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'authors' => 'required|max:255',
            'description' => 'nullable',
            'published_date' => 'nullable|date',
            'isbn' => 'nullable|string',
            'description' => 'nullable|string',
            'feilds' => 'nullable|string',
            'publisher' => 'nullable|string',
            'is_available' => 'nullable|boolean',
            'quantity' => 'nullable',
            'edition' => 'nullable',
        ]);

        $book = Book::create($validated);

        if ($request->is('api/*')) {
            // Request is coming from API route
            return response()->json([
                'book' => $book,
            ]);;
        }

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'authors' => 'required|max:255',
            'description' => 'nullable',
            'published_date' => 'nullable|date',
            'isbn' => 'nullable|string',
            'description' => 'nullable|string',
            'feilds' => 'nullable|string',
            'publisher' => 'nullable|string',
            'is_available' => 'nullable|boolean',
            'quantity' => 'nullable',
            'edition' => 'nullable',
        ]);

        $book->update($validated);

        if ($request->is('api/*')) {
            // Request is coming from API route
            return response()->json([
                'book' => $book,
            ]);;
        }

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
