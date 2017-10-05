<?php

namespace Dev7studios\Chip\Interfaces;

interface Billable
{
    /**
     * Subscribe a customer to a give plan
     *
     * @param string $token
     * @param string $email
     * @param string $plan
     * @param string $coupon
     * @return mixed
     */
    public function subscribe($token, $email, $plan, $coupon = null);

    /**
     * Update a customer
     *
     * @param string $customerId
     * @param string $token
     * @return mixed
     */
    public function updateCustomer($customerId, $token);

    /**
     * Change a subscription's plan
     *
     * @param string $subscriptionId
     * @param string $newPlan
     * @return mixed
     */
    public function changeSubscriptionPlan($subscriptionId, $newPlan);

    /**
     * Cancel a subscription
     *
     * @param string $subscriptionId
     * @param boolean $atPeriodEnd
     * @return mixed
     */
    public function cancelSubscription($subscriptionId, $atPeriodEnd = true);

    /**
     * Resume a subscription
     *
     * @param string $subscriptionId
     * @param string $currentPlan
     * @return mixed
     */
    public function resumeSubscription($subscriptionId, $currentPlan);
}
