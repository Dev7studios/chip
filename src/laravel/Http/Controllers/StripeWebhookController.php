<?php

namespace Dev7studios\Chip\Laravel\Http\Controllers;

use Dev7studios\Chip\Laravel\Events\InvoicePaymentSucceeded;
use Dev7studios\Chip\Laravel\Events\SubscriptionDeleted;
use Laravel\Cashier\Http\Controllers\WebhookController;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhookController extends WebhookController
{
    /**
     * Handle a cancelled customer from a Stripe subscription.
     *
     * @param  array $payload
     * @return Response
     */
    public function handleCustomerSubscriptionDeleted(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if ($user) {
            event(new SubscriptionDeleted($user));
        }

        return parent::handleCustomerSubscriptionDeleted($payload);
    }

    /**
     * Handle a cancelled customer from a Stripe subscription.
     *
     * @param  array $payload
     * @return Response
     */
    public function handleInvoicePaymentSucceeded($payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if ($user) {
            $invoice = $user->findInvoice($payload['data']['object']['id']);

            if ($invoice) {
                event(new InvoicePaymentSucceeded($user, $invoice));
            }
        }

        return new Response('Webhook Handled', 200);
    }
}
