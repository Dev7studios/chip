# Vue Installation

The SaaS Billing package comes with a demo app to show you how to use the components in your [Vue.js](https://vuejs.org/) app. Setting up the components in your Vue app is pretty simple. We recommend using [Webpack](https://webpack.js.org/) to compile your app.

## Install components (front-end)

First, make sure to include the [Stripe Checkout](https://stripe.com/checkout) script on your billing page:

```html
<script src="https://checkout.stripe.com/checkout.js"></script>
```

Next, fetch the [required data](../misc/data-structure.md) for the components. This can be hard coded on the page (via PHP for example) or fetched via AJAX. How you fetch this data is up to you (see back-end instructions below).

```html
<script>
var billingData = {
    "routes": {
        //...
    },
    "stripe_form": {
        //...
    },
    "plans": [
    	//...
    ],
    "subscription": {},
    "payment_info": {},
    "invoices": [],
    "coupon": ""
};
</script>
```

Finally include the components in your app:


```html
<template>
    <div id="app">
        <plan-and-pricing :routes="billingData.routes"
                          :stripe-form="billingData.stripe_form"
                          :plans="billingData.plans"
                          :subscription="billingData.subscription"
                          :coupon="billingData.coupon"></plan-and-pricing>

        <payment-info :routes="billingData.routes"
                      :stripe-form="billingData.stripe_form"
                      :payment-info="billingData.payment_info"></payment-info>

        <payment-history :invoices="billingData.invoices"></payment-history>
    </div>
</template>

<script>
	import { PlanAndPricing, PaymentInfo, PaymentHistory } from 'saas-billing';

	export default {
		data () {
			return {
				billingData: billingData
			}
		},

		components: {
			'plan-and-pricing': PlanAndPricing,
			'payment-info': PaymentInfo,
			'payment-history': PaymentHistory
		}
	}
</script>
```

## Hook up back-end

Once you have set up the components you need to hook them up to a back-end processor (via the routes defined in the [data structure](../misc/data-structure.md)). We provide the following integrations with this package:

* PHP
* [Laravel](../laravel/installation.md)