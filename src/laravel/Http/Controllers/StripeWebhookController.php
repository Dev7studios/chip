<?php

namespace SaaSBilling\Laravel\Http\Controllers;

use SaaSBilling\Laravel\Events\SubscriptionDeleted;
use Laravel\Cashier\Http\Controllers\WebhookController;

class StripeWebhookController extends WebhookController
{
    /**
     * Handle a cancelled customer from a Stripe subscription.
     *
     * @param  array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleCustomerSubscriptionDeleted(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if ($user) {
            event(new SubscriptionDeleted($user));
        }

        return parent::handleCustomerSubscriptionDeleted($payload);
    }
}
