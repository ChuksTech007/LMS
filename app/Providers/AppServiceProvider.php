<?php

namespace App\Providers;

use App\Models\Course;
use App\Policies\CoursePolicy;
use App\View\Composers\NotificationComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Payment;
use App\Policies\PaymentPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.partials.navbar', NotificationComposer::class);
    }

    protected $policies = [
    Payment::class => PaymentPolicy::class,
];
}
