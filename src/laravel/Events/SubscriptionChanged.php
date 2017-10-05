<?php

namespace Dev7studios\Chip\Laravel\Events;

class SubscriptionChanged
{
    public $user;
    public $plan;

    /**
     * Create a new event instance.
     *
     * @param $user
     * @param $plan
     */
    public function __construct($user, $plan)
    {
        $this->user = $user;
        $this->plan = $plan;
    }
}