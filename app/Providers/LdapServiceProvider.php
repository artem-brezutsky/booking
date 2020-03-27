<?php

namespace App\Providers;

use App\Services\Ldap\Auth;
use Illuminate\Support\ServiceProvider;

class LdapServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Auth service that performs LDAP login related operations.
        $this->app->bind('App\Services\Ldap\Auth', function ($app) {
            return new Auth(
                config('ldap.reader_dn'),
                config('ldap.reader_password'),
                config('ldap.users_group_dn'),
                config('ldap.filter')
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
