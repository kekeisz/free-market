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
    /**
     * 出品フォーム表示（PG08 /sell）
     */
    public function create()
    {
        // カテゴリと状態マスタを取得してフォームに渡す
        $categories = Category::all();
        $conditions = Condition::all();

        return view('page.sell', compact('categories', 'conditions'));
    }

    /**
     * 出品登録処理（FN028, FN029）
     */
    public function store(SellRequest $request)
    {
        $user      = Auth::user();
        $validated = $request->validated();

        // 商品レコード作成
        $item = new Item();

        $item->user_id     = $user->id;                   // 出品者
        $item->buyer_id    = null;                        // まだ購入者はいない
        $item->name        = $validated['name'];
        $item->description = $validated['description'] ?? null;
        $item->price       = $validated['price'];
        $item->status      = 'for_sale';                  // for_sale / sold など
        $item->is_sold     = false;                       // まだ未売

        // 状態（condition_id）
        $item->condition_id = $validated['condition_id'];

        // 画像アップロード（FN029）
        if ($request->hasFile('image')) {
            // storage/app/public/items に保存（php artisan storage:link 必須）
            $path = $request->file('image')->store('items', 'public');
            $item->image = $path;
        }

        $item->save();

        // カテゴリの紐付け（多対多）
        if (!empty($validated['categories'] ?? null)) {
            $item->categories()->sync($validated['categories']);
        }

        // 出品完了後は詳細ページへ
        return redirect()
            ->route('item.show', ['item_id' => $item->id])
            ->with('status', '商品を出品しました。');
    }
}
