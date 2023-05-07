<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Delivery;
use App\Models\User;
use App\Policies\DeliveryPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        UserPolicy::class => User::class,
        DeliveryPolicy::class => Delivery::class,
    ];

    public function boot(): void
    {
        //
    }
}
