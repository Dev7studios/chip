<?php

namespace SaaSBilling\Billing;

use Stripe as StripeLib;
use SaaSBilling\Interfaces\Billable;

class Stripe implements Billable
{
    /**
     * @param string $stripeSecretKey
     */
    public function __construct($stripeSecretKey)
    {
        StripeLib\Stripe::setApiKey($stripeSecretKey);
    }

    public function subscribe($token, $email, $plan, $coupon = null)
    {
        $customer = StripeLib\Customer::create([
            'email'  => $email,
            'source' => $token,
        ]);

        $subscription = StripeLib\Subscription::create([
            'customer' => $customer->id,
            'plan'     => $plan,
            'coupon'   => $coupon,
        ]);

        return [
            'customer'     => $customer,
            'subscription' => $subscription,
        ];
    }

    public function updateCustomer($customerId, $token)
    {
        $customer         = StripeLib\Customer::retrieve($customerId);
        $customer->source = $token;
        $customer->save();

        return $customer;
    }

    public function changeSubscriptionPlan($subscriptionId, $newPlan)
    {
        $subscription       = StripeLib\Subscription::retrieve($subscriptionId);
        $subscription->plan = $newPlan;
        $subscription->save();

        return $subscription;
    }

    public function cancelSubscription($subscriptionId, $atPeriodEnd = true)
    {
        $subscription = StripeLib\Subscription::retrieve($subscriptionId);
        $subscription->cancel(['at_period_end' => $atPeriodEnd]);

        return $subscription;
    }

    public function resumeSubscription($subscriptionId, $currentPlan)
    {
        $subscription       = StripeLib\Subscription::retrieve($subscriptionId);
        $subscription->plan = $currentPlan;
        $subscription->save();

        return $subscription;
    }
}
