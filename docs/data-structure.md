# Data Structure

The Chip components expect certain data to be available to operate correctly. How you provide this data is up to you, but the JSON object must be available to be imported into your Vue app (e.g. hard coded in a JS variable or loaded via AJAX). To see how we've done this in the Chip package check out the Chip [`getBillingData()`](https://github.com/Dev7studios/chip/blob/master/src/laravel/Chip.php) method.

The structure of the data must be as follows:

```json
{
    "routes": {
        "form_post_subscribe": "/billing",
        "form_post_update": "/billing/update",
        "change_plan": "/billing/change",
        "cancel_subscription": "/billing/cancel",
        "resume_subscription": "/billing/resume"
    },
    "stripe_form": {
        "stripe_key": "",
        "csrf_token": "",
        "app_name": "Example App",
        "user_email":"user@product.com"
    },
    "plans": [
        {"id": "product-9-monthly",  "name": "Freelancer", "price": 9,  "interval": "monthly", "features": ["1 user"]},
        {"id": "product-29-monthly", "name": "Small Team", "price": 29, "interval": "monthly", "features": ["5 users"]},
        {"id": "product-59-monthly", "name": "Big Team",   "price": 59, "interval": "monthly", "features": ["15 users"]}
    ],
    "subscription": {
        "stripe_plan": "product-9-monthly",
        "cancelled": false,
        "on_grace_period": false,
        "ends_at": null
    },
    "payment_info": {
        "card_brand": "Visa",
        "card_last_four": "4242",
        "billing_address": "1 Example Place",
        "billing_city": "New York",
        "billing_state": "NY",
        "billing_zip": "12345",
        "billing_country": "USA"
    },
    "invoices": [
        {"date": "Jun 1, 2017", "id": "in_AlPSE4hBoFK0lc", "total": "$29.00", "link": "/invoice/1234"}
    ],
    "coupon": "EXAMPLECOUPON",
    "currency": {
        "symbol": "$",
        "code": "USD"
    }
}

```

## `routes` (required)

**Components:** `PlanAndPricing`, `PaymentInfo`

These routes are used to connect the front-end components to a back-end.

* `form_post_subscribe` - Where the component will `POST` the Stripe Checkout form after collecting the billing data
* `form_post_update` - Where the component will `POST` the Stripe Checkout form after collecting the updated billing data
* `change_plan` - Where the component will redirect the user to change plans (provides a `plan_id` in the query string)
* `cancel_subscription` - Where the component will redirect the user to cancel their subscription
* `resume_subscription` - Where the component will redirect the user to resume their subscription

## `stripe_form` (required)

**Components:** `PlanAndPricing`, `PaymentInfo`

Information required by the Stripe Checkout form.  

* `stripe_key` - Your Stripe publishable key
* `csrf_token` - A CSRF token
* `app_name` - The name of your app or product
* `user_email` - The current users email address

## `plans` (required)

**Components:** `PlanAndPricing`

An array of plans that should represent the plans you have defined in Stripe. A plan should consist of:

* `id` - The ID of the plan in Stripe
* `name`- The name of the plan
* `price` - The price of the plan
* `interval` - The interval of the plan (e.g. monthly/annually) 
* `features` - An array of "features" for the plan

## `subscription` (optional)

**Components:** `PlanAndPricing`

Information about a user's current subscription (if it exists).

* `stripe_plan` - The ID of the plan
* `cancelled` - A boolean flag to say if the subscription has been cancelled
* `on_grace_period` - A boolean flag to say if the subscription is on a "grace" period (cancelled but not yet expired)
* `ends_at` - The date the subscription will expire (if it has been cancelled)

## `payment_info` (optional)

**Components:** `PaymentInfo`

A summary of the users current billing information.

* `card_brand` - The card brad (e.g. Visa, Mastercard etc.)
* `card_last_four` - The last four digits of the credit card number
* `billing_address` - Billing address
* `billing_city` - Billing city
* `billing_state` - Billing state
* `billing_zip` - Billing ZIP
* `billing_country` - Billing country

## `invoices` (optional)

**Components:** `PaymentHistory`

An array of invoices that represent payments made in Stripe. An invoice should consist of:

* `date` - The date the payment was made
* `id` - The ID of the invoice
* `total` - The invoice total
* `link` - A link to download the invoice (optional)

## `coupon` (optional)

**Components:** `PlanAndPricing`

An optional coupon as defined in Stripe to be used as a discount during checkout.

## `currency` (optional)

**Components:** `PlanAndPricing`, `PaymentInfo`

Configure which currency is displayed in the components.

* `symbol` - Currency symbol (e.g. $, £, €)
* `code` - 3-letter ISO currency code (e.g. USD, GBP, EUR)