<?php

namespace Ds\AssasIntegration\Tests\Integration;

use Ds\AssasIntegration\Tests\TestCase;
use Ds\AssasIntegration\Services\CartaoDeCreditoService;
use Ds\AssasIntegration\Services\ApiClientService;

// teste individual do serviço CartaoDeCreditoService 
// php artisan test tests/Integration/CartaoDeCreditoServiceTest.php

class CartaoDeCreditoServiceTest extends TestCase
{
    protected $apiClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = app(ApiClientService::class);
    }

    /** @test */
    public function tokenizar_cartao_de_credito()
    {
        $service = new CartaoDeCreditoService($this->apiClient);

        $dados = [
            'customer' => 'cus_000006963164', 
            'creditCard' => [
                'holderName' => 'João Silva',
                'number' => '4111111111111111',
                'expiryMonth' => '12',
                'expiryYear' => '2025',
                'ccv' => '123'
            ]
        ];

        $response = $service->tokenizarCartaoDeCredito($dados);

        dump('RESPOSTA TOKENIZAR CARTÃO DE CRÉDITO:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('creditCardToken', $response);
    }
}
