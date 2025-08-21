<?php

namespace Ds\AssasIntegration\Providers;

use Illuminate\Support\ServiceProvider;
use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\CobrancaService;
use Ds\AssasIntegration\Services\ClienteService;
use Ds\AssasIntegration\Services\AssinaturaService;
use Ds\AssasIntegration\Services\NotificacaoService;
use Ds\AssasIntegration\Services\TransferenciaService;
use Ds\AssasIntegration\Services\WebhookService;
use Ds\AssasIntegration\Services\PixService;
use Ds\AssasIntegration\Services\PixRecorrenteService;
use Ds\AssasIntegration\Services\TransacoesPixService;
use Ds\AssasIntegration\Services\CartaoDeCreditoService;
use Ds\AssasIntegration\Services\ParcelamentoService;
use Ds\AssasIntegration\Services\EstornoService;
use Ds\AssasIntegration\Services\ContaBancariaService;
use Ds\AssasIntegration\Services\LinkDePagamentoService;
use Ds\AssasIntegration\Services\CheckoutService;
use Ds\AssasIntegration\Services\SplitsService;
use Ds\AssasIntegration\Services\AntecipacoesService;
use Ds\AssasIntegration\Services\NegativacoesService;
use Ds\AssasIntegration\Services\ExtratoService;
use Ds\AssasIntegration\Services\RecargaDeCelularService;
use Ds\AssasIntegration\Services\PagamentoDeContasService;
use Ds\AssasIntegration\Services\NotaFiscalService;
use Ds\AssasIntegration\Services\InformacoesFiscaisService;
use Ds\AssasIntegration\Services\InformacoesFinanceirasService;
use Ds\AssasIntegration\Services\PersonalizarContaService;
use Ds\AssasIntegration\Services\SubcontasService;
use Ds\AssasIntegration\Services\ContaEscrowService;
use Ds\AssasIntegration\Services\DocumentoDeCobrancaService;
use Ds\AssasIntegration\Services\CobrancaDadosResumidosService;
use Ds\AssasIntegration\Services\ChargeBackService;
use Ds\AssasIntegration\Services\ConsultaSerasaService;
use Ds\AssasIntegration\Services\EnvioDeDocumentoWhiteLabelService;
use Ds\AssasIntegration\Services\AsaasService;


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

        // Registrar todos os serviços individuais
        $this->app->bind(CobrancaService::class, function ($app) {
            return new CobrancaService($app->make(ApiClientService::class));
        });

        $this->app->bind(ClienteService::class, function ($app) {
            return new ClienteService($app->make(ApiClientService::class));
        });

        $this->app->bind(AssinaturaService::class, function ($app) {
            return new AssinaturaService($app->make(ApiClientService::class));
        });

        $this->app->bind(NotificacaoService::class, function ($app) {
            return new NotificacaoService($app->make(ApiClientService::class));
        });

        $this->app->bind(TransferenciaService::class, function ($app) {
            return new TransferenciaService($app->make(ApiClientService::class));
        });

        $this->app->bind(WebhookService::class, function ($app) {
            return new WebhookService($app->make(ApiClientService::class));
        });

        $this->app->bind(PixService::class, function ($app) {
            return new PixService($app->make(ApiClientService::class));
        });

        $this->app->bind(PixRecorrenteService::class, function ($app) {
            return new PixRecorrenteService($app->make(ApiClientService::class));
        });

        $this->app->bind(TransacoesPixService::class, function ($app) {
            return new TransacoesPixService($app->make(ApiClientService::class));
        });

        $this->app->bind(CartaoDeCreditoService::class, function ($app) {
            return new CartaoDeCreditoService($app->make(ApiClientService::class));
        });

        $this->app->bind(ParcelamentoService::class, function ($app) {
            return new ParcelamentoService($app->make(ApiClientService::class));
        });

        $this->app->bind(EstornoService::class, function ($app) {
            return new EstornoService($app->make(ApiClientService::class));
        });

        $this->app->bind(ContaBancariaService::class, function ($app) {
            return new ContaBancariaService($app->make(ApiClientService::class));
        });

        $this->app->bind(LinkDePagamentoService::class, function ($app) {
            return new LinkDePagamentoService($app->make(ApiClientService::class));
        });

        $this->app->bind(CheckoutService::class, function ($app) {
            return new CheckoutService($app->make(ApiClientService::class));
        });

        $this->app->bind(SplitsService::class, function ($app) {
            return new SplitsService($app->make(ApiClientService::class));
        });

        $this->app->bind(AntecipacoesService::class, function ($app) {
            return new AntecipacoesService($app->make(ApiClientService::class));
        });

        $this->app->bind(NegativacoesService::class, function ($app) {
            return new NegativacoesService($app->make(ApiClientService::class));
        });

        $this->app->bind(ExtratoService::class, function ($app) {
            return new ExtratoService($app->make(ApiClientService::class));
        });

        $this->app->bind(RecargaDeCelularService::class, function ($app) {
            return new RecargaDeCelularService($app->make(ApiClientService::class));
        });

        $this->app->bind(PagamentoDeContasService::class, function ($app) {
            return new PagamentoDeContasService($app->make(ApiClientService::class));
        });

        $this->app->bind(NotaFiscalService::class, function ($app) {
            return new NotaFiscalService($app->make(ApiClientService::class));
        });

        $this->app->bind(InformacoesFiscaisService::class, function ($app) {
            return new InformacoesFiscaisService($app->make(ApiClientService::class));
        });

        $this->app->bind(InformacoesFinanceirasService::class, function ($app) {
            return new InformacoesFinanceirasService($app->make(ApiClientService::class));
        });

        $this->app->bind(PersonalizarContaService::class, function ($app) {
            return new PersonalizarContaService($app->make(ApiClientService::class));
        });

        $this->app->bind(SubcontasService::class, function ($app) {
            return new SubcontasService($app->make(ApiClientService::class));
        });

        $this->app->bind(ContaEscrowService::class, function ($app) {
            return new ContaEscrowService($app->make(ApiClientService::class));
        });

        $this->app->bind(DocumentoDeCobrancaService::class, function ($app) {
            return new DocumentoDeCobrancaService($app->make(ApiClientService::class));
        });

        $this->app->bind(CobrancaDadosResumidosService::class, function ($app) {
            return new CobrancaDadosResumidosService($app->make(ApiClientService::class));
        });

        $this->app->bind(ChargeBackService::class, function ($app) {
            return new ChargeBackService($app->make(ApiClientService::class));
        });

        $this->app->bind(ConsultaSerasaService::class, function ($app) {
            return new ConsultaSerasaService($app->make(ApiClientService::class));
        });

        $this->app->bind(EnvioDeDocumentoWhiteLabelService::class, function ($app) {
            return new EnvioDeDocumentoWhiteLabelService($app->make(ApiClientService::class));
        });

        // Registrar o serviço principal que agrupa todos
        $this->app->bind(AsaasService::class, function ($app) {
            return new AsaasService(
                $app->make(ApiClientService::class),
                $app->make(CobrancaService::class),
                $app->make(ClienteService::class),
                $app->make(AssinaturaService::class),
                $app->make(NotificacaoService::class),
                $app->make(TransferenciaService::class),
                $app->make(WebhookService::class),
                $app->make(PixService::class),
                $app->make(PixRecorrenteService::class),
                $app->make(TransacoesPixService::class),
                $app->make(CartaoDeCreditoService::class),
                $app->make(ParcelamentoService::class),
                $app->make(EstornoService::class),
                $app->make(ContaBancariaService::class),
                $app->make(LinkDePagamentoService::class),
                $app->make(CheckoutService::class),
                $app->make(SplitsService::class),
                $app->make(AntecipacoesService::class),
                $app->make(NegativacoesService::class),
                $app->make(ExtratoService::class),
                $app->make(RecargaDeCelularService::class),
                $app->make(PagamentoDeContasService::class),
                $app->make(NotaFiscalService::class),
                $app->make(InformacoesFiscaisService::class),
                $app->make(InformacoesFinanceirasService::class),
                $app->make(PersonalizarContaService::class),
                $app->make(SubcontasService::class),
                $app->make(ContaEscrowService::class),
                $app->make(DocumentoDeCobrancaService::class),
                $app->make(CobrancaDadosResumidosService::class),
                $app->make(ChargeBackService::class),
                $app->make(ConsultaSerasaService::class),
                $app->make(EnvioDeDocumentoWhiteLabelService::class)
            );
        });

        // Registrar aliases para facilitar o uso
        $this->app->alias(ApiClientService::class, 'assas.api');
        $this->app->alias(AsaasService::class, 'assas');
        $this->app->alias(CobrancaService::class, 'assas.cobranca');
        $this->app->alias(ClienteService::class, 'assas.cliente');
        $this->app->alias(AssinaturaService::class, 'assas.assinatura');
        $this->app->alias(NotificacaoService::class, 'assas.notificacao');
        $this->app->alias(TransferenciaService::class, 'assas.transferencia');
        $this->app->alias(WebhookService::class, 'assas.webhook');
        $this->app->alias(PixService::class, 'assas.pix');
        $this->app->alias(PixRecorrenteService::class, 'assas.pix.recorrente');
        $this->app->alias(TransacoesPixService::class, 'assas.pix.transacoes');
        $this->app->alias(CartaoDeCreditoService::class, 'assas.cartao.credito');
        $this->app->alias(ParcelamentoService::class, 'assas.parcelamento');
        $this->app->alias(EstornoService::class, 'assas.estorno');
        $this->app->alias(ContaBancariaService::class, 'assas.conta.bancaria');
        $this->app->alias(LinkDePagamentoService::class, 'assas.link.pagamento');
        $this->app->alias(CheckoutService::class, 'assas.checkout');
        $this->app->alias(SplitsService::class, 'assas.splits');
        $this->app->alias(AntecipacoesService::class, 'assas.antecipacoes');
        $this->app->alias(NegativacoesService::class, 'assas.negativacoes');
        $this->app->alias(ExtratoService::class, 'assas.extrato');
        $this->app->alias(RecargaDeCelularService::class, 'assas.recarga.celular');
        $this->app->alias(PagamentoDeContasService::class, 'assas.pagamento.contas');
        $this->app->alias(NotaFiscalService::class, 'assas.nota.fiscal');
        $this->app->alias(InformacoesFiscaisService::class, 'assas.informacoes.fiscais');
        $this->app->alias(InformacoesFinanceirasService::class, 'assas.informacoes.financeiras');
        $this->app->alias(PersonalizarContaService::class, 'assas.personalizar.conta');
        $this->app->alias(SubcontasService::class, 'assas.subcontas');
        $this->app->alias(ContaEscrowService::class, 'assas.conta.escrow');
        $this->app->alias(DocumentoDeCobrancaService::class, 'assas.documento.cobranca');
        $this->app->alias(CobrancaDadosResumidosService::class, 'assas.cobranca.dados.resumidos');
        $this->app->alias(ChargeBackService::class, 'assas.chargeback');
        $this->app->alias(ConsultaSerasaService::class, 'assas.consulta.serasa');
        $this->app->alias(EnvioDeDocumentoWhiteLabelService::class, 'assas.envio.documento.whitelabel');
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

        // Carregar migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');

        // Carregar traduções
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'assas-integration');

        // Mesclar configurações do método de pagamento
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/paymentmethods.php',
            'payment_methods'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php',
            'core'
        );
    }
}
