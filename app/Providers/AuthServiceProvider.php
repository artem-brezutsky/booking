<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        /**
         * Проверка на удаление текущего пользователя
         */
        Gate::define('deletingCurrentUser', static function (User $user, int $id) {
            return $user->id !== $id;
        });

        /**
         * Проверка является ли пользователь админом
         */
        Gate::define('isAdmin', static function(User $user){
            return $user->isAdmin();
        });
    }
}
