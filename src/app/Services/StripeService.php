<?php

namespace App\Services;

use Stripe\Checkout;
use Stripe\Exception\InvalidRequestException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.key'));
    }

    public function createCheckoutSession(
        string $productId,
        int $amount,
        string $email,
        string $successUrl,
        string $cancelUrl
    ) {
        return Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items'     => [[
                'price_data'  => [
                    'currency'    => 'jpy',
                    'product'     => $productId,
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'mode'                 => 'payment',
            'customer_email'       => $email,
            'success_url'          => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => $cancelUrl . '?session_id={CHECKOUT_SESSION_ID}',
        ]);
    }

    public function cancelPaymentIntent(string $paymentIntentId): void
    {
        $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
        try {
            $paymentIntent->cancel();
        } catch (InvalidRequestException $e) {
            if (
                $e->getError() !== null &&
                $e->getError()->code === 'payment_intent_unexpected_state' &&
                strpos($e->getError()->message, 'because it has a status of canceled') !== false
            ) {
                return;
            }
            throw $e;
        }
    }
}
