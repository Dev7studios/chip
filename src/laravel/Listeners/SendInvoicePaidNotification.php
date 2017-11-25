<?php

namespace Dev7studios\Chip\Laravel\Listeners;

use Dev7studios\Chip\Laravel\Events\InvoicePaymentSucceeded;
use Dev7studios\Chip\Laravel\Notifications\InvoicePaid;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

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
        Notification::send($event->user, new InvoicePaid($event->user, $event->invoice));
    }
}
