<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemFilterRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;

// todo: add item categories
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ItemFilterRequest $request)
    {
        $validated = $request->validated();
        $validated['userId'] = auth()->user()->id;

        $items = Item::with(['itemSizes' => function($itemSizes) use ($validated){
            $itemSizes->whereHas(['users' => function ($users) use ($validated){
                $users->where('id', $validated['userId']);
            }]);
        }])->paginate(25);

        return ItemResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //todo: create item if it does not exist and add item to users tracked items
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //todo: show the item
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
        //todo: update item tracking
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //todo: remove item from users tracked items AND remove item entirely if no user is tracking it anymore
    }
}
