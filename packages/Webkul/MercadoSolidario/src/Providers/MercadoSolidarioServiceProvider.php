<?php

namespace Webkul\MercadoSolidario\Providers;

use Illuminate\Support\ServiceProvider;
use Webkul\MercadoSolidario\Console\Commands\SeedThemeCustomizations;

class MercadoSolidarioServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publicar as visualizações do tema
        $this->publishes([
            __DIR__.'/../Resources/views' => resource_path('themes/mercado-solidario/views'),
        ], 'mercado-solidario-views');

        // Publicar os assets do tema
        $this->publishes([
            __DIR__.'/../Resources/assets' => public_path('themes/shop/mercado-solidario'),
        ], 'mercado-solidario-assets');

        // Carregar as visualizações do tema
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'mercado-solidario');

        // Registrar comandos Artisan
        if ($this->app->runningInConsole()) {
            $this->commands([
                SeedThemeCustomizations::class,
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
