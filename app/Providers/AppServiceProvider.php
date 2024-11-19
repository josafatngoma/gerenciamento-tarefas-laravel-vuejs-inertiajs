<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

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
        
        // buscando email de todos usuários do tipo "admin"
        $adminsEmail = User::where('user_type', 'admin')->pluck('email')->toArray();
        

        // atribuindo os emails em config/custom.php
        Config::set('custom.admins', $adminsEmail);

        Gate::define('isAdmin', function (User $user) {
            return $user->user_type === 'admin';  // verifica se o tipo de usuário é "admin"
        });

    }
}
