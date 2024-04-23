<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Element;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return response()->json($books, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $book = Book::create($request->all());
        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book = Book::find($id);

        if ($book == null) {
            return response()->json(['message' => 'Book not found with this id'], 404);
        } else {
            return response()->json($book, 201);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if ($book == null) {
            return response()->json(['message' => 'Book not found with this id'], 404);
        } else {
            $book->update($request->all());
            return response()->json($book, 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if ($book == null) {
            return response()->json(['message' => 'Book not found with this id'], 404);
        } else {
            $book->delete();
            return response()->json(['message' => 'Book deleted successfully'], 200);
        }
    }

    public function getBookByTitle($title)
    {
        $book = Book::where('title', $title)->first();
        if ($book) {
            return $book;
        } else {
            return null;
        }
    }

    public function updateElementCount($bookId)
    {
        $elements = Element::where('bookId', $bookId)->get();
        $elementCount = $elements->count();

        Book::where('id', $bookId)->update(['elementCount' => $elementCount]);
    }
}
