<?php

namespace Tests\Laravel\Controllers;

use Dev7studios\Chip\Laravel\Events\SubscriptionCancelled;
use Dev7studios\Chip\Laravel\Events\SubscriptionCardUpdated;
use Dev7studios\Chip\Laravel\Events\SubscriptionChanged;
use Dev7studios\Chip\Laravel\Events\SubscriptionCreated;
use Dev7studios\Chip\Laravel\Events\SubscriptionResumed;
use Illuminate\Support\Facades\Event;
use Tests\Laravel\Fixtures\User;
use Tests\Laravel\TestCase;

class BillingControllerTest extends TestCase
{
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = new User();

        Event::fake();
    }

    public function testSubscribe()
    {
        $response = $this->actingAs($this->user)->post(route('billing-subscribe'), [
            'plan_id'     => 'product-9-monthly',
            'stripeToken' => 'dummy_token',
        ]);

        $response->assertRedirect(route('billing'));
        $response->assertSessionHas('success', 'Successfully subscribed.');
        Event::assertDispatched(SubscriptionCreated::class);
    }

    public function testUpdate()
    {
        $response = $this->actingAs($this->user)->post(route('billing-update'), [
            'stripeToken' => 'dummy_token',
        ]);

        $response->assertRedirect(route('billing'));
        $response->assertSessionHas('success', 'Payment information successfully updated.');
        Event::assertDispatched(SubscriptionCardUpdated::class);
    }

    public function testChange()
    {
        $this->user->isSubscribed = true;

        $response = $this->actingAs($this->user)->get(route('billing-change') . '?plan_id=product-29-monthly');

        $response->assertRedirect(route('billing'));
        $response->assertSessionHas('success', 'Plan successfully changed.');
        Event::assertDispatched(SubscriptionChanged::class);
    }

    public function cancel()
    {
        $response = $this->actingAs($this->user)->get(route('billing-cancel'));

        $response->assertRedirect(route('billing'));
        $response->assertSessionHas('success', 'Subscription cancelled.');
        Event::assertDispatched(SubscriptionCancelled::class);
    }

    public function resume()
    {
        $response = $this->actingAs($this->user)->get(route('billing-resume'));

        $response->assertRedirect(route('billing'));
        $response->assertSessionHas('success', 'Subscription resumed.');
        Event::assertDispatched(SubscriptionResumed::class);
    }
}