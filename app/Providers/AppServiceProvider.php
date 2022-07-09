<?php

namespace App\Providers;
use App\Contracts\BookInterface;
use App\Contracts\PaymentInterface;
use App\Contracts\PlanSubscriptionInterface;
use App\Contracts\ResetPasswordInterface;
use App\Contracts\SubscriptionInterface;
use App\Contracts\UserInterface;
use App\Repository\BookRepository;
use App\Repository\PaymentRepository;
use App\Repository\PlanSubscriptionRepository;
use App\Repository\ResetPasswordRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(
            UserInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            BookInterface::class,
            BookRepository::class
        );
        $this->app->bind(
            PaymentInterface::class,
            PaymentRepository::class
        );
        $this->app->bind(
            PlanSubscriptionInterface::class,
            PlanSubscriptionRepository::class
        );
        $this->app->bind(
            SubscriptionInterface::class,
            SubscriptionRepository::class
        );
        $this->app->bind(
            ResetPasswordInterface::class,
            ResetPasswordRepository::class
        );


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
