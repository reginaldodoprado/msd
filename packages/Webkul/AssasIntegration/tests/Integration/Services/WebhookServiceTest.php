<?php

namespace Ds\AssasIntegration\Tests\Integration;

use Ds\AssasIntegration\Tests\TestCase;
use Ds\AssasIntegration\Services\WebhookService;
use Ds\AssasIntegration\Services\ApiClientService;

// teste individual do serviço WebhookService 
// php artisan test tests/Integration/WebhookServiceTest.php

class WebhookServiceTest extends TestCase
{
    protected $apiClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = app(ApiClientService::class);
    }

    /** @test */
    public function criar_webhook()
    {
        $service = new WebhookService($this->apiClient);

        $dados = [
            'name' => 'Webhook de Teste',
            'url' => 'https://exemplo.com/webhook',
            'email' => 'webhook@exemplo.com',
            'enabled' => true,
            'interrupted' => false,
            'apiVersion' => 3,
            'authToken' => 'token123',
            'sendType' => 'SEQUENTIALLY',
            'events' => ['PAYMENT_RECEIVED', 'PAYMENT_CONFIRMED']
        ];

        $response = $service->criarWebhook($dados);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('url', $response);
        $this->assertArrayHasKey('enabled', $response);
        $this->assertEquals('https://exemplo.com/webhook', $response['url']);

        return $response['id'];
    }

    /**
     * @test
     * @depends criar_webhook
     */
    public function listar_webhooks($webhookId)
    {
        $service = new WebhookService($this->apiClient);

        $response = $service->listarWebhooks();

        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
    }

    /**
     * @test
     * @depends criar_webhook
     */
    public function buscar_webhook($webhookId)
    {
        $service = new WebhookService($this->apiClient);

        // Busca o webhook usando o ID já criado
        $response = $service->buscarWebhook($webhookId);

      

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($webhookId, $response['id']);
    }

    /**
     * @test
     * @depends criar_webhook
     */
    public function atualizar_webhook($webhookId)
    {
        $service = new WebhookService($this->apiClient);

        // Atualiza o webhook usando o ID já criado
        $dadosAtualizados = [
            'url' => 'https://exemplo-atualizado.com/webhook',
            'enabled' => false
        ];

        $response = $service->atualizarWebhook($webhookId, $dadosAtualizados);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($webhookId, $response['id']);
    }

    /**
     * @test
     * @depends criar_webhook
     */
    public function remover_webhook($webhookId)
    {
        $service = new WebhookService($this->apiClient);

        // Remove o webhook usando o ID já criado
        $response = $service->removerWebhook($webhookId);

       

        $this->assertIsArray($response);
    }
}
