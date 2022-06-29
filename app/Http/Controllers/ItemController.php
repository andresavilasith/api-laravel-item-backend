<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::paginate(5);

        return response()->json([
            'items' => $items,
            'status' => 'success'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $item = $request->all();

        if ($request->hasFile('imagen')) {
            $item['imagen'] = $request->file('imagen')->store('images', 'public');
        }

        Item::create($item);

        return response()->json([
            'status' => 'success',
            'message' => 'Item successfully stored',
            'item' => $item
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return response()->json([
            'item' => $item,
            'status' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return response()->json([
            'item' => $item,
            'status' => 'success',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {

        $itemData = $request->all();

        if ($request->hasFile('imagen')) {
            Storage::delete('public/' . $item->imagen);
            $itemData['imagen'] = $request->file('imagen')->store('images', 'public');
        }

        $item->update($itemData);

        return response()->json([
            'status' => 'success',
            'message' => 'Item successfully updated',
            'item' => $item
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();

        $items = Item::paginate(5);

        return response()->json([
            'status' => 'success',
            'message' => 'Item successfully remove',
            'items' => $items
        ]);
    }
}
