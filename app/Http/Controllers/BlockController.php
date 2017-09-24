<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Block;

class BlockController extends Controller
{
    public function index()
    {
        return Block::paginate(5);
    }

    public function show(Block $block)
    {
        return $block;
    }

    public function store(Request $request)
    {
        $block = new Block();
        $block->body =$request->get('body');
        $block->save();

        return response()->json($block, 201);
    }

    public function update(Request $request, Block $block)
    {
        $block->body =$request->get('body');
        $block->save();

        return response()->json($block, 200);
    }

    public function delete(Block $block)
    {
        $block->delete();

        return response()->json(null, 204);
    }
}
