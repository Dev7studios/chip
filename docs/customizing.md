# Customizing

There will probably come a time when you want to customize some part of the Chip installation in your Laravel app. Don't worry, we have you covered. The following commands will publish the required parts of the package to make it easy to customize.

## Publishing Assets

### Config File

To publish the `chip.php` config file:

```
php artisan vendor:publish --tag=chip
```

In the newly generated `config/chip.php` file you can fill in the plan details based on the plans you have defined in Stripe and some other settings.

### Views

To publish the billing view files:

```
php artisan vendor:publish --tag=chip-views
```

This will make the views available in `resources/views/vendor/chip`.

### Components

To publish the Vue.js component files:

```
php artisan vendor:publish --tag=chip-components
```

This will make the components available in `resources/assets/js/vendor/chip` ([more info](/docs/vue-components)).

## Events

There are several events that Chip triggers at different points in the subscription flow. You can create [Laravel Listeners](https://laravel.com/docs/5.5/events#defining-listeners) to trigger custom functionality when these events are fired.

* `Dev7studios\Chip\Laravel\Events\SubscriptionCreated` - When a subscription is created
* `Dev7studios\Chip\Laravel\Events\SubscriptionCardUpdated` - When the payment info is updated
* `Dev7studios\Chip\Laravel\Events\SubscriptionChanged` - When a subscription changes plans
* `Dev7studios\Chip\Laravel\Events\SubscriptionCancelled` - When a subscription is cancelled (but still on a grace period)
* `Dev7studios\Chip\Laravel\Events\SubscriptionResumed` - When a subscription is resumed
* `Dev7studios\Chip\Laravel\Events\SubscriptionDeleted` <sup>1</sup> - When a subscription is expired (at the end of the grace period, see below)
* `Dev7studios\Chip\Laravel\Events\InvoicePaymentSucceeded` <sup>1</sup> - When an invoice has been paid

[1] For these events to work, you must use our provided `Dev7studios\Chip\Laravel\Http\Controllers\StripeWebhookController` _instead_ of the one provided by [Laravel Cashier](https://laravel.com/docs/5.5/billing#handling-stripe-webhooks).

## Listeners

While you can specify any listeners you want for any of the events above using Laravel's [`EventServiceProvider`](https://laravel.com/docs/5.5/events#registering-events-and-listeners), Chip comes with some built in listeners that you may wish to override (e.g. if you want to customize how the `InvoicePaid` notification is sent). You can do this by editing the array of `listeners` in `config/chip.php`.