<?php

namespace App\Providers;

use App\Services\Pdf\PdfGenerator;
use Illuminate\Support\ServiceProvider;

class PdfServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        // Auth service that performs LDAP login related operations.
        $this->app->bind('App\Services\Pdf\PdfGenerator', static function ($app) {
            return new PdfGenerator();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
