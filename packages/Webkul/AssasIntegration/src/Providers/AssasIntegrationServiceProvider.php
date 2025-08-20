<?php

namespace Ds\AssasIntegration\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\CobrancaService;

class AssasIntegrationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Registrar o ApiClientService como singleton
        $this->app->singleton(ApiClientService::class, function ($app) {
            return new ApiClientService();
        });

        // Registrar o CreditoService
        $this->app->bind(CobrancaService::class, function ($app) {
            return new CobrancaService($app->make(ApiClientService::class));
        });

        // Registrar os serviços como aliases para facilitar o uso
        $this->app->alias(ApiClientService::class, 'assas.api');
        $this->app->alias(CobrancaService::class, 'assas.cobranca');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publicar configurações se necessário
        $this->publishes([
            __DIR__ . '/../config/assas-integration.php' => config_path('assas-integration.php'),
        ], 'assas-integration-config');

        // Carregar rotas web e API
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        
        // Carregar views
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'assas-integration');
    }
}
