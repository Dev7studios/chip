# Customize Laravel Installation

There will probably come a time when you want to customize some part of the SaaS Billing installation in your Laravel app. Don't worry, we have you covered. The following commands will publish the required parts of the integration to make it easy to customize.

## Config File

To publish the `saas-billing.php` config file:

```
php artisan vendor:publish --tag=saas-billing
```

In the newly generated `config/saas-billing.php` file you can fill in the plan details based on the plans you have defined in Stripe and some other settings.

## Views

To publish the billing view files:

```
php artisan vendor:publish --tag=saas-billing-views
```

This will make the views available in `resources/views/vendor/saas-billing`.

## Components

To publish the component files:

```
php artisan vendor:publish --tag=saas-billing-components
```

This will make the components available in `resources/assets/js/vendor/saas-billing`.

## Events

There are several events that SaaS Billing triggers at different points in the subscription flow. You can create [Laravel Listeners](https://laravel.com/docs/5.4/events#defining-listeners) to trigger custom functionality when these events are fired.

* `SaaSBilling\Laravel\Events\SubscriptionCreated` - When a subscription is created
* `SaaSBilling\Laravel\Events\SubscriptionCardUpdated` - When the payment info is updated
* `SaaSBilling\Laravel\Events\SubscriptionChanged` - When a subscription changes plans
* `SaaSBilling\Laravel\Events\SubscriptionCancelled` - When a subscription is cancelled (but still on a grace period)
* `SaaSBilling\Laravel\Events\SubscriptionResumed` - When a subscription is resumed
* `SaaSBilling\Laravel\Events\SubscriptionDeleted` - When a subscription is expired (at the end of the grace period, see below)

For the `SubscriptionDeleted` event to work, you must use our provided `SaaSBilling\Laravel\Http\Controllers\StripeWebhookController` **instead** of the one provided by [Laravel Cashier](https://laravel.com/docs/5.4/billing#handling-stripe-webhooks).
