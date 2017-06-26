<?php

$router->group(['middleware' => 'web'], function ($router) {
    $router->get('/billing', 'BillingController@index')->name('billing');

    $router->post('/billing', 'BillingController@subscribe')->name('billing-subscribe');
    $router->post('/billing/update', 'BillingController@update')->name('billing-update');

    $router->get('/billing/change', 'BillingController@change')->name('billing-change');
    $router->get('/billing/cancel', 'BillingController@cancel')->name('billing-cancel');
    $router->get('/billing/resume', 'BillingController@resume')->name('billing-resume');
});
