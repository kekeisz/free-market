<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StripeCheckout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sig = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sig, $secret);
        } catch (\UnexpectedValueException $e) {
            Log::warning('stripe_webhook_invalid_payload');
            return response('Invalid payload', 400);
        } catch (SignatureVerificationException $e) {
            Log::warning('stripe_webhook_invalid_signature');
            return response('Invalid signature', 400);
        }

        if (($event->type ?? '') !== 'checkout.session.completed') {
            return response('ok', 200);
        }

        $session = $event->data->object ?? null;
        $sessionId = $session->id ?? null;
        $paymentStatus = $session->payment_status ?? null;

        Log::info('stripe_checkout_session_completed', [
            'session_id' => $sessionId,
            'payment_status' => $paymentStatus,
        ]);

        if (!$sessionId || $paymentStatus !== 'paid') {
            return response('ok', 200);
        }

        $checkout = StripeCheckout::where('session_id', $sessionId)->first();
        if (!$checkout) {
            Log::warning('stripe_checkout_not_found', ['session_id' => $sessionId]);
            return response('ok', 200);
        }

        DB::transaction(function () use ($checkout) {
            $item = Item::where('id', $checkout->item_id)->lockForUpdate()->first();
            if (!$item || (bool) $item->is_sold) {
                return;
            }

            $item->update([
                'is_sold' => true,
                'buyer_id' => (int) $checkout->buyer_id,
            ]);

            $checkout->update(['status' => 'paid']);
        });

        return response('ok', 200);
    }
}
