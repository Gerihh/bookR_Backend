<?php

namespace App\Http\Controllers;

use App\Models\Node;
use Illuminate\Http\Request;

class NodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nodes = Node::all();
        return response()->json($nodes, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $node = Node::create($request->all());

        if ($node) {
            $elementController = new ElementController();

            $elementController->updateNodeCount($node->elementId);

            return response()->json($node, 201);
        } else {
            return response()->json(['message' => 'Failed to create node'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $node = Node::find($id);

        if ($node == null) {
            return response()->json(['message' => 'Node not found with this id'], 404);
        } else {
            return response()->json($node, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $node = Node::find($id);

        if ($node == null) {
            return response()->json(['message' => 'Node not found with this id'], 404);
        } else {
            $node->update($request->all());
            return response()->json($node, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $node = Node::find($id);

        if ($node == null) {

            return response()->json(['message' => 'Node not found with this id'], 404);
        } else {
            $node->delete();
            $elementController = new ElementController();
            $elementController->updateNodeCount($node->elementId);
            return response()->json(['message' => 'Node deleted successfully'], 200);
        }
    }
}
