<?php

namespace Tests\Laravel\Fixtures;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Billable, Notifiable;

    public $email = '';
    public $subscriptions;
    public $card_brand = '';
    public $card_last_four = '';
    public $billing_address = '';
    public $billing_city = '';
    public $billing_state = '';
    public $billing_zip = '';
    public $billing_country = '';
    public $isSubscribed = false;

    public function __construct()
    {
        $this->subscriptions = collect();
    }

    public function subscribed($subscription = 'default', $plan = null)
    {
        return $this->isSubscribed;
    }

    public function subscription($subscription = 'default')
    {
        return new Subscription();
    }

    public function newSubscription($subscription = 'default', $plan = null)
    {
        return new Subscription();
    }

    public function updateCard($token)
    {

    }

    public function findInvoice($id)
    {
        return new Invoice($this, $id);
    }
}