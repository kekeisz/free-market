<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page');        //URLの ?mylist=mylist などを取得
        $keyword = $request->query('keyword');  //URLの ?keyword=スニーカー などを取得

        // 基本のクエリ（全商品、Sold含む。自分の出品は除外）
        $query = Item::query()
            ->withCount(['likes','comments'])
            ->when(Auth::check(),
            function ($q) {
                $q->where('user_id', '!=', Auth::id()); // ログインしていたら自分の商品を除外
            });

        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%"); //検索（部分一致）
        }

        if ($page === 'mylist') { ///?page=mylistなのかを判別
            if (!Auth::check()) {
                $items = collect(); //空のコレクション:何も表示されない
            } else {
                $items = Item::query()
                    ->withCount(['likes', 'comments'])
                    ->whereHas('likes', function ($q) {  //Likesテーブルにあるproductだけを取得(likesはProductの関数名)
                        $q->where('user_id', Auth::id());//そのうちuser_id = ログインユーザーだった場合そのProductを取得
                    })
                    ->get();
            }
        } else {
            //mylistでない場合、通常の一覧を表示
            $items = $query->get();
        }

        return view('page.top', [
            'items' => $items,
            'page'     => $page,
            'keyword'  => $keyword,
        ]);
    }
}
