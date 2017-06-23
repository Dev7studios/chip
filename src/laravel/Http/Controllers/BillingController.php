<?php

namespace SaaSBilling\Laravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use SaaSBilling\Laravel\Events\SubscriptionCancelled;
use SaaSBilling\Laravel\Events\SubscriptionCardUpdated;
use SaaSBilling\Laravel\Events\SubscriptionChanged;
use SaaSBilling\Laravel\Events\SubscriptionCreated;
use SaaSBilling\Laravel\Events\SubscriptionResumed;

class BillingController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function subscribe(Request $request)
    {
        $planId = $request->get('plan_id');
        $plan   = $this->getPlan($planId);
        if (!$plan) {
            abort(404, 'Invalid plan');
        }

        $user = $request->user();
        if ($user->subscribed('default')) {
            abort(403, 'User already subscribed');
        }

        $subscription = $user->newSubscription('default', $plan['id']);

        if ($request->has('coupon')) {
            $subscription->withCoupon($request->get('coupon'));
        }

        $subscription->create($request->get('stripeToken'), [
            'email' => $user->email,
        ]);

        $user->update([
            'billing_address' => $request->get('billing_address_line1'),
            'billing_city'    => $request->get('billing_address_city'),
            'billing_state'   => $request->get('billing_address_state'),
            'billing_zip'     => $request->get('billing_address_zip'),
            'billing_country' => $request->get('billing_address_country_code'),
        ]);

        event(new SubscriptionCreated($user, $plan['id']));

        return redirect(config('saas-billing.billing_route'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $user->updateCard($request->get('stripeToken'));

        $user->update([
            'billing_address' => $request->get('billing_address_line1'),
            'billing_city'    => $request->get('billing_address_city'),
            'billing_state'   => $request->get('billing_address_state'),
            'billing_zip'     => $request->get('billing_address_zip'),
            'billing_country' => $request->get('billing_address_country_code'),
        ]);

        event(new SubscriptionCardUpdated($user));

        return redirect(config('saas-billing.billing_route'));
    }

    public function change(Request $request)
    {
        $planId = $request->get('plan_id');
        if (!$planId) {
            abort(404, 'Invalid plan');
        }
        $plan = $this->getPlan($planId);
        if (!$plan) {
            abort(404, 'Invalid plan');
        }

        $user = $request->user();
        if (!$user->subscribed('default')) {
            abort(403, 'User doesn\'t have a subscription');
        }

        $user->subscription('default')->swap($plan['id']);

        event(new SubscriptionChanged($user, $plan['id']));

        return redirect(config('saas-billing.billing_route'));
    }

    public function cancel(Request $request)
    {
        $user = $request->user();

        $user->subscription('default')->cancel();

        event(new SubscriptionCancelled($user));

        return redirect(config('saas-billing.billing_route'));
    }

    public function resume(Request $request)
    {
        $user = $request->user();

        $user->subscription('default')->resume();

        event(new SubscriptionResumed($user));

        return redirect(config('saas-billing.billing_route'));
    }

    /**
     * Get a plan from the plans array
     *
     * @param string $planId
     * @return array
     */
    protected function getPlan($planId)
    {
        $plans = collect(config('saas-billing.plans'));

        return $plans->first(function ($plan) use ($planId) {
            return $plan['id'] == $planId;
        });
    }
}
