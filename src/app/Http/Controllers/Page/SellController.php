<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellRequest;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('page.sell', compact('categories', 'conditions'));
    }

    public function store(SellRequest $request)
    {
        $user      = Auth::user();
        $validated = $request->validated();

        $item = new Item();
        $item->user_id      = $user->id;
        $item->buyer_id     = null;
        $item->name         = $validated['name'];
        $item->brand        = $validated['brand'] ?? null;
        $item->description  = $validated['description'] ?? null;
        $item->price        = $validated['price'];
        $item->condition_id = $validated['condition_id'];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $item->image = $path;
        }

        $item->save();

        if (!empty($validated['categories'] ?? null)) {
            $item->categories()->sync($validated['categories']);
        }

        return redirect()
            ->route('item.show', ['item_id' => $item->id])
            ->with('status', '商品を出品しました。');
    }
}
