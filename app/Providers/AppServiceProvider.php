<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

use App\Interfaces\PaymentGateway;
use App\PaymentGateways\FakePaymentGateway;
use App\PaymentGateways\ConektaPaymentGateway;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(\App\Ticket $ticketRepository)
    {
        //
        // Custom validator for available tickets, should preferrably be coded
        // into own class
        Validator::extend('tickets_are_available', function ($attribute, $value, $parameters, $validator) use ($ticketRepository) {
          return $ticketRepository->available()->whereIn('id', is_array($value) ? $value : [$value])->count() == count($value);
        });


        // Bind interface to Fake Payment Gateway
        // $this->app->bind(PaymentGateway::class, FakePaymentGateway::class);
        $this->app->bind(PaymentGateway::class, ConektaPaymentGateway::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
