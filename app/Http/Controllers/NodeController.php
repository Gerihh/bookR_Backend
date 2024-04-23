<?php

namespace App\Http\Controllers;

use App\Models\Element;
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

    public function getNodesForElement($elementId)
    {
        $nodes = Node::where('elementId', $elementId)->get();

        if ($nodes->isEmpty()) {
            return response()->json(['message' => 'There are no nodes for this element'], 404);
        } else {
            return response()->json($nodes, 201);
        }
    }

    public function getNodesForElementWithName($name)
    {
        $element = Element::where('name', $name)->first();

        if ($element) {
            $nodes = Node::where('elementId', $element->id)->get();

            if ($nodes->isEmpty()) {
                return response()->json(['message' => 'There are no nodes for this element'], 404);
            } else {
                return response()->json($nodes, 201);
            }
        } else {
            return response()->json(['message' => 'Element not found with the given name'], 404);
        }
    }


    public function createChildNode(Request $request, $parentNodeId)
    {
        $parentNode = Node::find($parentNodeId);

        if ($parentNode == null) {
            return response()->json(['message' => 'Parent node not found with this id'], 404);
        } else {
            $childNode = new Node();
            $childNode->parentNodeId = $parentNode->id;
            $childNode->elementId = $parentNode->elementId;
            $childNode->fill($request->all());
            $childNode->save();

            $elementController = new ElementController();
            $elementController->updateNodeCount($childNode->elementId);

            return response()->json($childNode, 201);
        }
    }

    public function getChildNodes($parentNodeId)
    {
        $childNodes = Node::where('parentNodeId', $parentNodeId)->get();

        if ($childNodes->isEmpty()) {
            return response()->json(['message' => 'There are no child nodes for this node'], 404);
        } else {
            return response()->json($childNodes, 201);
        }
    }

    public function getParentNode($childNodeId)
    {
        $parentNode = Node::find($childNodeId)->parentNodeId;

        if ($parentNode === null) {
            return response()->json(['message' => 'Parent node not found for this child node'], 404);
        }

        $nodeController = new NodeController();
        $parentNodeData = $nodeController->show($parentNode);

        if (!$parentNodeData) {
            return response()->json(['message' => 'Error retrieving parent node data'], 500);
        } else {
            return response()->json($parentNodeData->original, 200);
        }
    }
}
