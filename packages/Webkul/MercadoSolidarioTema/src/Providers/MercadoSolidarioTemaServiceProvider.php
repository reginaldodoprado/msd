<?php

namespace Webkul\MercadoSolidarioTema\Providers;

use Illuminate\Support\ServiceProvider;

class MercadoSolidarioTemaServiceProvider extends ServiceProvider
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
            __DIR__.'/../Resources/views' => resource_path('themes/mercado-solidario-tema/views'),
        ], 'mercado-solidario-tema-views');

        // Publicar os assets do tema
        $this->publishes([
            __DIR__.'/../Resources/assets' => public_path('themes/shop/mercado-solidario-tema'),
        ], 'mercado-solidario-tema-assets');

        // Carregar as visualizações do tema
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'mercado-solidario-tema');
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
