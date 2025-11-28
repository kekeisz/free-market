<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function confirm($item_id) {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        if ($item->is_sold) {
            return view('page.purchase_sold', compact('item', 'user'));
        }

        return view('page.purchase', compact('item', 'user'));
    }

    public function purchase(PurchaseRequest $request, $item_id) {
        $validated = $request->validated();
        $paymentMethod = $validated['payment_method'];

        try {
            DB::beginTransaction();

            // ここで対象商品を「更新ロック付き」で取得
            $item = Item::where('id', $item_id)
                ->lockForUpdate()
                ->firstOrFail();

            // すでに購入済みなら 409 で弾く
            if ($item->is_sold) {
                DB::rollBack();

                return response()
                    ->view('page.purchase_sold', compact('item'), Response::HTTP_CONFLICT);
                // or return back()->withErrors('この商品は既に購入されています。');
            }

            // 購入状態にする
            $item->is_sold = true;
            $item->save();

            // TODO: 購入履歴テーブルができたらここでレコード作成

            DB::commit();

            return redirect('/mypage?page=buy')
                ->with('success', '購入が完了しました（支払い方法：' . ($paymentMethod === 'convenience' ? 'コンビニ払い' : 'カード') . '）');

        } catch (\Throwable $e) {
            DB::rollBack();

            // とりあえず今回は簡単に back + エラーでOK
            return back()->withErrors('購入処理中にエラーが発生しました。もう一度お試しください。');
        }
    }

    public function address($item_id)
    {
        $item = Item::findOrFail($item_id);

        if ($item->is_sold) {
            return redirect()
                ->route('purchase.confirm', $item->id)
                ->withErrors('この商品はすでに購入されています。');
        }

        $user = Auth::user();

        return view('page.address', compact('item', 'user'));
    }

    public function addressUpdate(AddressRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        if ($item->is_sold) {
            return redirect()
                ->route('purchase.confirm', $item->id)
                ->withErrors('この商品はすでに購入されています。');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // users テーブル側のカラム名に合わせて更新
        // 以前「postcode, address, profile_image を追加した」と言っていたのでそれに合わせる
        $user->name     = $request->input('name');
        $user->postcode = $request->input('postcode');
        $user->address  = $request->input('address');
        // building 用カラムがまだ無ければここはコメントアウトでOK
        // $user->building = $request->input('building');
        $user->save();

        return redirect()
            ->route('purchase.confirm', $item->id)
            ->with('success', '送付先住所を更新しました。');
    }
}
