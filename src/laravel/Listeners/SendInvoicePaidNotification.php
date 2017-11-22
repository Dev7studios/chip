<?php

namespace Dev7studios\Chip\Laravel\Listeners;

use Dev7studios\Chip\Laravel\Events\InvoicePaymentSucceeded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvoicePaidNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  InvoicePaymentSucceeded $event
     * @return void
     */
    public function handle(InvoicePaymentSucceeded $event)
    {
    }
}
