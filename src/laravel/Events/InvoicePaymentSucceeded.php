<?php

namespace Dev7studios\Chip\Laravel\Events;

class InvoicePaymentSucceeded
{
    /**
     * @var \Laravel\Cashier\Billable
     */
    public $user;

    /**
     * @var \Laravel\Cashier\Invoice
     */
    public $invoice;

    /**
     * Create a new event instance.
     *
     * @param \Laravel\Cashier\Billable $user
     * @param \Laravel\Cashier\Invoice  $invoice
     */
    public function __construct($user, $invoice)
    {
        $this->user    = $user;
        $this->invoice = $invoice;
    }
}
