<?php

namespace Tests\Laravel;

use SaaSBilling\Laravel\SaaSBilling;
use Tests\Laravel\Fixtures\User;

class SaaSBillingTest extends TestCase
{
    public function testGetBillingData()
    {
        $user        = new User();
        $billingData = SaaSBilling::getBillingData($user);

        $this->assertArrayHasKey('routes', $billingData);
        $this->assertArrayHasKey('stripe_form', $billingData);
        $this->assertArrayHasKey('plans', $billingData);
        $this->assertArrayHasKey('subscription', $billingData);
        $this->assertArrayHasKey('payment_info', $billingData);
        $this->assertArrayHasKey('invoices', $billingData);
        $this->assertArrayHasKey('coupon', $billingData);
    }
}