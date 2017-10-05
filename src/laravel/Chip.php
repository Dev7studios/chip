<?php

namespace Dev7studios\Chip\Laravel;

class Chip
{
    /**
     * Get the billing data required for the Chip components
     *
     * @param mixed $billable
     * @param string $coupon
     * @return array
     */
    final public static function getBillingData($billable, $coupon = null)
    {
        $subscription = null;

        if ($billable->subscribed('default')) {
            $currentSubscription = $billable->subscription('default');
            $subscription        = $currentSubscription->toArray();

            unset($subscription['stripe_id']);
            $subscription['on_trial']        = $currentSubscription->onTrial();
            $subscription['cancelled']       = $currentSubscription->cancelled();
            $subscription['on_grace_period'] = $currentSubscription->onGracePeriod();
        }

        $paymentInfo = [
            'card_brand'      => $billable->card_brand,
            'card_last_four'  => $billable->card_last_four,
            'billing_address' => $billable->billing_address,
            'billing_city'    => $billable->billing_city,
            'billing_state'   => $billable->billing_state,
            'billing_zip'     => $billable->billing_zip,
            'billing_country' => $billable->billing_country,
        ];

        $invoices = [];
        try {
            foreach ($billable->invoices() as $invoice) {
                $invoices[] = [
                    'id'    => $invoice->id,
                    'date'  => $invoice->date()->toFormattedDateString(),
                    'total' => $invoice->total(),
                ];
            }
        } catch (\Exception $e) {
        }

        return [
            'routes'       => [
                'form_post_subscribe' => route('billing-subscribe'),
                'form_post_update'    => route('billing-update'),
                'change_plan'         => route('billing-change'),
                'cancel_subscription' => route('billing-cancel'),
                'resume_subscription' => route('billing-resume'),
            ],
            'stripe_form'  => [
                'stripe_key' => config('services.stripe.key'),
                'csrf_token' => csrf_token(),
                'app_name'   => config('app.name'),
                'user_email' => $billable->email,
            ],
            'plans'        => config('chip.plans'),
            'subscription' => $subscription,
            'payment_info' => $paymentInfo,
            'invoices'     => $invoices,
            'coupon'       => $coupon,
        ];
    }
}