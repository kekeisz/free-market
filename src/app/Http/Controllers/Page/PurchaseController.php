<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\ShippingAddress;
use App\Models\StripeCheckout;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

class PurchaseController extends Controller
{
    private function paymentSessionKey(int $itemId): string
    {
        return "purchase.payment_method.{$itemId}";
    }

    public function confirm($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        if ($item->is_sold) {
            return view('page.purchase_sold', compact('item', 'user'));
        }

        $paymentMethod = session($this->paymentSessionKey((int) $item->id), '');

        $shippingAddressRecord = ShippingAddress::where('user_id', $user->id)
            ->where('item_id', $item->id)
            ->first();

        $shippingAddress = [
            'postcode' => $shippingAddressRecord->postcode ?? $user->postcode,
            'address'  => $shippingAddressRecord->address ?? $user->address,
            'building' => $shippingAddressRecord->building ?? $user->building,
        ];

        return view('page.purchase', compact('item', 'user', 'shippingAddressRecord', 'shippingAddress', 'paymentMethod'));
    }

    public function purchase(PurchaseRequest $request, $item_id)
    {
        $paymentMethod = $request->validated()['payment_method'];
        session()->put($this->paymentSessionKey((int) $item_id), $paymentMethod);

        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        if ((int) $item->user_id === (int) $user->id) {
            return back()->withErrors(['purchase' => '自分が出品した商品は購入できません。']);
        }

        if ($item->is_sold) {
            return response()->view('page.purchase_sold', compact('item', 'user'), Response::HTTP_CONFLICT);
        }

        ShippingAddress::firstOrCreate(
            ['user_id' => $user->id, 'item_id' => $item->id],
            ['name' => $user->name, 'postcode' => $user->postcode, 'address' => $user->address, 'building' => $user->building]
        );

        Stripe::setApiKey(config('services.stripe.secret'));

        $stripeType = $paymentMethod === 'convenience' ? 'konbini' : 'card';

        $session = CheckoutSession::create([
            'mode' => 'payment',
            'payment_method_types' => [$stripeType],
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => (int) $item->price,
                    'product_data' => ['name' => $item->name],
                ],
            ]],
            'success_url' => url('/purchase/success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => url('/purchase/cancel') . '?item_id=' . $item->id,
        ]);

        StripeCheckout::create([
            'session_id' => $session->id,
            'item_id' => (int) $item->id,
            'buyer_id' => (int) $user->id,
            'status' => 'pending',
        ]);

        session()->forget($this->paymentSessionKey((int) $item_id));

        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        return redirect('/mypage?page=buy')->with('success', '決済が完了しました。');
    }

    public function cancel(Request $request)
    {
        return redirect()->route('top')->withErrors('決済をキャンセルしました。');
    }
}
