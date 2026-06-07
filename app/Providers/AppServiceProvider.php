<?php

namespace App\Providers;

use App\Services\AuthService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use URL;

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
    public function boot(): void {
        Blade::if('superadmin', function() {
            $user = auth()->user();

            return $user && app(AuthService::class)->isSuperAdmin($user);
        });

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Model::unguard();
        Model::shouldBeStrict();
        Model::automaticallyEagerLoadRelationships();
    }
}
