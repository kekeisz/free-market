<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function show($item_id) {
        $item = Item::with([
                'user',
                'categories',
                'likes',
                'comments.user'
            ])
            ->withCount(['likes', 'comments'])
            ->findOrFail($item_id); // 該当のitemが見つからない場合404

        $user = Auth::user();

        // ログインしていなければ false のまま
        $liked = false;
        if ($user) {
            // すでに eager load 済みの $item->likes コレクションから判定
            $liked = $item->likes->contains('user_id', $user->id);
        }

        // withCount で取っている likes_count をそのままビューに渡す
        $likesCount = $item->likes_count;

        return view('page.item', compact('item', 'liked', 'likesCount'));
    }
}
