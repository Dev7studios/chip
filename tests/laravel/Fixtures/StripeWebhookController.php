<?php

namespace Tests\Laravel\Fixtures;

use Dev7studios\Chip\Laravel\Http\Controllers\StripeWebhookController as WebhookController;

class StripeWebhookController extends WebhookController
{
    /**
     * Get the billable entity instance by Stripe ID.
     *
     * @param  string  $stripeId
     * @return \Laravel\Cashier\Billable
     */
    protected function getUserByStripeId($stripeId)
    {
        return new User();
    }
}