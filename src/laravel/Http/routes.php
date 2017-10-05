<?php

$router->group(['middleware' => 'web'], function ($router) {
	$baseRoute = config('chip.billing_route');

	$router->get($baseRoute, 'BillingController@index')->name('billing');

	$router->post($baseRoute, 'BillingController@subscribe')->name('billing-subscribe');
	$router->post($baseRoute . '/update', 'BillingController@update')->name('billing-update');

	$router->get($baseRoute . '/change', 'BillingController@change')->name('billing-change');
	$router->get($baseRoute . '/cancel', 'BillingController@cancel')->name('billing-cancel');
	$router->get($baseRoute . '/resume', 'BillingController@resume')->name('billing-resume');
});
