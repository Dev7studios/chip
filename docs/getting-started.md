# Getting Started

Before we can get started installing the Chip package, first there are a few prerequisites we need to have fulfilled:

1. Created a [Laravel application](https://laravel.com/docs/5.5/installation)
1. Installed [Laravel Cashier](https://laravel.com/docs/5.5/billing) and configured it for Stripe

Once we have our Laravel application in this state we can install the Chip package.

<iframe width="560" height="315" src="https://www.youtube.com/embed/ybJ0L2lPNA8?rel=0&amp;start=143" frameborder="0" allowfullscreen></iframe>
<br>

## 1. Install Chip

To install the package via composer simply run:

```
composer require dev7studios/chip
```

Laravel package discovery will find the service provider.

## 2. Configure Chip

Next, publish the `chip.php` config file:

```
php artisan vendor:publish --tag=chip
```

In the newly generated `config/chip.php` file, fill in the `plan` details based on the plans you have defined in Stripe.

## 3. Compile Chip Assets

First, you will need to update the `webpack.mix.js` file for your Laravel project to include the Chip paths as a dependency locations:

```js
mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .webpackConfig({
        resolve: {
            modules: [
                path.resolve(__dirname, 'vendor/dev7studios/chip/dist'),
                path.resolve(__dirname, 'vendor/dev7studios/chip/src/laravel/resources/assets/js'),
                'node_modules'
            ]
        }
    });
```

Next, open `resources/assets/js/app.js` and require the Chip bootstrap file (after Vue has been loaded):

```js
window.Vue = require('vue');

require('chip-bootstrap');

const app = new Vue({
    el: '#app'
});
```

Then run `npm run dev` to re-compile your assets.

Finally you need to edit the `resources/views/layouts/app.blade.php` file to add a `yield` directive before the closing `</head>` tag:

```html
    @yield('scripts-head')
</head>
```

## 4. Set Up Webhooks

For `SubscriptionDeleted` events and payment invoices to work, you must use our provided `StripeWebhookController` _instead_ of the one provided by [Laravel Cashier](https://laravel.com/docs/5.5/billing#handling-stripe-webhooks). In your `routes/web.php` file add the following line:

```php
Route::post('stripe/webhook', '\Dev7studios\Chip\Laravel\Http\Controllers\StripeWebhookController@handleWebhook');
```

## 5. Install Finished!

You should now be able to visit the `/billing` route in your Laravel app and see the billing page. By default the Chip package will add a `/billing` route (configured in `config/chip.php`) to your app with the billing components pre-installed. It will use the default layout provided with Laravel and is compatible with Bootstrap styles. 

Remember, almost everything can be [customized](/docs/customizing).

## 6. Choose a License

At this point you may need to purchase a Chip Commercial License if you plan on using Chip on a commercial site. [Find out more about Chip licensing](/docs/licensing).