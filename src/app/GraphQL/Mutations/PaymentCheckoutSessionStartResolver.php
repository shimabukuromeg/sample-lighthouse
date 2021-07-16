<?php

namespace App\GraphQL\Mutations;

class PaymentCheckoutSessionStartResolver
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        return [
            'stripe_session_id' => '123456789101112',
        ];
    }
}
