<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrows = Borrow::all();
        return view('borrows.index', compact('borrows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('borrows.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Add validation rules based on your Borrow model
        ]);

        $borrow = Borrow::create($validated);

        if ($request->is('api/*')) {
            // Request is coming from API route
            return response()->json([
                'borrow' => $borrow,
            ]);;
        }

        return redirect()->route('borrows.index')->with('success', 'Borrow created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrow $borrow)
    {
        return view('borrows.show', compact('borrow'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrow $borrow)
    {
        return view('borrows.edit', compact('borrow'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrow $borrow)
    {
        $validated = $request->validate([
            // Add validation rules based on your Borrow model
        ]);

        $borrow->update($validated);

        if ($request->is('api/*')) {
            // Request is coming from API route
            return response()->json([
                'borrow' => $borrow,
            ]);;
        }

        return redirect()->route('borrows.index')->with('success', 'Borrow updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrow $borrow)
    {
        $borrow->delete();

        return redirect()->route('borrows.index')->with('success', 'Borrow deleted successfully.');
    }
}
