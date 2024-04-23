<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Element;
use App\Models\Node;
use Illuminate\Http\Request;

class ElementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $elements = Element::all();
        return response()->json($elements, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $element = Element::create($request->all());

        if ($element) {
            return response()->json($element, 201);
        } else {
            return response()->json(['message' => 'Failed to create element'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $element = Element::find($id);

        if ($element == null)
        {
            return response()->json(['message' => 'Element not found with this id'], 404);
        }
        else
        {
            return response()->json($element, 201);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $element = Element::find($id);

        if ($element == null)
        {
            return response()->json(['message' => 'Element not found with this id'], 404);
        }
        else
        {
            $element->update($request->all());
            return response()->json($element, 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $element = Element::find($id);

        if ($element == null)
        {
            return response()->json(['message' => 'Element not found with this id'], 404);
        }
        else
        {
            $element->delete();
            return response()->json(['message' => 'Element deleted successfully'], 200);
        }
    }

    public function getElementsForBook($bookId)
    {
        $elements = Element::where('bookId', $bookId)->get();

        if ($elements->isEmpty())
        {
            return response()->json(['message' => 'There are no elements for this book'], 404);
        }
        else
        {
            return response()->json($elements, 201);
        }
    }

    public function getElementsForBookWithName($title)
    {
       $book = Book::where('title', $title)->first();

       if ($book) {
        $elements = Element::where('bookId', $book->id)->get();

           if ($elements->isEmpty()) {
               return response()->json(['message' => 'There are no elements for this book'], 404);
           } else {
               return response()->json($elements, 201);
           }
       } else {
           return response()->json(['message' => 'Book not found with this title'], 404);
       }
    }

    public function updateNodeCount($elementId)
    {
        $nodes = Node::where('elementId', $elementId)->get();
        $nodeCount = $nodes->count();

        Element::where('id', $elementId)->update(['nodeCount' => $nodeCount]);
    }
}
