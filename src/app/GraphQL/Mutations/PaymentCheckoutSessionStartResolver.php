<?php

namespace App\GraphQL\Mutations;

use App\Models\Point;
use App\Models\PaymentCheckout;
use App\Services\StripeService;

class PaymentCheckoutSessionStartResolver
{
    private StripeService $stripeService;

    /**
     * PaymentsController constructor.
     * @param StripeService $stripeService
     */
    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver

        $user = auth()->user();

        // 成立していないセッションがあれば無効
        $oldPaymentCheckouts = $user->paymentCheckouts()->where('is_complete', false)->get();
        foreach ($oldPaymentCheckouts as $oldPaymentCheckout) {
            $this->stripeService->cancelPaymentIntent($oldPaymentCheckout->stripe_payment_intent_id);
            $oldPaymentCheckout->delete();
        }

        // Stripe Checkout の Session を開始する
        $paymentCheckout = \DB::transaction(function () use ($user, $args) {
            $point = Point::find($args['point_id']);

            $checkoutSession = $this->stripeService->createCheckoutSession(
                $point->stripe_product_id,
                $point->price,
                $user->email,
                config('front.url') . '/payment/success',
                config('front.url') . '/payment/cancel'
            );
            return PaymentCheckout::create([
                'point_id' => $point->id,
                'user_id' => $user->id,
                'amount' => $point->price,
                'stripe_session_id' => $checkoutSession->id,
                'stripe_payment_intent_id' => $checkoutSession->payment_intent,
            ]);
        });

        return [
            'stripe_session_id' => $paymentCheckout->stripe_session_id,
        ];
    }
}
