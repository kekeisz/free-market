<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Item $item) {
        $userId = Auth::id();

        Like::firstOrCreate([
            'user_id' => $userId,
            'item_id' => $item->id,
        ]);
        return back();
    }

    public function delete(Item $item) {
        $userId = Auth::id();

        Like::where('user_id', $userId)
            ->where('item_id', $item->id)
            ->delete();

        return back();
    }
}
