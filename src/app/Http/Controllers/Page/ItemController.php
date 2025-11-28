<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Item;

class ItemController extends Controller
{
    public function show($item_id) {
        $item = Item::with([
            'user',
            'categories',
            'likes',
            'comments.user'
        ])
        ->withCount(['likes','comments'])
        ->findOrFail($item_id);//該当のproductが見つからない場合404を返す

        return view('page.item', compact('item'));
    }
}
