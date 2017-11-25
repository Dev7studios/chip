<?php

namespace Tests\Laravel\Controllers;

use Illuminate\Support\Facades\Event;
use Tests\Laravel\Fixtures\User;
use Tests\Laravel\TestCase;
use Tests\Laravel\Fixtures\StripeWebhookController;
use Dev7studios\Chip\Laravel\Notifications\InvoicePaid;
use Dev7studios\Chip\Laravel\Events\InvoicePaymentSucceeded;

class StripeWebhookControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Event::fake();
    }

    public function testHandleInvoicePaymentSucceeded()
    {
        $payload = [
            'data' => [
                'object' => [
                    'id'       => 'in_123456789',
                    'customer' => 'cus_123456789'
                ],
            ],
        ];
        $webhookController = new StripeWebhookController();
        $webhookController->handleInvoicePaymentSucceeded($payload);

        Event::assertDispatched(InvoicePaymentSucceeded::class);
    }
}
