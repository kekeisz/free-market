<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\ShippingAddress;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * 購入確認画面
     */
    public function confirm($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        if ($item->is_sold) {
            return view('page.purchase_sold', compact('item', 'user'));
        }

        // このユーザー & この商品に対する配送先が既にあるか確認
        $shippingAddressRecord = ShippingAddress::where('user_id', $user->id)
            ->where('item_id', $item->id)
            ->first();

        // 表示用の最終的な住所
        $shippingAddress = [
            'name'     => $shippingAddressRecord->name     ?? $user->name,
            'postcode' => $shippingAddressRecord->postcode ?? $user->postcode,
            'address'  => $shippingAddressRecord->address  ?? $user->address,
        ];

        return view(
            'page.purchase',
            compact('item', 'user', 'shippingAddressRecord', 'shippingAddress')
        );
    }


    /**
     * 購入処理
     */
    public function purchase(PurchaseRequest $request, $item_id)
    {
        $validated     = $request->validated();
        $paymentMethod = $validated['payment_method'];

        try {
            DB::beginTransaction();

            $user = Auth::user();

            // 商品を更新ロック付きで取得
            $item = Item::where('id', $item_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($item->user_id === $user->id) {
                DB::rollBack();
                return back()->withErrors('自分が出品した商品は購入できません。');
            }

            if ($item->is_sold) {
                DB::rollBack();
                return response()
                    ->view('page.purchase_sold', compact('item', 'user'), Response::HTTP_CONFLICT);
            }

            // ★配送先レコードが存在しない場合はプロフィール住所から作成
            ShippingAddress::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                ],
                [
                    'name'     => $user->name,
                    'postcode' => $user->postcode,
                    'address'  => $user->address,
                ]
            );

            // 商品を購入済みにする
            $item->is_sold  = true;
            $item->buyer_id = $user->id;
            $item->save();

            DB::commit();

            return redirect('/mypage?page=buy')
                ->with('success', '購入が完了しました（支払い方法：'
                    . ($paymentMethod === 'convenience' ? 'コンビニ払い' : 'カード')
                    . '）');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('購入処理中にエラーが発生しました。もう一度お試しください。');
        }
    }


    /**
     * 送付先住所変更画面
     */
    public function address($item_id)
    {
        $item = Item::findOrFail($item_id);

        if ($item->is_sold) {
            return redirect()
                ->route('purchase.confirm', $item->id)
                ->withErrors('この商品はすでに購入されています。');
        }

        $user = Auth::user();

        $shippingAddressRecord = ShippingAddress::where('user_id', $user->id)
            ->where('item_id', $item->id)
            ->first();

        $shippingAddress = [
            'name'     => $shippingAddressRecord->name     ?? $user->name,
            'postcode' => $shippingAddressRecord->postcode ?? $user->postcode,
            'address'  => $shippingAddressRecord->address  ?? $user->address,
        ];

        return view('page.address', compact('item', 'user', 'shippingAddressRecord', 'shippingAddress'));
    }


    /**
     * 送付先住所の更新
     */
    public function addressUpdate(AddressRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        if ($item->is_sold) {
            return redirect()
                ->route('purchase.confirm', $item->id)
                ->withErrors('この商品はすでに購入されています。');
        }

        $user = Auth::user();

        // 商品ごとの配送先を更新
        ShippingAddress::updateOrCreate(
            [
                'user_id' => $user->id,
                'item_id' => $item->id,
            ],
            [
                'name'     => $request->name,
                'postcode' => $request->postcode,
                'address'  => $request->address,
            ]
        );

        return redirect()
            ->route('purchase.confirm', $item->id)
            ->with('success', '送付先住所を更新しました。');
    }
}
