<?php

namespace App\Providers;

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
        $this->app->bind('App\Repositories\UsuariosRepositoryInterface',
        'App\Repositories\UsuariosRepositoryEloquent');
        $this->app->bind('App\Repositories\RegistrosRepositoryInterface',
        'App\Repositories\RegistrosRepositoryEloquent');
        $this->app->bind('App\Repositories\TagsRepositoryInterface',
        'App\Repositories\TagsRepositoryEloquent');
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
